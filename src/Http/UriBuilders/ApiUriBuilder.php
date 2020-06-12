<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\UriBuilders;

use CodeKandis\Tiphy\Http\UriBuilders\AbstractUriBuilder;

class ApiUriBuilder extends AbstractUriBuilder implements ApiUriBuilderInterface
{
	public function buildIndexUri(): string
	{
		return $this->build( 'index' );
	}

	public function buildStationsUri(): string
	{
		return $this->build( 'stations' );
	}

	public function buildStationUri( string $stationId ): string
	{
		return $this->build( 'station', $stationId );
	}

	public function buildCurrentTrackUri( string $stationId ): string
	{
		return $this->build( 'currentTrack', $stationId );
	}

	public function buildStationUsersUri( string $stationId ): string
	{
		return $this->build( 'stationUsers', $stationId );
	}

	public function buildUsersUri(): string
	{
		return $this->build( 'users' );
	}

	public function buildUserUri( string $userId ): string
	{
		return $this->build( 'user', $userId );
	}

	public function buildUserStationsUri( string $userId ): string
	{
		return $this->build( 'userStations', $userId );
	}

	public function buildUserFavoritesUri( string $userId ): string
	{
		return $this->build( 'userFavorites', $userId );
	}

	public function buildFavoritesUri(): string
	{
		return $this->build( 'favorites' );
	}

	public function buildFavoriteUri( string $favoriteId ): string
	{
		return $this->build( 'favorite', $favoriteId );
	}

	public function buildFavoriteUsersUri( string $favoriteId ): string
	{
		return $this->build( 'favoriteUsers', $favoriteId );
	}
}
