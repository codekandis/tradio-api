<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class FavoriteEntity extends AbstractEntity
{
	/** @var string */
	public string $canonicalUri = '';

	/** @var string */
	public string $id = '';

	/** @var string */
	public string $name = '';

	/** @var string */
	public string $usersUri = '';

	/** @var null|string */
	public ?string $createdOn = null;
}
