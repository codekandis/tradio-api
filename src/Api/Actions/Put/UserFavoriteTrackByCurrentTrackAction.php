<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions\Put;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\InvalidArgumentsStatementsCountException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\ContentTypes;
use CodeKandis\Tiphy\Http\Requests\BadRequestException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Api\Actions\AbstractAction;
use CodeKandis\TradioApi\Environment\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Environment\Entities\CurrentTrackEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\CommonErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\CommonErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\CurrentTracksErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\CurrentTracksErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\StationsErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\StationsErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\StationEntity;
use CodeKandis\TradioApi\Environment\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UserEntity;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\StationsRepository;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\UsersRepository;
use CodeKandis\TradioApi\Environment\Readers\CurrentTrackNameNotExtractableException;
use CodeKandis\TradioApi\Environment\Readers\CurrentTrackNameReader;
use CodeKandis\TradioApi\Environment\Readers\TracklistNotReadableException;
use JsonException;
use ReflectionException;
use function is_object;
use function strtolower;

class UserFavoriteTrackByCurrentTrackAction extends AbstractAction
{
	/**
	 * {@inheritDoc}
	 * @throws BadRequestException The content type is invalid.
	 * @throws BadRequestException The request body is malformed.
	 * @throws BadRequestException The request body is invalid.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException An error occurred during the creation of the current track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws JsonException An error occurred during the creation of the JSON response.
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

		$user = $this->readUser(
			UserEntity::fromArray(
				[
					'id' => $inputData[ 'userId' ]
				]
			)
		);

		if ( null === $user )
		{
			$errorInformation = new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN );
			( new JsonResponder( StatusCodes::BAD_REQUEST, null, $errorInformation ) )
				->respond();

			return;
		}

		$station = $this->readStationById(
			StationEntity::fromObject( $inputData[ 'station' ] )
		);

		if ( null === $station )
		{
			$errorInformation = new ErrorInformation( StationsErrorCodes::STATION_UNKNOWN, StationsErrorMessages::STATION_UNKNOWN );
			( new JsonResponder( StatusCodes::BAD_REQUEST, null, $errorInformation ) )
				->respond();

			return;
		}

		try
		{
			$currentTrack = $this->readCurrentTrack( $station );
		}
		catch ( TracklistNotReadableException|CurrentTrackNameNotExtractableException $exception )
		{
			( new JsonResponder(
				StatusCodes::SERVICE_UNAVAILABLE,
				null,
				new ErrorInformation( CurrentTracksErrorCodes::CURRENT_TRACK_NOT_READABLE, CurrentTracksErrorMessages::CURRENT_TRACK_NOT_READABLE, $inputData )
			) )
				->respond();

			return;
		}

		$this->writeFavoriteTrackByUserId(
			FavoriteTrackEntity::fromArray(
				[
					'name' => $currentTrack->getName()
				]
			),
			$user
		);

		( new JsonResponder( StatusCodes::OK, null ) )
			->respond();
	}

	/**
	 * Gets the input data of the request.
	 * @return array The input data of the request.
	 * @throws BadRequestException The content type is invalid.
	 * @throws BadRequestException The request body is malformed.
	 * @throws BadRequestException The request body is invalid.
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

	/**
	 * Reads the currently playing track from a sepcific station.
	 * @param StationEntityInterface $station The station to read the currently playing track from.
	 * @return CurrentTrackEntityInterface The currently playing track.
	 * @throws TracklistNotReadableException The tracklist is not readable.
	 * @throws CurrentTrackNameNotExtractableException The currently playing track name is not extractable.
	 * @throws ReflectionException An error occurred during the creation of the current track entity.
	 */
	private function readCurrentTrack( StationEntityInterface $station ): CurrentTrackEntityInterface
	{
		return CurrentTrackEntity::fromArray(
			[
				'stationId' => $station->getId(),
				'name'      => ( new CurrentTrackNameReader() )
					->read(
						$station->getTracklistUri(),
						$station->getCurrentTrackSelector()
					)
			]
		);
	}

	/**
	 * Reads a station by its ID.
	 * @param StationEntityInterface $station The station with the ID to search for.
	 * @return ?UserEntityInterface The station if found, otherwise null.
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the station entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readStationById( StationEntityInterface $station ): ?StationEntityInterface
	{
		return ( new StationsRepository(
			$this->getPersistenceConnector()
		) )
			->readStationById( $station );
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
	private function readUser( UserEntityInterface $user ): ?UserEntityInterface
	{
		return ( new UsersRepository(
			$this->getPersistenceConnector()
		) )
			->readUserById( $user );
	}

	/**
	 * Creates a favored track of a specific user.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track to create.
	 * @param UserEntityInterface $user The user with the ID whom the favored track is related with.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 */
	private function writeFavoriteTrackByUserId( FavoriteTrackEntityInterface $favoriteTrack, UserEntityInterface $user ): void
	{
		( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->createFavoriteTrackByUserId( $favoriteTrack, $user );
	}
}
