<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Read;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\Tiphy\Persistence\MariaDb\ConnectorInterface;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\Readers\CurrentTrackReader;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use ReflectionException;

class GetCurrentTrackAction extends AbstractAction
{
	/** @var ConnectorInterface */
	private $databaseConnector;

	/** @var ApiUriBuilder */
	private $uriBuilder;

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
			$responder = new JsonResponder( StatusCodes::NOT_FOUND, null );
			$responder->respond();

			return;
		}

		$currentTrack = $this->readCurrentTrack( $station );
		$this->addCurrentTrackUri( $currentTrack, $station );
		$this->addStationId( $currentTrack, $station );
		$this->addStationUri( $currentTrack, $station );

		$responderData = [
			'currentTrack' => $currentTrack
		];
		$responder     = new JsonResponder( StatusCodes::OK, $responderData );
		$responder->respond();
	}

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
	 * @return string[]
	 */
	private function getInputData(): array
	{
		return $this->arguments;
	}

	private function addCurrentTrackUri( CurrentTrackEntity $currentTrack, StationEntity $station ): void
	{
		$currentTrack->uri = $this->getUriBuilder()->getCurrentTrackUri( $station->id );
	}

	private function addStationId( CurrentTrackEntity $currentTrack, StationEntity $station ): void
	{
		$currentTrack->stationId = $station->id;
	}

	private function addStationUri( CurrentTrackEntity $currentTrack, StationEntity $station ): void
	{
		$currentTrack->stationUri = $this->getUriBuilder()->getStationUri( $station->id );
	}

	/**
	 * @throws PersistenceException
	 */
	private function readStation( StationEntity $requestedChild ): ?StationEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new StationsRepository( $databaseConnector ) )
			->readStationById( $requestedChild );
	}

	private function readCurrentTrack( StationEntity $station ): CurrentTrackEntity
	{
		$currentTrack       = new CurrentTrackEntity();
		$currentTrack->name = ( new CurrentTrackReader() )
			->read( $station->tracklistUri, $station->currentTrackXPath );

		return $currentTrack;
	}
}
