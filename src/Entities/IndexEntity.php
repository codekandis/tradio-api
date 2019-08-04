<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class IndexEntity extends AbstractEntity
{
	/** @var string */
	public $uri = '';

	/** @var string */
	public $stationsUri = '';

	/** @var string */
	public $usersUri = '';

	/** @var string */
	public $favoritesUri = '';
}
