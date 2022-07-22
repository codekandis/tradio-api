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
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\FavoriteTracksErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\FavoriteTracksErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UriExtenders\FavoriteTrackApiUriExtender;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve a specific favored track.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteTrackAction extends AbstractAction
{
	/**
	 * {@inheritDoc}
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
					'id' => $inputData[ 'favoriteTrackId' ]
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

		$this->extendUris( $favoriteTrack );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'favoriteTrack' => $favoriteTrack
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
	 * Extends the URIs of a favored track.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track to extend its URIs.
	 */
	private function extendUris( FavoriteTrackEntityInterface $favoriteTrack ): void
	{
		( new FavoriteTrackApiUriExtender(
			$this->getApiUriBuilder(),
			$favoriteTrack
		) )
			->extend();
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
	private function readFavoriteTrackById( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntity
	{
		return ( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoriteTrackById( $favoriteTrack );
	}
}
