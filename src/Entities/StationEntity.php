<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class StationEntity extends AbstractEntity
{
	/** @var string */
	public $uri = '';

	/** @var string */
	public $id = '';

	/** @var string */
	public $serverType = '';

	/** @var string */
	public $name = '';

	/** @var string */
	public $streamUri = '';

	/** @var string */
	public $tracklistUri = '';

	/** @var string */
	public $currentTrackXPath = '';

	/** @var string */
	public $currentTrackUri = '';

	/** @var string */
	public $usersUri = '';

	/** @var string */
	public $favoritesUri = '';
}
