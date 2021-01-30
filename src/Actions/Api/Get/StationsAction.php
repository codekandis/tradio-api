<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\StationApiUriExtender;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use JsonException;

class StationsAction extends AbstractWithDatabaseConnectorAndApiUriBuilderAction
{
	/**
	 * @throws PersistenceException
	 * @throws JsonException
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
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $stations as $station )
		{
			( new StationApiUriExtender( $apiUriBuilder, $station ) )
				->extend();
		}
	}

	/**
	 * @return StationEntity[]
	 * @throws PersistenceException
	 */
	private function readStations(): array
	{
		return ( new StationsRepository(
			$this->getDatabaseConnector()
		) )
			->readStations();
	}
}
