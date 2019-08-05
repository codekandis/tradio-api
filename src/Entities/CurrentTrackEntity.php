<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class CurrentTrackEntity extends AbstractEntity
{
	/** @var string */
	public $uri = '';

	/** @var string */
	public $name = '';

	/** @var string */
	public $stationUri = '';

	/** @var ?string */
	public $favoriteUri;
}
