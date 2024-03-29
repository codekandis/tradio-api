<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\UriExtenders;

use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilderInterface;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;

/**
 * Represents a user API URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UserApiUriExtender extends AbstractApiUriExtender
{
	/**
	 * Stores the user to extend its URIs.
	 * @var UserEntityInterface
	 */
	private UserEntityInterface $user;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param UserEntityInterface $user The user to extend its URIs.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, UserEntityInterface $user )
	{
		parent::__construct( $apiUriBuilder );

		$this->user = $user;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addUserStationsUri();
		$this->addUserFavoriteTracksUri();
	}

	/**
	 * Adds the canonical URI of the user.
	 */
	private function addCanonicalUri(): void
	{
		$this->user->canonicalUri = $this->apiUriBuilder->buildUserUri( $this->user->id );
	}

	/**
	 * Adds the URI of the stations favored by the user.
	 */
	private function addUserStationsUri(): void
	{
		$this->user->stationsUri = $this->apiUriBuilder->buildUserStationsUri( $this->user->id );
	}

	/**
	 * Adds the URI of the tracks favored by the user.
	 */
	private function addUserFavoriteTracksUri(): void
	{
		$this->user->favoriteTracksUri = $this->apiUriBuilder->buildUserFavoriteTracksUri( $this->user->id );
	}
}
