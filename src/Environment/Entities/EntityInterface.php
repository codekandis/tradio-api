<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities;

use CodeKandis\Entities\EntityInterface as OriginEntityInterface;

/**
 * Represents the interface of any entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface EntityInterface extends OriginEntityInterface
{
	/**
	 * Gets the canonical URI of the entity.
	 * @return string The canonical URI of the entity.
	 */
	public function getCanonicalUri(): string;

	/**
	 * Sets the canonical URI of the entity.
	 * @param string $canonicalUri The canonical URI of the entity.
	 */
	public function setCanonicalUri( string $canonicalUri ): void;
}
