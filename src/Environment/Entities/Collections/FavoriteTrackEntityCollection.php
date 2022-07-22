<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Collections;

use CodeKandis\Entities\Collections\AbstractEntityCollection;
use CodeKandis\Entities\Collections\EntityExistsException;
use CodeKandis\TradioApi\Environment\Entities\EntityInterface;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;

/**
 * Represents a collection of favorite track entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteTrackEntityCollection extends AbstractEntityCollection implements FavoriteTrackEntityCollectionInterface
{
	/**
	 * Constructor method.
	 * @param FavoriteTrackEntityInterface[] $favoriteTracks The initial favored tracks of the collection.
	 * @throws EntityExistsException A favored track already exists in the collection.
	 */
	public function __construct( FavoriteTrackEntityInterface ...$favoriteTracks )
	{
		parent::__construct( ...$favoriteTracks );
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
