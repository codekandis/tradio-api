<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

use DateTimeImmutable;

/**
 * Represents a favorite track.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteEntity extends AbstractPersistableEntity implements FavoriteEntityInterface
{
	/**
	 * Stores the name of the favorite track.
	 * @var string
	 */
	public string $name = '';

	/**
	 * Stores the URI of the users who favored the track.
	 * @var string
	 */
	public string $usersUri = '';

	/**
	 * Stores the timestamp when the favorite has been created.
	 * @var DateTimeImmutable
	 */
	public DateTimeImmutable $timestampCreated;

	/**
	 * Constructor method.
	 */
	public function __construct()
	{
		$this->initialize();
	}

	/**
	 * Initializes the favorite track.
	 */
	public function initialize(): void
	{
		$this->timestampCreated = new DateTimeImmutable();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setName( string $name ): void
	{
		$this->name = $name;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getUsersUri(): string
	{
		return $this->usersUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setUsersUri( string $usersUri ): void
	{
		$this->usersUri = $usersUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTimestampCreated(): DateTimeImmutable
	{
		return $this->timestampCreated;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setTimestampCreated( DateTimeImmutable $timestampCreated ): void
	{
		$this->timestampCreated = $timestampCreated;
	}
}
