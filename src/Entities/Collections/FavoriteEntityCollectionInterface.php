<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Collections;

use CodeKandis\Entities\Collections\EntityCollectionInterface;
use CodeKandis\TradioApi\Entities\EntityInterface;
use CodeKandis\TradioApi\Entities\FavoriteEntityInterface;

/**
 * Represents the interface of any collection of favorite track entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FavoriteEntityCollectionInterface extends EntityCollectionInterface
{
	/**
	 * Gets the current favorite track.
	 * @return FavoriteEntityInterface The current favorite track.
	 */
	public function current(): EntityInterface;

	/**
	 * Gets the favorite track at the specified index.
	 * @param int $index The index of the favorite track.
	 * @return FavoriteEntityInterface The favorite track to get.
	 */
	public function offsetGet( $index ): EntityInterface;
}
