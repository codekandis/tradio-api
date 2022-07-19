<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\InvalidArgumentsStatementsCountException;
use CodeKandis\Persistence\Repositories\AbstractRepository;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollection;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\EntityPropertyMappings\EntityPropertyMapperBuilder;
use CodeKandis\TradioApi\Entities\FavoriteEntityInterface;
use CodeKandis\TradioApi\Entities\UserEntityInterface;
use ReflectionException;

/**
 * Represents the MariaDB repository of the favorite track entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoritesRepository extends AbstractRepository implements FavoritesRepositoryInterface
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readFavorites(): FavoriteEntityCollectionInterface
	{
		$statement = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			ORDER BY
				`favorites`.timestampCreated DESC;
		END;

		$favoriteEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteEntityPropertyMapper();

		return new FavoriteEntityCollection(
			...$this->persistenceConnector->query( $statement, null, $favoriteEntityPropertyMapper )
		);
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readFavoriteById( FavoriteEntityInterface $favorite ): ?FavoriteEntityInterface
	{
		$statement = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			WHERE
				`favorites`.`id` = :favoriteId
			LIMIT
				0, 1;
		END;

		$favoriteEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteEntityPropertyMapper();

		$mappedFavorite = $favoriteEntityPropertyMapper->mapToArray( $favorite );

		$arguments = [
			'favoriteId' => $mappedFavorite[ 'id' ]
		];

		return $this->persistenceConnector->queryFirst( $statement, $arguments, $favoriteEntityPropertyMapper );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readFavoriteByName( FavoriteEntityInterface $favorite ): ?FavoriteEntityInterface
	{
		$statement = <<< END
			SELECT
				`favorites`.*
			FROM
				`favorites`
			WHERE
				`favorites`.`name` = :name
			LIMIT
				0, 1;
		END;

		$favoriteEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteEntityPropertyMapper();

		$mappedFavorite = $favoriteEntityPropertyMapper->mapToArray( $favorite );

		$arguments = [
			'name' => $mappedFavorite[ 'name' ]
		];

		return $this->persistenceConnector->queryFirst( $statement, $arguments, $favoriteEntityPropertyMapper );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readFavoritesByUserId( UserEntityInterface $user ): FavoriteEntityCollectionInterface
	{
		$statement = <<< END
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
				`favorites`.timestampCreated DESC;
		END;

		$favoriteEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteEntityPropertyMapper();
		$userEntityPropertyMapper     = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedUser = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			'userId' => $mappedUser[ 'id' ]
		];

		return new FavoriteEntityCollection(
			...$this->persistenceConnector->query( $statement, $arguments, $favoriteEntityPropertyMapper )
		);
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 */
	public function createFavoriteByUserId( FavoriteEntityInterface $favorite, UserEntityInterface $user ): void
	{
		$statements = [
			<<< END
				INSERT INTO
					`favorites`
					( `id`, `name`, timestampCreated )
				VALUES
					( UUID( ), LOWER( :favoriteName ), :timestampCreated )
				ON DUPLICATE KEY UPDATE
					timestampCreated = IF ( timestampCreated IS NULL OR timestampCreated > :timestampCreated, :timestampCreated, timestampCreated );
			END,
			<<< END
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
			END
		];

		$favoriteEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteEntityPropertyMapper();
		$userEntityPropertyMapper     = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedFavorite = $favoriteEntityPropertyMapper->mapToArray( $favorite );
		$mappedUser     = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			[
				'userId'           => $mappedUser[ 'id' ],
				'favoriteName'     => $mappedFavorite[ 'name' ],
				'timestampCreated' => $mappedFavorite[ 'timestampCreated' ]
			],
			[
				'userId'       => $mappedUser[ 'id' ],
				'favoriteName' => $mappedFavorite[ 'name' ]
			]
		];

		$this->persistenceConnector->executeMultiple( $statements, $arguments );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 */
	public function deleteFavoriteByUserId( FavoriteEntityInterface $favorite, UserEntityInterface $user ): void
	{
		$statements = [
			<<< END
				DELETE
				FROM
					`users_favorites`
				WHERE
					`users_favorites`.`userId` = :userId
					AND
					`users_favorites`.`favoriteId` = :favoriteId;
			END,
			<<< END
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
			END
		];

		$favoriteEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteEntityPropertyMapper();
		$userEntityPropertyMapper     = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedFavorite = $favoriteEntityPropertyMapper->mapToArray( $favorite );
		$mappedUser     = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			[
				'userId'     => $mappedUser[ 'id' ],
				'favoriteId' => $mappedFavorite[ 'id' ]
			],
			[]
		];

		$this->persistenceConnector->executeMultiple( $statements, $arguments );
	}
}
