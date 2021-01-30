<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class StationEntity extends AbstractEntity
{
	/** @var string */
	public string $canonicalUri = '';

	/** @var string */
	public string $id = '';

	/** @var string */
	public string $serverType = '';

	/** @var string */
	public string $name = '';

	/** @var string */
	public string $streamUri = '';

	/** @var string */
	public string $tracklistUri = '';

	/** @var string */
	public string $currentTrackXPath = '';

	/** @var string */
	public string $currentTrackUri = '';

	/** @var string */
	public string $usersUri = '';
}
