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
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\StationsErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\StationsErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\StationEntity;
use CodeKandis\TradioApi\Environment\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UriExtenders\StationApiUriExtender;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\StationsRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve a specific station.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationAction extends AbstractAction
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
		$inputData = $this->getInputData();

		$station = $this->readStationById(
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

		$this->extendUris( $station );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'station' => $station
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
	 * Extends the URIs of a station.
	 * @param StationEntityInterface $station The station to extend its URIs.
	 */
	private function extendUris( StationEntityInterface $station ): void
	{
		( new StationApiUriExtender(
			$this->getApiUriBuilder(),
			$station
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
	private function readStationById( StationEntityInterface $station ): ?StationEntityInterface
	{
		return ( new StationsRepository(
			$this->getPersistenceConnector()
		) )
			->readStationById( $station );
	}
}
