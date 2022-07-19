<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\Repositories\AbstractRepository;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\TradioApi\Entities\Collections\StationEntityCollection;
use CodeKandis\TradioApi\Entities\Collections\StationEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\EntityPropertyMappings\EntityPropertyMapperBuilder;
use CodeKandis\TradioApi\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Entities\UserEntityInterface;
use ReflectionException;

/**
 * Represents the MariaDB repository of the station entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationsRepository extends AbstractRepository implements StationsRepositoryInterface
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readStations(): StationEntityCollectionInterface
	{
		$statement = <<< END
			SELECT
				`stations`.*
			FROM
				`stations`
			ORDER BY
				`stations`.`name` ASC;
		END;

		$stationEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildStationEntityPropertyMapper();

		return new StationEntityCollection(
			...$this->persistenceConnector->query( $statement, null, $stationEntityPropertyMapper )
		);
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readStationById( StationEntityInterface $station ): ?StationEntityInterface
	{
		$statement = <<< END
			SELECT
				`stations`.*
			FROM
				`stations`
			WHERE
				`stations`.`id` = :stationId
			LIMIT
				0, 1;
		END;

		$stationEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildStationEntityPropertyMapper();

		$mappedStation = $stationEntityPropertyMapper->mapToArray( $station );

		$arguments = [
			'stationId' => $mappedStation[ 'id' ]
		];

		return $this->persistenceConnector->queryFirst( $statement, $arguments, $stationEntityPropertyMapper );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	public function readStationsByUserId( UserEntityInterface $user ): StationEntityCollectionInterface
	{
		$statement = <<< END
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

		$stationEntityPropertyMapper = ( new EntityPropertyMapperBuilder() )
			->buildStationEntityPropertyMapper();
		$userEntityPropertyMapper    = ( new EntityPropertyMapperBuilder() )
			->buildUserEntityPropertyMapper();

		$mappedUser = $userEntityPropertyMapper->mapToArray( $user );

		$arguments = [
			'userId' => $mappedUser[ 'id' ]
		];

		return new StationEntityCollection(
			...$this->persistenceConnector->query( $statement, $arguments, $stationEntityPropertyMapper )
		);
	}
}
