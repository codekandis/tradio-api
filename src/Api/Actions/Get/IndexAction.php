<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Api\Actions\AbstractAction;
use CodeKandis\TradioApi\Environment\Entities\IndexEntity;
use CodeKandis\TradioApi\Environment\Entities\IndexEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UriExtenders\IndexApiUriExtender;
use JsonException;

/**
 * Represents the action to retrieve the API index.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class IndexAction extends AbstractAction
{
	/**
	 * {@inheritDoc}
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		$index = new IndexEntity;
		$this->extendUris( $index );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'index' => $index,
			]
		) )
			->respond();
	}

	/**
	 * Extends the URIs of an index.
	 * @param IndexEntityInterface $index The index to extend its URIs.
	 */
	private function extendUris( IndexEntityInterface $index ): void
	{
		( new IndexApiUriExtender(
			$this->getApiUriBuilder(),
			$index
		) )
			->extend();
	}
}
