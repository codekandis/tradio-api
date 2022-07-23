<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\EntityPropertyMappings;

use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMapping;
use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMappingExistsException;
use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMappingInterface;

/**
 * Represents the entity property mappings of the station entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationEntityPropertyMappings extends AbstractPersistableEntityPropertyMappings
{
	/**
	 * Constructor method.
	 * @param EntityPropertyMappingInterface ...$entityPropertyMappings The additional entity property mappings.
	 * @throws EntityPropertyMappingExistsException An entity property mapping with a specific property name already exists.
	 */
	public function __construct( EntityPropertyMappingInterface ...$entityPropertyMappings )
	{
		parent::__construct(
			new EntityPropertyMapping( 'name', null ),
			new EntityPropertyMapping( 'streamUri', null ),
			new EntityPropertyMapping( 'tracklistUri', null ),
			new EntityPropertyMapping( 'tracklistType', null ),
			new EntityPropertyMapping( 'currentTrackSelector', null ),
			new EntityPropertyMapping( 'currentTrackUri', null ),
			new EntityPropertyMapping( 'usersUri', null ),
			...$entityPropertyMappings
		);
	}
}
