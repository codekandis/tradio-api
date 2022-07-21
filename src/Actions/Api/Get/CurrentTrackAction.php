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
use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\CurrentTrackEntityInterface;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Entities\UriExtenders\CurrentTrackApiUriExtender;
use CodeKandis\TradioApi\Errors\CurlException;
use CodeKandis\TradioApi\Errors\StationsErrorCodes;
use CodeKandis\TradioApi\Errors\StationsErrorMessages;
use CodeKandis\TradioApi\Http\Readers\CurrentTrackReader;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve the currently playing track of a specific station.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackAction extends AbstractWithPersistenceConnectorAndApiUriBuilderAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws ReflectionException An error occurred during the creation of the current track entity.
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

		$station = $this->readStation(
			StationEntity::fromArray(
				[
					'id' => $inputData[ 'stationId' ]
				]
			)
		);

		if ( null === $station )
		{
			( new JsonResponder(
				StatusCodes::NOT_FOUND,
				null,
				new ErrorInformation( StationsErrorCodes::STATION_UNKNOWN, StationsErrorMessages::STATION_UNKNOWN, $inputData )
			) )
				->respond();

			return;
		}

		try
		{
			$currentTrack = $this->readCurrentTrack( $station );
		}
		catch ( CurlException $exception )
		{
			( new JsonResponder(
				StatusCodes::SERVICE_UNAVAILABLE,
				null,
				new ErrorInformation( StationsErrorCodes::STATION_NOT_REACHABLE, StationsErrorMessages::STATION_NOT_REACHABLE, $inputData )
			) )
				->respond();

			return;
		}

		$favoriteTrack = $this->readFavoriteTrackByName(
			FavoriteTrackEntity::fromArray(
				[
					'name' => $currentTrack->getName()
				]
			)
		);
		$this->extendUris( $currentTrack, $station, $favoriteTrack );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'currentTrack' => $currentTrack
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
	 * Extends the URIs of a currently playing track.
	 * @param CurrentTrackEntityInterface $currentTrack The currently playing track to extend its URIs.
	 * @param StationEntityInterface $station The station currently playing the track.
	 * @param ?FavoriteTrackEntityInterface $favoriteTrack The favored track whom the currently playing track is related with.
	 */
	private function extendUris( CurrentTrackEntityInterface $currentTrack, StationEntityInterface $station, ?FavoriteTrackEntityInterface $favoriteTrack ): void
	{
		( new CurrentTrackApiUriExtender(
			$this->getApiUriBuilder(),
			$currentTrack,
			$station,
			$favoriteTrack
		) )
			->extend();
	}

	/**
	 * Reads a station by its ID.
	 * @param StationEntityInterface $station The station with the ID to search for.
	 * @return ?StationEntityInterface The station if found, otherwise null.
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readStation( StationEntityInterface $station ): ?StationEntityInterface
	{
		return ( new StationsRepository(
			$this->getPersistenceConnector()
		) )
			->readStationById( $station );
	}

	/**
	 * Gets the currently playing track of a specific station.
	 * @param StationEntityInterface $station The station to read the currently playing track from.
	 * @return CurrentTrackEntityInterface The currently playing track.
	 * @throws CurlException An error occured during a CURL operation.
	 * @throws ReflectionException An error occurred during the creation of the current track entity.
	 */
	private function readCurrentTrack( StationEntityInterface $station ): CurrentTrackEntityInterface
	{
		return CurrentTrackEntity::fromArray(
			[
				'stationId' => $station->getId(),
				'name'      => ( new CurrentTrackReader() )
					->read(
						$station->getTracklistUri(),
						$station->getCurrentTrackXPath()
					)
			]
		);
	}

	/**
	 * Reads a favored track by its name.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track with the name to search for.
	 * @return ?FavoriteTrackEntityInterface The favored track if found, otherwise null.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavoriteTrackByName( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface
	{
		return ( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoriteTrackByName( $favoriteTrack );
	}
}
