<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\UriBuilders;

use CodeKandis\Tiphy\Http\UriBuilders\AbstractUriBuilder;

class ApiUriBuilder extends AbstractUriBuilder
{
	public function getIndexUri(): string
	{
		return $this->getUri( 'index' );
	}

	public function getStationsUri(): string
	{
		return $this->getUri( 'stations' );
	}

	public function getStationUri( string $stationId ): string
	{
		return $this->getUri( 'station', $stationId );
	}

	public function getCurrentTrackUri( string $stationId ): string
	{
		return $this->getUri( 'currentTrack', $stationId );
	}

	public function getStationUsersUri( string $stationId ): string
	{
		return $this->getUri( 'stationUsers', $stationId );
	}

	public function getUsersUri(): string
	{
		return $this->getUri( 'users' );
	}

	public function getUserUri( string $userId ): string
	{
		return $this->getUri( 'user', $userId );
	}

	public function getUserStationsUri( string $userId ): string
	{
		return $this->getUri( 'userStations', $userId );
	}

	public function getUserFavoritesUri( string $userId ): string
	{
		return $this->getUri( 'userFavorites', $userId );
	}

	public function getFavoritesUri(): string
	{
		return $this->getUri( 'favorites' );
	}

	public function getFavoriteUri( string $favoriteId ): string
	{
		return $this->getUri( 'favorite', $favoriteId );
	}

	public function getFavoriteUsersUri( string $favoriteId ): string
	{
		return $this->getUri( 'favoriteUsers', $favoriteId );
	}
}
