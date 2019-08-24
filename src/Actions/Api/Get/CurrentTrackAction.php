<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Exceptions\ErrorInformation;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\Tiphy\Persistence\MariaDb\ConnectorInterface;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\CurrentTrackUriExtender;
use CodeKandis\TradioApi\Errors\StationsErrorCodes;
use CodeKandis\TradioApi\Errors\StationsErrorMessages;
use CodeKandis\TradioApi\Http\Readers\CurrentTrackReader;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use ReflectionException;

class CurrentTrackAction extends AbstractAction
{
	/** @var ConnectorInterface */
	private $databaseConnector;

	/** @var ApiUriBuilder */
	private $uriBuilder;

	private function getDatabaseConnector(): ConnectorInterface
	{
		if ( null === $this->databaseConnector )
		{
			$databaseConfig          = ConfigurationRegistry::_()->getPersistenceConfiguration();
			$this->databaseConnector = new Connector( $databaseConfig );
		}

		return $this->databaseConnector;
	}

	private function getUriBuilder(): ApiUriBuilder
	{
		if ( null === $this->uriBuilder )
		{
			$uriBuilderConfiguration = ConfigurationRegistry::_()->getUriBuilderConfiguration();
			$this->uriBuilder        = new ApiUriBuilder( $uriBuilderConfiguration );
		}

		return $this->uriBuilder;
	}

	/**
	 * @throws PersistenceException
	 * @throws ReflectionException
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$requestedStation     = new StationEntity();
		$requestedStation->id = $inputData[ 'id' ];
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
		$favorite                = $this->readFavoriteByTrackName( $requestedFavorite );
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
		$uriBuilder = $this->getUriBuilder();
		( new CurrentTrackUriExtender( $uriBuilder, $currentTrack, $station, $favorite ) )
			->extend();
	}

	/**
	 * @throws PersistenceException
	 */
	private function readStation( StationEntity $requestedStation ): ?StationEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new StationsRepository( $databaseConnector ) )
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
	private function readFavoriteByTrackName( FavoriteEntity $requestedFavorite ): ?FavoriteEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new FavoritesRepository( $databaseConnector ) )
			->readFavoriteByTrackName( $requestedFavorite );
	}
}
