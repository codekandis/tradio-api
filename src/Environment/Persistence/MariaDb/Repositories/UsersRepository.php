<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\Repositories\AbstractRepository;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\TradioApi\Environment\Entities\Collections\UserEntityCollection;
use CodeKandis\TradioApi\Environment\Entities\Collections\UserEntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\EntityPropertyMappings\EntityPropertyMapperBuilder;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Environment\Persistence\UsersRepositoryInterface;
use ReflectionException;

/**
 * Represents the MariaDB repository of the user entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UsersRepository extends AbstractRepository implements UsersRepositoryInterface
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readUsers(): UserEntityCollectionInterface
	{
		$statement = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			ORDER BY
				`users`.`name` ASC;
		END;

		$userEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		return new UserEntityCollection(
			...$this->persistenceConnector->query( $statement, null, $userEntityPropertyMapper )
		);
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readUserById( UserEntityInterface $user ): ?UserEntityInterface
	{
		$statement = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			WHERE
				`users`.`id` = :userId
			LIMIT
				0, 1;
		END;

		$userEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedUser = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			'userId' => $mappedUser[ 'id' ]
		];

		return $this->persistenceConnector->queryFirst( $statement, $arguments, $userEntityPropertyMapper );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readUsersByStationId( StationEntityInterface $station ): UserEntityCollectionInterface
	{
		$statement = <<< END
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

		$userEntityPropertyMapper    = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();
		$stationEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildStationEntityPropertyMapper();

		$mappedStation = $stationEntityPropertyMapper->mapToArray( $station );

		$arguments = [
			'stationId' => $mappedStation[ 'id' ]
		];

		return new UserEntityCollection(
			...$this->persistenceConnector->query( $statement, $arguments, $userEntityPropertyMapper )
		);
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The favored track entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readUsersByFavoriteTrackId( FavoriteTrackEntityInterface $favoriteTrack ): UserEntityCollectionInterface
	{
		$statement = <<< END
			SELECT
				`users`.*
			FROM
				`users`
			INNER JOIN
				`users_favoriteTracks`
				ON
				`users_favoriteTracks`.`favoriteTrackId` = :favoriteTrackId
			WHERE
				`users`.`id` = `users_favoriteTracks`.`userId`
			ORDER BY
				`users`.`name` ASC;
		END;

		$userEntityPropertyMapper          = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();
		$favoriteTrackEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildFavoriteTrackEntityPropertyMapper();

		$mappedFavoriteTrack = $favoriteTrackEntityPropertyMapper->mapToArray( $favoriteTrack );

		$arguments = [
			'favoriteTrackId' => $mappedFavoriteTrack[ 'id' ]
		];

		return new UserEntityCollection(
			...$this->persistenceConnector->query( $statement, $arguments, $userEntityPropertyMapper )
		);
	}
}
