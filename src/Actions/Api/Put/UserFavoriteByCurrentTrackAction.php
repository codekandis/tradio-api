<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Put;

use CodeKandis\Tiphy\Http\ContentTypes;
use CodeKandis\Tiphy\Http\Requests\BadRequestException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAction;
use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Errors\CommonErrorCodes;
use CodeKandis\TradioApi\Errors\CommonErrorMessages;
use CodeKandis\TradioApi\Errors\StationsErrorCodes;
use CodeKandis\TradioApi\Errors\StationsErrorMessages;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Http\Readers\CurrentTrackReader;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\StationsRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;
use function is_object;
use function strtolower;

class UserFavoriteByCurrentTrackAction extends AbstractWithDatabaseConnectorAction
{
	/**
	 * @throws PersistenceException
	 * @throws ReflectionException
	 * @throws JsonException
	 */
	public function execute(): void
	{
		try
		{
			$inputData = $this->getInputData();
		}
		catch ( BadRequestException $exception )
		{
			$errorInformation = new ErrorInformation( $exception->getCode(), $exception->getMessage() );
			( new JsonResponder( StatusCodes::BAD_REQUEST, null, $errorInformation ) )
				->respond();

			return;
		}

		$requestedUser     = new UserEntity();
		$requestedUser->id = $inputData[ 'userId' ];
		$user              = $this->readUser( $requestedUser );

		if ( null === $user )
		{
			$errorInformation = new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN );
			( new JsonResponder( StatusCodes::BAD_REQUEST, null, $errorInformation ) )
				->respond();

			return;
		}

		/** @var StationEntity $requestedStation */
		$requestedStation = StationEntity::fromObject( $inputData[ 'station' ] );
		$station          = $this->readStationById( $requestedStation );

		if ( null === $station )
		{
			$errorInformation = new ErrorInformation( StationsErrorCodes::STATION_UNKNOWN, StationsErrorMessages::STATION_UNKNOWN );
			( new JsonResponder( StatusCodes::BAD_REQUEST, null, $errorInformation ) )
				->respond();

			return;
		}

		$currentTrack   = $this->readCurrentTrack( $station );
		$favorite       = new FavoriteEntity();
		$favorite->name = $currentTrack->name;
		$this->writeFavoriteByUserId( $favorite, $user );

		( new JsonResponder( StatusCodes::OK, null ) )
			->respond();
	}

	/**
	 * @throws BadRequestException
	 */
	private function getInputData(): array
	{
		if ( ContentTypes::APPLICATION_JSON !== strtolower( $_SERVER[ 'CONTENT_TYPE' ] ) )
		{
			throw new BadRequestException( CommonErrorMessages::INVALID_CONTENT_TYPE, CommonErrorCodes::INVALID_CONTENT_TYPE );
		}
		$requestBody = $this->requestBody->getContent();

		$isValid = is_object( $requestBody );
		if ( false === $isValid )
		{
			throw new BadRequestException( CommonErrorMessages::MALFORMED_REQUEST_BODY, CommonErrorCodes::MALFORMED_REQUEST_BODY );
		}

		$bodyData     = [];
		$requiredKeys = [
			'station'
		];

		$isValid = true;
		foreach ( $requiredKeys as $requiredKey )
		{
			$isValid = $isValid && isset( $requestBody->{$requiredKey} );
			if ( false === $isValid )
			{
				break;
			}
			$bodyData[ $requiredKey ] = $requestBody->{$requiredKey};
		}
		if ( false === $isValid )
		{
			throw new BadRequestException( CommonErrorMessages::INVALID_REQUEST_BODY, CommonErrorCodes::INVALID_REQUEST_BODY );
		}

		$argumentsData = $this->arguments;

		return $bodyData + $argumentsData;
	}

	private function readCurrentTrack( StationEntity $station ): CurrentTrackEntity
	{
		$currentTrackName        = ( new CurrentTrackReader() )
			->read( $station->tracklistUri, $station->currentTrackXPath );
		$currentTrack            = new CurrentTrackEntity();
		$currentTrack->stationId = $station->id;
		$currentTrack->name      = $currentTrackName;

		return $currentTrack;
	}

	/**
	 * @throws PersistenceException
	 */
	private function readStationById( StationEntity $requestedStation ): ?StationEntity
	{
		return ( new StationsRepository(
			$this->getDatabaseConnector()
		) )
			->readStationById( $requestedStation );
	}

	/**
	 * @throws PersistenceException
	 */
	private function readUser( UserEntity $requestedUser ): ?UserEntity
	{
		return ( new UsersRepository(
			$this->getDatabaseConnector()
		) )
			->readUserById( $requestedUser );
	}

	/**
	 * @throws PersistenceException
	 */
	private function writeFavoriteByUserId( FavoriteEntity $favorite, UserEntity $user ): void
	{
		( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->writeFavoriteByUserId( $favorite, $user );
	}
}
