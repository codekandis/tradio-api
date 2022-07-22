<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Collections;

use CodeKandis\Entities\Collections\EntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\EntityInterface;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;

/**
 * Represents the interface of any collection of favorite track entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FavoriteTrackEntityCollectionInterface extends EntityCollectionInterface
{
	/**
	 * Gets the current favored track.
	 * @return FavoriteTrackEntityInterface The current favored track.
	 */
	public function current(): EntityInterface;

	/**
	 * Gets the favored track at the specified index.
	 * @param int $index The index of the favored track.
	 * @return FavoriteTrackEntityInterface The favored track to get.
	 */
	public function offsetGet( $index ): EntityInterface;
}
