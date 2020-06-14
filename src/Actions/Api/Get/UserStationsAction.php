<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\Tiphy\Persistence\MariaDb\ConnectorInterface;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\StationUriExtender;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;

class UserStationsAction extends AbstractAction
{
	/** @var ConnectorInterface */
	private $databaseConnector;

	/** @var ApiUriBuilder */
	private $uriBuilder;

	private function getDatabaseConnector(): ConnectorInterface
	{
		if ( null === $this->databaseConnector )
		{
			$databaseConfig          = ConfigurationRegistry::_()->getPersistenceConfiguration();
			$this->databaseConnector = new Connector( $databaseConfig );
		}

		return $this->databaseConnector;
	}

	private function getUriBuilder(): ApiUriBuilder
	{
		if ( null === $this->uriBuilder )
		{
			$uriBuilderConfiguration = ConfigurationRegistry::_()->getUriBuilderConfiguration();
			$this->uriBuilder        = new ApiUriBuilder( $uriBuilderConfiguration );
		}

		return $this->uriBuilder;
	}

	/**
	 * @throws PersistenceException
	 * @throws JsonException
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$requestedUser     = new UserEntity();
		$requestedUser->id = $inputData[ 'userId' ];
		$user              = $this->readUserById( $requestedUser );

		if ( null === $user )
		{
			$errorInformation = new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN, $inputData );
			( new JsonResponder( StatusCodes::NOT_FOUND, null, $errorInformation ) )
				->respond();

			return;
		}

		$stations = $this->readStationsByUserId( $user );
		$this->extendUris( $stations );

		$responderData = [
			'stations' => $stations,
		];
		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
	}

	/**
	 * @return string[]
	 */
	private function getInputData(): array
	{
		return $this->arguments;
	}

	/**
	 * @param StationEntity[] $stations
	 */
	private function extendUris( array $stations ): void
	{
		$uriBuilder = $this->getUriBuilder();
		foreach ( $stations as $station )
		{
			( new StationUriExtender( $uriBuilder, $station ) )
				->extend();
		}
	}

	/**
	 * @throws PersistenceException
	 */
	private function readUserById( UserEntity $requestedUser ): ?UserEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new UsersRepository( $databaseConnector ) )
			->readUserById( $requestedUser );
	}

	/**
	 * @return StationEntity[]
	 * @throws PersistenceException
	 */
	private function readStationsByUserId( UserEntity $user ): array
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new StationsRepository( $databaseConnector ) )
			->readStationsByUserId( $user );
	}
}
