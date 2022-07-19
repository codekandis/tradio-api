<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Collections;

use CodeKandis\Entities\Collections\EntityCollectionInterface;
use CodeKandis\TradioApi\Entities\EntityInterface;
use CodeKandis\TradioApi\Entities\StationEntityInterface;

/**
 * Represents the interface of any collection of station entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface StationEntityCollectionInterface extends EntityCollectionInterface
{
	/**
	 * Gets the current station.
	 * @return StationEntityInterface The current station.
	 */
	public function current(): EntityInterface;

	/**
	 * Gets the station at the specified index.
	 * @param int $index The index of the station.
	 * @return StationEntityInterface The station to get.
	 */
	public function offsetGet( $index ): EntityInterface;
}
