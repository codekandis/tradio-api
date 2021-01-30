<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\CurrentTrackApiUriExtender;
use CodeKandis\TradioApi\Errors\StationsErrorCodes;
use CodeKandis\TradioApi\Errors\StationsErrorMessages;
use CodeKandis\TradioApi\Http\Readers\CurrentTrackReader;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use JsonException;

class CurrentTrackAction extends AbstractWithDatabaseConnectorAndApiUriBuilderAction
{
	/**
	 * @throws PersistenceException
	 * @throws JsonException
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$requestedStation     = new StationEntity();
		$requestedStation->id = $inputData[ 'stationId' ];
		$station              = $this->readStation( $requestedStation );

		if ( null === $station )
		{
			$errorInformation = new ErrorInformation( StationsErrorCodes::STATION_UNKNOWN, StationsErrorMessages::STATION_UNKNOWN, $inputData );
			( new JsonResponder( StatusCodes::NOT_FOUND, null, $errorInformation ) )
				->respond();

			return;
		}

		$currentTrack            = $this->readCurrentTrack( $station );
		$requestedFavorite       = new FavoriteEntity();
		$requestedFavorite->name = $currentTrack->name;
		$favorite                = $this->readFavoriteByName( $requestedFavorite );
		$this->extendUris( $currentTrack, $station, $favorite );

		$responderData = [
			'currentTrack' => $currentTrack
		];

		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
	}

	/**
	 * @return string[]
	 */
	private function getInputData(): array
	{
		return $this->arguments;
	}

	private function extendUris( CurrentTrackEntity $currentTrack, StationEntity $station, ?FavoriteEntity $favorite ): void
	{
		( new CurrentTrackApiUriExtender(
			$this->getApiUriBuilder(),
			$currentTrack,
			$station,
			$favorite
		) )
			->extend();
	}

	/**
	 * @throws PersistenceException
	 */
	private function readStation( StationEntity $requestedStation ): ?StationEntity
	{
		return ( new StationsRepository(
			$this->getDatabaseConnector()
		) )
			->readStationById( $requestedStation );
	}

	private function readCurrentTrack( StationEntity $station ): CurrentTrackEntity
	{
		$currentTrack            = new CurrentTrackEntity();
		$currentTrack->name      = ( new CurrentTrackReader() )
			->read( $station->tracklistUri, $station->currentTrackXPath );
		$currentTrack->stationId = $station->id;

		return $currentTrack;
	}

	/**
	 * @throws PersistenceException
	 */
	private function readFavoriteByName( FavoriteEntity $requestedFavorite ): ?FavoriteEntity
	{
		return ( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->readFavoriteByName( $requestedFavorite );
	}
}
