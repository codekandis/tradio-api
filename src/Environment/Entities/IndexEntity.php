<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities;

/**
 * Represents the API index.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class IndexEntity extends AbstractEntity implements IndexEntityInterface
{
	/**Stores the URI of the stations.
	 * @var string
	 */
	public string $stationsUri = '';

	/**
	 * Stores the URI of the favored tracks.
	 * @var string
	 */
	public string $favoriteTracksUri = '';

	/**
	 * Stores the URI of the users.
	 * @var string
	 */
	public string $usersUri = '';

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

	/**
	 * {@inheritDoc}
	 */
	public function getUsersUri(): string
	{
		return $this->stationsUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setUsersUri( string $usersUri ): void
	{
		$this->usersUri = $usersUri;
	}
}
