<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

/**
 * Represents a user.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserEntity extends AbstractPersistableEntity implements UserEntityInterface
{
	/**
	 * Stores the name of the user.
	 * @var string
	 */
	public string $name = '';

	/**
	 * Stores the e-mail of the user.
	 * @var string
	 */
	public string $eMail = '';

	/**
	 * Stores the URI of the favored stations of the user.
	 * @var string
	 */
	public string $stationsUri = '';

	/**
	 * Stores the URI of the favored tracks of the user.
	 * @var string
	 */
	public string $favoriteTracksUri = '';

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
	public function getEMail(): string
	{
		return $this->eMail;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setEMail( string $eMail ): void
	{
		$this->eMail = $eMail;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStationsUri(): string
	{
		return $this->stationsUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setStationsUri( string $stationsUri ): void
	{
		$this->stationsUri = $stationsUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFavoriteTracksUri(): string
	{
		return $this->favoriteTracksUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setFavoriteTracksUri( string $favoriteTracksUri ): void
	{
		$this->favoriteTracksUri = $favoriteTracksUri;
	}
}
