<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Collections;

use CodeKandis\Entities\Collections\EntityCollectionInterface;
use CodeKandis\TradioApi\Entities\CurrentTrackEntityInterface;
use CodeKandis\TradioApi\Entities\EntityInterface;

/**
 * Represents the interface of any collection of current track entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface CurrentTrackEntityCollectionInterface extends EntityCollectionInterface
{
	/**
	 * Gets the current currently playing track.
	 * @return CurrentTrackEntityInterface The current currently playing track.
	 */
	public function current(): EntityInterface;

	/**
	 * Gets the currently playing track at the specified index.
	 * @param int $index The index of the currently playing track.
	 * @return CurrentTrackEntityInterface The currently playing track to get.
	 */
	public function offsetGet( $index ): EntityInterface;
}
