<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\UserEntityInterface;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

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
		$this->addUserFavoritesUri();
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
	private function addUserFavoritesUri(): void
	{
		$this->user->favoritesUri = $this->apiUriBuilder->buildUserFavoritesUri( $this->user->id );
	}
}
