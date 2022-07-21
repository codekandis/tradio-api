<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions\Put;

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
use CodeKandis\TradioApi\Api\Actions\AbstractAction;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollection;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\CommonErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\CommonErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Environment\Entities\UserEntity;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;
use stdClass;
use function array_map;
use function is_object;
use function strtolower;

class UserFavoriteTracksAction extends AbstractAction
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

		$this->createFavoriteTracksByUserId(
			new FavoriteTrackEntityCollection(
				...array_map(
					function ( stdClass $favoriteTrack )
					{
						return FavoriteTrackEntity::fromObject( $favoriteTrack );
					},
					$inputData[ 'favoriteTracks' ]
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
			'favoriteTracks'
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
	 * Creates favored tracks of a specific user.
	 * @param FavoriteTrackEntityCollectionInterface $favoriteTracks The favored tracks to create.
	 * @param UserEntityInterface $user The user with the ID whom the favored track is related with.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 */
	private function createFavoriteTracksByUserId( FavoriteTrackEntityCollectionInterface $favoriteTracks, UserEntityInterface $user ): void
	{
		$this->getPersistenceConnector()
			 ->asTransaction(
				 function () use ( $favoriteTracks, $user )
				 {
					 $favoriteTrackRepository = new FavoriteTracksRepository(
						 $this->getPersistenceConnector()
					 );
					 foreach ( $favoriteTracks as $favoriteTrack )
					 {
						 $favoriteTrackRepository->createFavoriteTrackByUserId( $favoriteTrack, $user );
					 }
				 }
			 );
	}
}
