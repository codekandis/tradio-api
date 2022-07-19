<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Collections;

use CodeKandis\Entities\Collections\AbstractEntityCollection;
use CodeKandis\Entities\Collections\EntityExistsException;
use CodeKandis\TradioApi\Entities\EntityInterface;
use CodeKandis\TradioApi\Entities\UserEntityInterface;

/**
 * Represents a collection of user entities.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserEntityCollection extends AbstractEntityCollection implements UserEntityCollectionInterface
{
	/**
	 * Constructor method.
	 * @param UserEntityInterface[] $users The initial users of the collection.
	 * @throws EntityExistsException A user already exists in the collection.
	 */
	public function __construct( UserEntityInterface ...$users )
	{
		parent::__construct( ...$users );
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
