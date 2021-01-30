<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class CurrentTrackEntity extends AbstractEntity
{
	/** @var string */
	public string $canonicalUri = '';

	/** @var string */
	public string $name = '';

	/** @var string */
	public string $stationId = '';

	/** @var string */
	public string $stationUri = '';

	/** @var null|string */
	public ?string $favoriteUri = null;
}
