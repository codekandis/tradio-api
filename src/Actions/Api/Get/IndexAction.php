<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Actions\AbstractWithApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\IndexEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\IndexApiUriExtender;
use JsonException;

class IndexAction extends AbstractWithApiUriBuilderAction
{
	/**
	 * @throws JsonException
	 */
	public function execute(): void
	{
		$index = new IndexEntity;
		$this->extendUris( $index );

		$responderData = [
			'index' => $index,
		];
		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
	}

	private function extendUris( $index ): void
	{
		( new IndexApiUriExtender(
			$this->getApiUriBuilder(),
			$index
		) )
			->extend();
	}
}
