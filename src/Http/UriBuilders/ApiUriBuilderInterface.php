<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\UriBuilders;

interface ApiUriBuilderInterface
{
	public function buildIndexUri(): string;

	public function buildStationsUri(): string;

	public function buildStationUri( string $stationId ): string;

	public function buildCurrentTrackUri( string $stationId ): string;

	public function buildStationUsersUri( string $stationId ): string;

	public function buildUsersUri(): string;

	public function buildUserUri( string $userId ): string;

	public function buildUserStationsUri( string $userId ): string;

	public function buildUserFavoritesUri( string $userId ): string;

	public function buildFavoritesUri(): string;

	public function buildFavoriteUri( string $favoriteId ): string;

	public function buildFavoriteUsersUri( string $favoriteId ): string;
}
