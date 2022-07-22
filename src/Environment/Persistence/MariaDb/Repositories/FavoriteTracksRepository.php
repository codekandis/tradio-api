<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\InvalidArgumentsStatementsCountException;
use CodeKandis\Persistence\Repositories\AbstractRepository;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollection;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\EntityPropertyMappings\EntityPropertyMapperBuilder;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Environment\Persistence\FavoriteTracksRepositoryInterface;
use ReflectionException;

/**
 * Represents the MariaDB repository of the favorite track entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteTracksRepository extends AbstractRepository implements FavoriteTracksRepositoryInterface
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
	public function readFavoriteTracks(): FavoriteTrackEntityCollectionInterface
	{
		$statement = <<< END
			SELECT
				`favoriteTracks`.*
			FROM
				`favoriteTracks`
			ORDER BY
				`favoriteTracks`.timestampCreated DESC;
		END;

		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();

		return new FavoriteTrackEntityCollection(
			...$this->persistenceConnector->query( $statement, null, $favoriteTrackEntityPropertyMapper )
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
	public function readFavoriteTrackById( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface
	{
		$statement = <<< END
			SELECT
				`favoriteTracks`.*
			FROM
				`favoriteTracks`
			WHERE
				`favoriteTracks`.`id` = :favoriteTrackId
			LIMIT
				0, 1;
		END;

		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();

		$mappedFavoriteTrack = $favoriteTrackEntityPropertyMapper->mapToArray( $favoriteTrack );

		$arguments = [
			'favoriteTrackId' => $mappedFavoriteTrack[ 'id' ]
		];

		return $this->persistenceConnector->queryFirst( $statement, $arguments, $favoriteTrackEntityPropertyMapper );
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
	public function readFavoriteTrackByName( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface
	{
		$statement = <<< END
			SELECT
				`favoriteTracks`.*
			FROM
				`favoriteTracks`
			WHERE
				`favoriteTracks`.`name` = :name
			LIMIT
				0, 1;
		END;

		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();

		$mappedFavoriteTrack = $favoriteTrackEntityPropertyMapper->mapToArray( $favoriteTrack );

		$arguments = [
			'name' => $mappedFavoriteTrack[ 'name' ]
		];

		return $this->persistenceConnector->queryFirst( $statement, $arguments, $favoriteTrackEntityPropertyMapper );
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
	public function readFavoriteTracksByUserId( UserEntityInterface $user ): FavoriteTrackEntityCollectionInterface
	{
		$statement = <<< END
			SELECT
				`favoriteTracks`.*
			FROM
				`favoriteTracks`
			INNER JOIN
				`users_favoriteTracks`
				ON
				`users_favoriteTracks`.`userId` = :userId
			WHERE
				`favoriteTracks`.`id` = `users_favoriteTracks`.`favoriteTrackId`
			ORDER BY
				`favoriteTracks`.timestampCreated DESC;
		END;

		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();
		$userEntityPropertyMapper          = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedUser = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			'userId' => $mappedUser[ 'id' ]
		];

		return new FavoriteTrackEntityCollection(
			...$this->persistenceConnector->query( $statement, $arguments, $favoriteTrackEntityPropertyMapper )
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
	public function createFavoriteTrackByUserId( FavoriteTrackEntityInterface $favoriteTrack, UserEntityInterface $user ): void
	{
		$statements = [
			<<< END
				INSERT INTO
					`favoriteTracks`
					( `id`, `name`, timestampCreated )
				VALUES
					( UUID( ), LOWER( :favoriteTrackName ), :timestampCreated )
				ON DUPLICATE KEY UPDATE
					timestampCreated = IF ( timestampCreated IS NULL OR timestampCreated > :timestampCreated, :timestampCreated, timestampCreated );
			END,
			<<< END
				INSERT IGNORE INTO
					`users_favoriteTracks`
					( `id`, `userId`, `favoriteTrackId`)
				SELECT
					UUID( ),
					:userId,
					`favoriteTracks`.`id`
				FROM
					`favoriteTracks`
				WHERE
					`favoriteTracks`.`name` = :favoriteTrackName;
			END
		];

		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();
		$userEntityPropertyMapper          = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedFavoriteTrack = $favoriteTrackEntityPropertyMapper->mapToArray( $favoriteTrack );
		$mappedUser          = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			[
				'userId'            => $mappedUser[ 'id' ],
				'favoriteTrackName' => $mappedFavoriteTrack[ 'name' ],
				'timestampCreated'  => $mappedFavoriteTrack[ 'timestampCreated' ]
			],
			[
				'userId'            => $mappedUser[ 'id' ],
				'favoriteTrackName' => $mappedFavoriteTrack[ 'name' ]
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
	public function deleteFavoriteTrackByUserId( FavoriteTrackEntityInterface $favoriteTrack, UserEntityInterface $user ): void
	{
		$statements = [
			<<< END
				DELETE
				FROM
					`users_favoriteTracks`
				WHERE
					`users_favoriteTracks`.`userId` = :userId
					AND
					`users_favoriteTracks`.`favoriteTrackId` = :favoriteTrackId;
			END,
			<<< END
				DELETE
					`favoriteTracks`
				FROM
					`favoriteTracks`
				LEFT JOIN
					`users_favoriteTracks`
				ON
					`users_favoriteTracks`.`favoriteTrackId` = `favoriteTracks`.`id`
				WHERE
					`users_favoriteTracks`.`id` IS NULL;
			END
		];

		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();
		$userEntityPropertyMapper          = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedFavoriteTrack = $favoriteTrackEntityPropertyMapper->mapToArray( $favoriteTrack );
		$mappedUser          = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			[
				'userId'          => $mappedUser[ 'id' ],
				'favoriteTrackId' => $mappedFavoriteTrack[ 'id' ]
			],
			[]
		];

		$this->persistenceConnector->executeMultiple( $statements, $arguments );
	}
}
