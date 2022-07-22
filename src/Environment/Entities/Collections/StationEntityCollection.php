<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Collections;

use CodeKandis\Entities\Collections\AbstractEntityCollection;
use CodeKandis\Entities\Collections\EntityExistsException;
use CodeKandis\TradioApi\Environment\Entities\EntityInterface;
use CodeKandis\TradioApi\Environment\Entities\StationEntityInterface;

/**
 * Represents a collection of station entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationEntityCollection extends AbstractEntityCollection implements StationEntityCollectionInterface
{
	/**
	 * Constructor method.
	 * @param StationEntityInterface[] $stations The initial stations of the collection.
	 * @throws EntityExistsException A station already exists in the collection.
	 */
	public function __construct( StationEntityInterface ...$stations )
	{
		parent::__construct( ...$stations );
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
