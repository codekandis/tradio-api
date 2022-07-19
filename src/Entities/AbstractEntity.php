<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Entities\AbstractEntity as OriginAbstractEntity;

/**
 * Represents the base class of any entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractEntity extends OriginAbstractEntity implements EntityInterface
{
	/**
	 * Stores the canonical URI of the entity.
	 * @var string
	 */
	public string $canonicalUri = '';

	/**
	 * {@inheritDoc}
	 */
	public function getCanonicalUri(): string
	{
		return $this->canonicalUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setCanonicalUri( string $canonicalUri ): void
	{
		$this->canonicalUri = $canonicalUri;
	}
}
