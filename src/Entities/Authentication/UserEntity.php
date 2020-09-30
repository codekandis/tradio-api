<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\Authentication;

use CodeKandis\Tiphy\Entities\AbstractEntity;

class UserEntity extends AbstractEntity
{
	/** @var string */
	public $id = '';

	/** @var string */
	public $isActive = '';

	/** @var string */
	public $name = '';

	/** @var string */
	public $email = '';

	/** @var string */
	public $apiKey = '';
}
