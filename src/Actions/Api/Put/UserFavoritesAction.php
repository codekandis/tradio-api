<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Put;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\InvalidArgumentsStatementsCountException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\ContentTypes;
use CodeKandis\Tiphy\Http\Requests\BadRequestException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithPersistenceConnectorAction;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollection;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Errors\CommonErrorCodes;
use CodeKandis\TradioApi\Errors\CommonErrorMessages;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;
use stdClass;
use function array_map;
use function is_object;
use function strtolower;

class UserFavoritesAction extends AbstractWithPersistenceConnectorAction
{
	/**
	 * {@inheritDoc}
	 * @throws BadRequestException The content type is invalid.
	 * @throws BadRequestException The request body is malformed.
	 * @throws BadRequestException The request body is invalid.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		try
		{
			$inputData = $this->getInputData();
		}
		catch ( BadRequestException $exception )
		{
			( new JsonResponder(
				StatusCodes::BAD_REQUEST,
				null,
				new ErrorInformation( $exception->getCode(), $exception->getMessage() )
			) )
				->respond();

			return;
		}

		$user = $this->readUser(
			UserEntity::fromArray(
				[
					'id' => $inputData[ 'userId' ]
				]
			)
		);

		if ( null === $user )
		{
			( new JsonResponder(
				StatusCodes::BAD_REQUEST,
				null,
				new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN )
			) )
				->respond();

			return;
		}

		$this->createFavoritesByUserId(
			new FavoriteEntityCollection(
				...array_map(
					function ( stdClass $favorite )
					{
						return FavoriteEntity::fromObject( $favorite );
					},
					$inputData[ 'favorites' ]
				)
			),
			$user
		);

		( new JsonResponder( StatusCodes::OK, null ) )
			->respond();
	}

	/**
	 * Gets the input data of the request.
	 * @return array The input data of the request.
	 * @throws BadRequestException The content type is invalid.
	 * @throws BadRequestException The request body is malformed.
	 * @throws BadRequestException The request body is invalid.
	 */
	private function getInputData(): array
	{
		if ( ContentTypes::APPLICATION_JSON !== strtolower( $_SERVER[ 'CONTENT_TYPE' ] ) )
		{
			throw new BadRequestException( CommonErrorMessages::INVALID_CONTENT_TYPE, CommonErrorCodes::INVALID_CONTENT_TYPE );
		}
		$requestBody = $this->requestBody->getContent();

		$isValid = is_object( $requestBody );
		if ( false === $isValid )
		{
			throw new BadRequestException( CommonErrorMessages::MALFORMED_REQUEST_BODY, CommonErrorCodes::MALFORMED_REQUEST_BODY );
		}

		$bodyData     = [];
		$requiredKeys = [
			'favorites'
		];

		$isValid = true;
		foreach ( $requiredKeys as $requiredKey )
		{
			$isValid = $isValid && isset( $requestBody->{$requiredKey} );
			if ( false === $isValid )
			{
				break;
			}
			$bodyData[ $requiredKey ] = $requestBody->{$requiredKey};
		}
		if ( false === $isValid )
		{
			throw new BadRequestException( CommonErrorMessages::INVALID_REQUEST_BODY, CommonErrorCodes::INVALID_REQUEST_BODY );
		}

		$argumentsData = $this->arguments;

		return $bodyData + $argumentsData;
	}

	/**
	 * Reads a user by its ID.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return ?UserEntityInterface The user if found, otherwise null.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readUser( UserEntityInterface $user ): ?UserEntityInterface
	{
		return ( new UsersRepository(
			$this->getPersistenceConnector()
		) )
			->readUserById( $user );
	}

	/**
	 * Creates a favorite track for a specific user.
	 * @param FavoriteEntityCollectionInterface $favorites The favorite tracks to create.
	 * @param UserEntityInterface $user The user with the ID whom the favorite track is related with.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 */
	private function createFavoritesByUserId( FavoriteEntityCollectionInterface $favorites, UserEntityInterface $user ): void
	{
		$this->getPersistenceConnector()
			 ->asTransaction(
				 function () use ( $favorites, $user )
				 {
					 $favoriteRepository = new FavoritesRepository(
						 $this->getPersistenceConnector()
					 );
					 foreach ( $favorites as $favorite )
					 {
						 $favoriteRepository->createFavoriteByUserId( $favorite, $user );
					 }
				 }
			 );
	}
}
