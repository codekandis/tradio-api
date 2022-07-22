<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\EntityPropertyMappings;

use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMapper;
use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMapperInterface;
use CodeKandis\TradioApi\Environment\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Environment\Entities\StationEntity;
use CodeKandis\TradioApi\Environment\Entities\UserEntity;
use ReflectionException;

/**
 * Represents an entity property mapper builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class EntityPropertyMapperBuilder implements EntityPropertyMapperBuilderInterface
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The station entity class to reflect does not exist.
	 */
	public function buildStationEntityPropertyMapper(): EntityPropertyMapperInterface
	{
		return new EntityPropertyMapper( StationEntity::class, new StationEntityPropertyMappings() );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The current track entity class to reflect does not exist.
	 */
	public function buildCurrentTrackEntityPropertyMapper(): EntityPropertyMapperInterface
	{
		return new EntityPropertyMapper( CurrentTrackEntity::class, new CurrentTrackEntityPropertyMappings() );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 */
	public function buildFavoriteTrackEntityPropertyMapper(): EntityPropertyMapperInterface
	{
		return new EntityPropertyMapper( FavoriteTrackEntity::class, new FavoriteTrackEntityPropertyMappings() );
	}

	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The user entity class to reflect does not exist.
	 */
	public function buildUserEntityPropertyMapper(): EntityPropertyMapperInterface
	{
		return new EntityPropertyMapper( UserEntity::class, new UserEntityPropertyMappings() );
	}
}
