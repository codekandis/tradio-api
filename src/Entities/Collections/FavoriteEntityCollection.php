<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Collections;

use CodeKandis\Entities\Collections\AbstractEntityCollection;
use CodeKandis\Entities\Collections\EntityExistsException;
use CodeKandis\TradioApi\Entities\EntityInterface;
use CodeKandis\TradioApi\Entities\FavoriteEntityInterface;

/**
 * Represents a collection of favorite track entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteEntityCollection extends AbstractEntityCollection implements FavoriteEntityCollectionInterface
{
	/**
	 * Constructor method.
	 * @param FavoriteEntityInterface[] $favorites The initial favorite tracks of the collection.
	 * @throws EntityExistsException A favorite track already exists in the collection.
	 */
	public function __construct( FavoriteEntityInterface ...$favorites )
	{
		parent::__construct( ...$favorites );
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
