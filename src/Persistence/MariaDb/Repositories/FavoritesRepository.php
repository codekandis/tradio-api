<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Tiphy\Persistence\MariaDb\Repositories\AbstractRepository;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UserEntity;

class FavoritesRepository extends AbstractRepository
{
	/**
	 * @return FavoriteEntity[]
	 * @throws PersistenceException
	 */
	public function readFavorites(): array
	{
		$query = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			ORDER BY
			    `favorites`.`name` ASC;
		END;

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity[] $resultSet */
			$resultSet = $this->databaseConnector->queryPrepared( $query, null, FavoriteEntity::class );
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
	public function readFavoriteById( FavoriteEntity $favorite ): ?FavoriteEntity
	{
		$query = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			WHERE
				`favorites`.`id` = :favoriteId
			LIMIT
				0, 1;
		END;

		$arguments = [
			'favoriteId' => $favorite->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity $result */
			$result = $this->databaseConnector->queryFirstPrepared( $query, $arguments, FavoriteEntity::class );
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
	 * @throws PersistenceException
	 */
	public function readFavoriteByTrackName( FavoriteEntity $favorite ): ?FavoriteEntity
	{
		$query = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			WHERE
				`favorites`.`name` = :name
			LIMIT
				0, 1;
		END;

		$arguments = [
			'name' => $favorite->name
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity $result */
			$result = $this->databaseConnector->queryFirstPrepared( $query, $arguments, FavoriteEntity::class );
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
	 * @return FavoriteEntity[]
	 * @throws PersistenceException
	 */
	public function readFavoritesByStationId( StationEntity $station ): array
	{
		$query = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			INNER JOIN
				`stations_favorites`
				ON
				`stations_favorites`.`stationId` = :stationId
			WHERE
				`favorites`.`id` = `stations_favorites`.`favoriteId`
			ORDER BY
			    `favorites`.`name` ASC;
		END;

		$arguments = [
			'stationId' => $station->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity[] $resultSet */
			$resultSet = $this->databaseConnector->queryPrepared( $query, $arguments, FavoriteEntity::class );
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
	 * @return FavoriteEntity[]
	 * @throws PersistenceException
	 */
	public function readFavoritesByUserId( UserEntity $user ): array
	{
		$query = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			INNER JOIN
				`users_favorites`
				ON
				`users_favorites`.`userId` = :userId
			WHERE
				`favorites`.`id` = `users_favorites`.`favoriteId`
			ORDER BY
			    `favorites`.`name` ASC;
		END;

		$arguments = [
			'userId' => $user->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity[] $resultSet */
			$resultSet = $this->databaseConnector->queryPrepared( $query, $arguments, FavoriteEntity::class );
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