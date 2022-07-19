<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Collections;

use CodeKandis\Entities\Collections\AbstractEntityCollection;
use CodeKandis\Entities\Collections\EntityExistsException;
use CodeKandis\TradioApi\Entities\CurrentTrackEntityInterface;
use CodeKandis\TradioApi\Entities\EntityInterface;

/**
 * Represents a collection of current track entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackEntityCollection extends AbstractEntityCollection implements CurrentTrackEntityCollectionInterface
{
	/**
	 * Constructor method.
	 * @param CurrentTrackEntityInterface[] $currentTracks The initial currently playing tracks of the collection.
	 * @throws EntityExistsException A currently playing track already exists in the collection.
	 */
	public function __construct( CurrentTrackEntityInterface ...$currentTracks )
	{
		parent::__construct( ...$currentTracks );
	}

	/**
	 * {@inheritDoc}
	 */
	public function current(): EntityInterface
	{
		return parent::current();
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetGet( $index ): EntityInterface
	{
		return parent::offsetGet( $index );
	}
}
