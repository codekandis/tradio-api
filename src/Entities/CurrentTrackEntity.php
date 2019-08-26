<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class CurrentTrackEntity extends AbstractEntity
{
	/** @var string */
	public $canonicalUri = '';

	/** @var string */
	public $name = '';

	/** @var string */
	public $stationId = '';

	/** @var string */
	public $stationUri = '';

	/** @var ?string */
	public $favoriteUri;
}
