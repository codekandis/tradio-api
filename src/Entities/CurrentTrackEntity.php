<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

/**
 * Represents a currently playing track.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackEntity extends AbstractEntity implements CurrentTrackEntityInterface
{
	/**
	 * Stores the name of the track.
	 * @var string
	 */
	public string $name = '';

	/**
	 * Stores the ID of the station playing the track.
	 * @var string
	 */
	public string $stationId = '';

	/**
	 * Stores the ID of the station playing the track.
	 * @var string
	 */
	public string $stationUri = '';

	/**
	 * Stores the URI of the persisted favored track of the currently playing track.
	 * @var ?string
	 */
	public ?string $favoriteUri = null;

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
	public function getStationId(): string
	{
		return $this->stationId;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setStationId( string $stationId ): void
	{
		$this->stationId = $stationId;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStationUri(): string
	{
		return $this->stationUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setStationUri( string $stationUri ): void
	{
		$this->stationUri = $stationUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFavoriteUri(): ?string
	{
		return $this->favoriteUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setFavoriteUri( ?string $favoriteUri ): void
	{
		$this->favoriteUri = $favoriteUri;
	}
}
