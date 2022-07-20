<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithPersistenceConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\UriExtenders\FavoriteApiUriExtender;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve a users' favored tracks.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserFavoritesAction extends AbstractWithPersistenceConnectorAndApiUriBuilderAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$user = $this->readUserById(
			UserEntity::fromArray(
				[
					'id' => $inputData[ 'userId' ]
				]
			)
		);

		if ( null === $user )
		{
			( new JsonResponder(
				StatusCodes::NOT_FOUND,
				null,
				new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN, $inputData )
			) )
				->respond();

			return;
		}

		$favorites = $this->readFavoritesByUserId( $user );
		$this->extendUris( $favorites );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'favorites' => $favorites,
			]
		) )
			->respond();
	}

	/**
	 * Gets the input data of the request.
	 * @return string[] The input data of the request.
	 */
	private function getInputData(): array
	{
		return $this->arguments;
	}

	/**
	 * Extends the URIs of a list of favored tracks.
	 * @param FavoriteEntityCollectionInterface $favorites The favored tracks to extend their URIs.
	 */
	private function extendUris( FavoriteEntityCollectionInterface $favorites ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $favorites as $favorite )
		{
			( new FavoriteApiUriExtender( $apiUriBuilder, $favorite ) )
				->extend();
		}
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
	private function readUserById( UserEntityInterface $user ): ?UserEntityInterface
	{
		return ( new UsersRepository(
			$this->getPersistenceConnector()
		) )
			->readUserById( $user );
	}

	/**
	 * Reads all favored tracks by a specific user ID.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return FavoriteEntityCollectionInterface The favored tracks.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavoritesByUserId( UserEntityInterface $user ): FavoriteEntityCollectionInterface
	{
		return ( new FavoritesRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoritesByUserId( $user );
	}
}
