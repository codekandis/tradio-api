<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Tiphy\Persistence\MariaDb\Repositories\AbstractRepository;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UserEntity;

class UsersRepository extends AbstractRepository
{
	/**
	 * @return UserEntity[]
	 * @throws PersistenceException
	 */
	public function readUsers(): array
	{
		$query = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			ORDER BY
				`users`.`name` ASC;
		END;

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var UserEntity[] $resultSet */
			$resultSet = $this->databaseConnector->query( $query, null, UserEntity::class );
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
	public function readUserById( UserEntity $user ): ?UserEntity
	{
		$query = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			WHERE
				`users`.`id` = :userId
			LIMIT
				0, 1;
		END;

		$arguments = [
			'userId' => $user->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var UserEntity $result */
			$result = $this->databaseConnector->queryFirst( $query, $arguments, UserEntity::class );
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
	 * @return UserEntity[]
	 * @throws PersistenceException
	 */
	public function readUsersByStationId( StationEntity $station ): array
	{
		$query = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			INNER JOIN
				`users_stations`
				ON
				`users_stations`.`stationId` = :stationId
			WHERE
				`users`.`id` = `users_stations`.`userId`
			ORDER BY
				`users`.`name` ASC;
		END;

		$arguments = [
			'stationId' => $station->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var UserEntity[] $resultSet */
			$resultSet = $this->databaseConnector->query( $query, $arguments, UserEntity::class );
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
	 * @return UserEntity[]
	 * @throws PersistenceException
	 */
	public function readUsersByFavoriteId( FavoriteEntity $favorite ): array
	{
		$query = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			INNER JOIN
				`users_favorites`
				ON
				`users_favorites`.`favoriteId` = :favoriteId
			WHERE
				`users`.`id` = `users_favorites`.`userId`
			ORDER BY
				`users`.`name` ASC;
		END;

		$arguments = [
			'favoriteId' => $favorite->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var UserEntity[] $resultSet */
			$resultSet = $this->databaseConnector->query( $query, $arguments, UserEntity::class );
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
