<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class UserEntity extends AbstractEntity
{
	/** @var string */
	public $uri = '';

	/** @var string */
	public $id = '';

	/** @var string */
	public $name = '';

	/** @var string */
	public $password = '';

	/** @var string */
	public $email = '';

	/** @var string */
	public $stationsUri = '';

	/** @var string */
	public $favoritesUri = '';
}
