<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class FavoriteEntity extends AbstractEntity
{
	/** @var string */
	public $canonicalUri = '';

	/** @var string */
	public $id = '';

	/** @var string */
	public $name = '';

	/** @var string */
	public $usersUri = '';

	/** @var ?string */
	public $createdOn = null;
}
