<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Tiphy\Persistence\MariaDb\Repositories\AbstractRepository;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UserEntity;

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
			$resultSet = $this->databaseConnector->query( $query, null, StationEntity::class );
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
			$result = $this->databaseConnector->queryFirst( $query, $arguments, StationEntity::class );
			$this->databaseConnector->commit();
		}
		catch ( PersistenceException $exception )
		{
			$this->databaseConnector->rollback();
			throw $exception;
		}

		return $result;
	}

	/**
	 * @return StationEntity[]
	 * @throws PersistenceException
	 */
	public function readStationsByUserId( UserEntity $user ): array
	{
		$query = <<< END
			SELECT
				`stations`.*
			FROM
				`stations`
			INNER JOIN
				`users_stations`
				ON
				`users_stations`.`userId` = :userId
			WHERE
				`stations`.`id` = `users_stations`.`stationId`
			ORDER BY
				`stations`.`name` ASC;
		END;

		$arguments = [
			'userId' => $user->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var StationEntity[] $resultSet */
			$resultSet = $this->databaseConnector->query( $query, $arguments, StationEntity::class );
			$this->databaseConnector->commit();
		}
		catch ( PersistenceException $exception )
		{
			$this->databaseConnector->rollback();
			throw $exception;
		}

		return $resultSet;
	}
}
