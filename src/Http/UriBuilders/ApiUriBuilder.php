<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\UriBuilders;

use CodeKandis\Tiphy\Http\UriBuilders\AbstractUriBuilder;
use CodeKandis\TradioApi\Entities\Enumerations\UriIdentifiers;

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
		return $this->build( UriIdentifiers::INDEX );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildStationsUri(): string
	{
		return $this->build( UriIdentifiers::STATIONS );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildStationUri( string $stationId ): string
	{
		return $this->build( UriIdentifiers::STATION, $stationId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildCurrentTrackUri( string $stationId ): string
	{
		return $this->build( UriIdentifiers::CURRENT_TRACK, $stationId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildStationUsersUri( string $stationId ): string
	{
		return $this->build( UriIdentifiers::STATION_USERS, $stationId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUsersUri(): string
	{
		return $this->build( UriIdentifiers::USERS );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUserUri( string $userId ): string
	{
		return $this->build( UriIdentifiers::USER, $userId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUserStationsUri( string $userId ): string
	{
		return $this->build( UriIdentifiers::USER_STATIONS, $userId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildUserFavoriteTracksUri( string $userId ): string
	{
		return $this->build( UriIdentifiers::USER_FAVORITE_TRACKS, $userId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildFavoriteTracksUri(): string
	{
		return $this->build( UriIdentifiers::FAVORITE_TRACKS );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildFavoriteTrackUri( string $favoriteTrackId ): string
	{
		return $this->build( UriIdentifiers::FAVORITE_TRACK, $favoriteTrackId );
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildFavoriteTrackUsersUri( string $favoriteTrackId ): string
	{
		return $this->build( UriIdentifiers::FAVORITE_TRACK_USERS, $favoriteTrackId );
	}
}
