<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Delete;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\InvalidArgumentsStatementsCountException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Persistence\TransactionCommitFailedException;
use CodeKandis\Persistence\TransactionRollbackFailedException;
use CodeKandis\Persistence\TransactionStartFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithPersistenceConnectorAction;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Errors\FavoriteTracksErrorCodes;
use CodeKandis\TradioApi\Errors\FavoriteTracksErrorMessages;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to delete a specific favored track of a specific user.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserFavoriteTrackAction extends AbstractWithPersistenceConnectorAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the user entity.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws TransactionStartFailedException The transaction failed to start.
	 * @throws TransactionRollbackFailedException The transaction failed to roll back.
	 * @throws TransactionCommitFailedException The transaction failed to commit.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
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

		$favoriteTrack = $this->readFavoriteTrackById(
			FavoriteTrackEntity::fromArray(
				[
					'id' => $inputData[ 'favoriteTrackId' ]
				]
			)
		);

		if ( null === $favoriteTrack )
		{
			( new JsonResponder(
				StatusCodes::NOT_FOUND,
				null,
				new ErrorInformation( FavoriteTracksErrorCodes::FAVORITE_TRACK_UNKNOWN, FavoriteTracksErrorMessages::FAVORITE_TRACK_UNKNOWN, $inputData )
			) )
				->respond();

			return;
		}

		$this->deleteFavoriteTrackByUserId( $favoriteTrack, $user );

		( new JsonResponder( StatusCodes::OK, null ) )
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
	 * Reads a favored track by its ID.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track with the ID to search for.
	 * @return ?FavoriteTrackEntityInterface The favored track if found, otherwise null.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavoriteTrackById( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface
	{
		return ( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoriteTrackById( $favoriteTrack );
	}

	/**
	 * Deletes a favored track by its specific user ID.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track to delete.
	 * @param UserEntityInterface $user The user with the ID whom the favored track is related with.
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws TransactionStartFailedException The transaction failed to start.
	 * @throws TransactionRollbackFailedException The transaction failed to roll back.
	 * @throws TransactionCommitFailedException The transaction failed to commit.
	 * @throws InvalidArgumentsStatementsCountException The number of argument lists does not match the number of statements.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 */
	private function deleteFavoriteTrackByUserId( FavoriteTrackEntityInterface $favoriteTrack, UserEntityInterface $user ): void
	{
		$this->getPersistenceConnector()
			 ->asTransaction(
				 function () use ( $user, $favoriteTrack ): void
				 {
					 ( new FavoriteTracksRepository(
						 $this->getPersistenceConnector()
					 ) )
						 ->deleteFavoriteTrackByUserId( $favoriteTrack, $user );
				 }
			 );
	}
}
