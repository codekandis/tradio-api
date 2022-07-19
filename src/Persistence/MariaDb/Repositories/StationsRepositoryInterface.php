<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\Repositories\RepositoryInterface;
use CodeKandis\TradioApi\Entities\Collections\StationEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Entities\UserEntityInterface;

/**
 * Represents the interface of any repository of any station entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface StationsRepositoryInterface extends RepositoryInterface
{
	/**
	 * Reads all stations.
	 * @return StationEntityCollectionInterface The stations.
	 */
	public function readStations(): StationEntityCollectionInterface;

	/**
	 * Reads a station by its ID.
	 * @param StationEntityInterface $station The station with the ID to search for.
	 * @return ?StationEntityInterface The station if found, otherwise null.
	 */
	public function readStationById( StationEntityInterface $station ): ?StationEntityInterface;

	/**
	 * Reads all stations favored by a specific user.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return StationEntityCollectionInterface The stations.
	 */
	public function readStationsByUserId( UserEntityInterface $user ): StationEntityCollectionInterface;
}
