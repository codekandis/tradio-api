<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities;

/**
 * Represents a station.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationEntity extends AbstractPersistableEntity implements StationEntityInterface
{
	/**
	 * Stores the name of the station.
	 * @var string
	 */
	public string $name = '';

	/**
	 * Stores the stream URI of the station.
	 * @var string
	 */
	public string $streamUri = '';

	/**
	 * Stores the tracklist URI of the station.
	 * @var string
	 */
	public string $tracklistUri = '';

	/**
	 * Stores the tracklist type of the station.
	 * @var string
	 */
	public string $tracklistType = '';

	/**
	 * Stores the selector to fetch the currently playing track.
	 * @var string
	 */
	public string $currentTrackSelector = '';

	/**
	 * Stores the URI of the currently playing track.
	 * @var string
	 */
	public string $currentTrackUri = '';

	/**
	 * Stores the URI of the users who favored the station.
	 * @var string
	 */
	public string $usersUri = '';

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
	public function getStreamUri(): string
	{
		return $this->streamUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setStreamUri( string $streamUri ): void
	{
		$this->streamUri = $streamUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTracklistUri(): string
	{
		return $this->tracklistUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setTracklistUri( string $tracklistUri ): void
	{
		$this->tracklistUri = $tracklistUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTracklistType(): string
	{
		return $this->tracklistType;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setTracklistType( string $tracklistType ): void
	{
		$this->tracklistType = $tracklistType;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getCurrentTrackSelector(): string
	{
		return $this->currentTrackSelector;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setCurrentTrackSelector( string $currentTrackSelector ): void
	{
		$this->currentTrackSelector = $currentTrackSelector;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getCurrentTrackUri(): string
	{
		return $this->currentTrackUri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setCurrentTrackUri( string $currentTrackUri ): void
	{
		$this->currentTrackUri = $currentTrackUri;
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
}
