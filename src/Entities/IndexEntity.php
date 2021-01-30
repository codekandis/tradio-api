<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class IndexEntity extends AbstractEntity
{
	/** @var string */
	public string $canonicalUri = '';

	/** @var string */
	public string $stationsUri = '';

	/** @var string */
	public string $usersUri = '';

	/** @var string */
	public string $favoritesUri = '';
}
