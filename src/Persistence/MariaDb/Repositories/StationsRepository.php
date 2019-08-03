<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Tiphy\Persistence\MariaDb\Repositories\AbstractRepository;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Entities\StationEntity;

class StationsRepository extends AbstractRepository
{
	/**
	 * @return StationEntity[]
	 * @throws PersistenceException
	 */
	public function readStations(): array
	{
		$query = <<< END
			SELECT
				`stations`.*
			FROM
				`stations`
			ORDER BY
			    `stations`.`name` ASC;
		END;

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var StationEntity[] $resultSet */
			$resultSet = $this->databaseConnector->queryPrepared( $query, null, StationEntity::class );
			$this->databaseConnector->commit();
		}
		catch ( PersistenceException $exception )
		{
			$this->databaseConnector->rollback();
			throw $exception;
		}

		return $resultSet;
	}

	/**
	 * @throws PersistenceException
	 */
	public function readStationById( StationEntity $station ): ?StationEntity
	{
		$query = <<< END
			SELECT
				`stations`.*
			FROM
				`stations`
			WHERE
				`stations`.`id` = :stationId
			LIMIT
				0, 1;
		END;

		$arguments = [
			'stationId' => $station->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var StationEntity $result */
			$result = $this->databaseConnector->queryFirstPrepared( $query, $arguments, StationEntity::class );
			$this->databaseConnector->commit();
		}
		catch ( PersistenceException $exception )
		{
			$this->databaseConnector->rollback();
			throw $exception;
		}

		return $result;
	}
}
