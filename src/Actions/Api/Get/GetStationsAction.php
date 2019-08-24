<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\Tiphy\Persistence\MariaDb\ConnectorInterface;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\StationUriExtender;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use ReflectionException;

class GetStationsAction extends AbstractAction
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
		$stations = $this->readStations();
		$this->extendUris( $stations );

		$responderData = [
			'stations' => $stations,
		];
		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
	}

	/**
	 * @param StationEntity[] $stations
	 */
	private function extendUris( array $stations ): void
	{
		$uriBuilder = $this->getUriBuilder();
		foreach ( $stations as $station )
		{
			( new StationUriExtender( $uriBuilder, $station ) )
				->extend();
		}
	}

	/**
	 * @return StationEntity[]
	 * @throws PersistenceException
	 */
	private function readStations(): array
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new StationsRepository( $databaseConnector ) )
			->readStations();
	}
}
