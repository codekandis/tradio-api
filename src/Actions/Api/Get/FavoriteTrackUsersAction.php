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
use CodeKandis\TradioApi\Entities\Collections\UserEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Entities\UriExtenders\UserApiUriExtender;
use CodeKandis\TradioApi\Errors\FavoriteTracksErrorCodes;
use CodeKandis\TradioApi\Errors\FavoriteTracksErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve a favored tracks' users.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteTrackUsersAction extends AbstractWithPersistenceConnectorAndApiUriBuilderAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$favoriteTrack = $this->readFavoriteTrackById(
			FavoriteTrackEntity::fromArray(
				[
					'id' => $inputData[ 'favoriteId' ]
				]
			)
		);

		if ( null === $favoriteTrack )
		{
			( new JsonResponder(
				StatusCodes::NOT_FOUND,
				null,
				new ErrorInformation( FavoriteTracksErrorCodes::FAVORITE_TRACK_UNKNOWN, FavoriteTracksErrorMessages::FAVORITE_TRACK_UNKNOWN, $inputData )
			) )
				->respond();

			return;
		}

		$users = $this->readUsersByFavoriteTrackId( $favoriteTrack );
		$this->extendUris( $users );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'users' => $users,
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
	 * Extends the URIs of a list of users.
	 * @param UserEntityCollectionInterface $users The users to extend their URIs.
	 */
	private function extendUris( UserEntityCollectionInterface $users ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $users as $user )
		{
			( new UserApiUriExtender( $apiUriBuilder, $user ) )
				->extend();
		}
	}

	/**
	 * Reads a favored track by its ID.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track with the ID to search for.
	 * @return ?FavoriteTrackEntityInterface The favored track if found, otherwise null.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavoriteTrackById( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface
	{
		return ( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoriteTrackById( $favoriteTrack );
	}

	/**
	 * Reads all users by a specific favored track ID.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track with the ID to search for.
	 * @return UserEntityCollectionInterface The users.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readUsersByFavoriteTrackId( FavoriteTrackEntityInterface $favoriteTrack ): UserEntityCollectionInterface
	{
		return ( new UsersRepository(
			$this->getPersistenceConnector()
		) )
			->readUsersByFavoriteTrackId( $favoriteTrack );
	}
}
