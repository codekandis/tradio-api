<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\UriBuilders;

use CodeKandis\Tiphy\Http\UriBuilders\AbstractUriBuilder;

/**
 * Represents an API URI builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class ApiUriBuilder extends AbstractUriBuilder implements ApiUriBuilderInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function buildIndexUri(): string
	{
		return $this->build( 'index' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildStationsUri(): string
	{
		return $this->build( 'stations' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildStationUri( string $stationId ): string
	{
		return $this->build( 'station', $stationId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildCurrentTrackUri( string $stationId ): string
	{
		return $this->build( 'currentTrack', $stationId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildStationUsersUri( string $stationId ): string
	{
		return $this->build( 'stationUsers', $stationId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUsersUri(): string
	{
		return $this->build( 'users' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUserUri( string $userId ): string
	{
		return $this->build( 'user', $userId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUserStationsUri( string $userId ): string
	{
		return $this->build( 'userStations', $userId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUserFavoritesUri( string $userId ): string
	{
		return $this->build( 'userFavorites', $userId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildFavoritesUri(): string
	{
		return $this->build( 'favorites' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildFavoriteUri( string $favoriteId ): string
	{
		return $this->build( 'favorite', $favoriteId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildFavoriteUsersUri( string $favoriteId ): string
	{
		return $this->build( 'favoriteUsers', $favoriteId );
	}
}
