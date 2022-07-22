<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities;

/**
 * Represents the interface of any persistable entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface PersistableEntityInterface extends EntityInterface
{
	/**
	 * Gets the ID of the entity.
	 * @return string The ID of the entity.
	 */
	public function getId(): string;

	/**
	 * Sets the ID of the entity.
	 * @param string $id The ID of the entity.
	 */
	public function setId( string $id ): void;
}
