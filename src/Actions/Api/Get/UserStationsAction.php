<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithPersistenceConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\Collections\StationEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\UriExtenders\StationApiUriExtender;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve a users' stations.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserStationsAction extends AbstractWithPersistenceConnectorAndApiUriBuilderAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$user = $this->readUserById(
			UserEntity::fromArray(
				[
					'id' => $inputData[ 'userId' ]
				]
			)
		);

		if ( null === $user )
		{
			( new JsonResponder(
				StatusCodes::NOT_FOUND,
				null,
				new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN, $inputData )
			) )
				->respond();

			return;
		}

		$stations = $this->readStationsByUserId( $user );
		$this->extendUris( $stations );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'stations' => $stations,
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
	 * Extends the URIs of a list of stations.
	 * @param StationEntityCollectionInterface $stations The stations to extend their URIs.
	 */
	private function extendUris( StationEntityCollectionInterface $stations ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $stations as $station )
		{
			( new StationApiUriExtender( $apiUriBuilder, $station ) )
				->extend();
		}
	}

	/**
	 * Reads a user by its ID.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return ?UserEntityInterface The user if found, otherwise null.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readUserById( UserEntityInterface $user ): ?UserEntityInterface
	{
		return ( new UsersRepository(
			$this->getPersistenceConnector()
		) )
			->readUserById( $user );
	}

	/**
	 * Reads all stations by a specific user ID.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return StationEntityCollectionInterface The stations.
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readStationsByUserId( UserEntityInterface $user ): StationEntityCollectionInterface
	{
		return ( new StationsRepository(
			$this->getPersistenceConnector()
		) )
			->readStationsByUserId( $user );
	}
}
