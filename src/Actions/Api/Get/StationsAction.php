<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Actions\AbstractWithPersistenceConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\Collections\StationEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\UriExtenders\StationApiUriExtender;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve all stations.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationsAction extends AbstractWithPersistenceConnectorAndApiUriBuilderAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		$stations = $this->readStations();
		$this->extendUris( $stations );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'stations' => $stations,
			]
		) )
			->respond();
	}

	/**
	 * Extends the URIs of a list of stations.
	 * @param StationEntityCollectionInterface $stations The stations to extend their URIs.
	 */
	private function extendUris( StationEntityCollectionInterface $stations ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $stations as $station )
		{
			( new StationApiUriExtender( $apiUriBuilder, $station ) )
				->extend();
		}
	}

	/**
	 * Reads all stations.
	 * @return StationEntityCollectionInterface The stations.
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readStations(): StationEntityCollectionInterface
	{
		return ( new StationsRepository(
			$this->getPersistenceConnector()
		) )
			->readStations();
	}
}
