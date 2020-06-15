<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Tiphy\Persistence\MariaDb\Repositories\AbstractRepository;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
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
				`favorites`.`createdOn` DESC;
		END;

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity[] $resultSet */
			$resultSet = $this->databaseConnector->query( $query, null, FavoriteEntity::class );
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
			$result = $this->databaseConnector->queryFirst( $query, $arguments, FavoriteEntity::class );
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
	public function readFavoriteByName( FavoriteEntity $favorite ): ?FavoriteEntity
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
			$result = $this->databaseConnector->queryFirst( $query, $arguments, FavoriteEntity::class );
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
				`favorites`.`createdOn` DESC;
		END;

		$arguments = [
			'userId' => $user->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			/** @var FavoriteEntity[] $resultSet */
			$resultSet = $this->databaseConnector->query( $query, $arguments, FavoriteEntity::class );
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
	public function writeFavoriteByUserId( FavoriteEntity $favoriteEntity, UserEntity $user ): void
	{
		$query = <<< END
			INSERT INTO
				`favorites`
				( `id`, `name`, `createdOn` )
			VALUES
				( UUID( ), LOWER( :favoriteName ), :createdOn )
			ON DUPLICATE KEY UPDATE
				`createdOn` = IF ( `createdOn` IS NULL OR `createdOn` > :createdOn, :createdOn, `createdOn` );

			INSERT IGNORE INTO
				`users_favorites`
				( `id`, `userId`, `favoriteId`)
			SELECT
				UUID( ),
				:userId,
				`favorites`.`id`
			FROM
				`favorites`
			WHERE
				`favorites`.`name` = :favoriteName;
		END;

		$arguments = [
			'userId'       => $user->id,
			'favoriteName' => $favoriteEntity->name,
			'createdOn'    => $favoriteEntity->createdOn
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			$this->databaseConnector->execute( $query, $arguments );
			$this->databaseConnector->commit();
		}
		catch ( PersistenceException $exception )
		{
			$this->databaseConnector->rollback();
			throw $exception;
		}
	}

	/**
	 * @throws PersistenceException
	 */
	public function deleteFavoriteByUserId( FavoriteEntity $favorite, UserEntity $user ): void
	{
		$query = <<< END
			DELETE
			FROM
				`users_favorites`
			WHERE
				`users_favorites`.`userId` = :userId
				AND
				`users_favorites`.`favoriteId` = :favoriteId;

			DELETE
				`favorites`
			FROM
				`favorites`
			LEFT JOIN
				`users_favorites`
			ON
				`users_favorites`.`favoriteId` = `favorites`.`id`
			WHERE
				`users_favorites`.`id` IS NULL;
			
		END;

		$arguments = [
			'userId'     => $user->id,
			'favoriteId' => $favorite->id
		];

		try
		{
			$this->databaseConnector->beginTransaction();
			$this->databaseConnector->execute( $query, $arguments );
			$this->databaseConnector->commit();
		}
		catch ( PersistenceException $exception )
		{
			$this->databaseConnector->rollback();
			throw $exception;
		}
	}
}
