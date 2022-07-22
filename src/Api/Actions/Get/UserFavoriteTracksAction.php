<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions\Get;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Api\Actions\AbstractAction;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\UriExtenders\FavoriteTrackApiUriExtender;
use CodeKandis\TradioApi\Environment\Entities\UserEntity;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve a specific favored track of a specific user.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserFavoriteTracksAction extends AbstractAction
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

		$favoriteTracks = $this->readFavoriteTracksByUserId( $user );
		$this->extendUris( $favoriteTracks );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'favoriteTracks' => $favoriteTracks,
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
	 * @param FavoriteTrackEntityCollectionInterface $favoriteTracks The favored tracks to extend their URIs.
	 */
	private function extendUris( FavoriteTrackEntityCollectionInterface $favoriteTracks ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $favoriteTracks as $favoriteTrack )
		{
			( new FavoriteTrackApiUriExtender( $apiUriBuilder, $favoriteTrack ) )
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
	 * @return FavoriteTrackEntityCollectionInterface The favored tracks.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavoriteTracksByUserId( UserEntityInterface $user ): FavoriteTrackEntityCollectionInterface
	{
		return ( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoriteTracksByUserId( $user );
	}
}
