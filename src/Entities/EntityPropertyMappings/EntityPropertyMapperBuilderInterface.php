<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\EntityPropertyMappings;

use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMapperInterface;

/**
 * Represents the interface of any entity property mapper builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface EntityPropertyMapperBuilderInterface
{
	/**
	 * Builds the entity property mapper of the station entity.
	 * @return EntityPropertyMapperInterface The entity property mapper of the station entity.
	 */
	public function buildStationEntityPropertyMapper(): EntityPropertyMapperInterface;

	/**
	 * Builds the entity property mapper of the current track entity.
	 * @return EntityPropertyMapperInterface The entity property mapper of the current track entity.
	 */
	public function buildCurrentTrackEntityPropertyMapper(): EntityPropertyMapperInterface;

	/**
	 * Builds the entity property mapper of the favorite track entity.
	 * @return EntityPropertyMapperInterface The entity property mapper of the favorite track entity.
	 */
	public function buildFavoriteTrackEntityPropertyMapper(): EntityPropertyMapperInterface;

	/**
	 * Builds the entity property mapper of the user entity.
	 * @return EntityPropertyMapperInterface The entity property mapper of the user entity.
	 */
	public function buildUserEntityPropertyMapper(): EntityPropertyMapperInterface;
}
