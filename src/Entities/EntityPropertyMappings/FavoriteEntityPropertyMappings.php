<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\EntityPropertyMappings;

use CodeKandis\Converters\BiDirectionalConverters\DateTimeImmutableToStringBiDirectionalConverter;
use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMapping;
use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMappingExistsException;
use CodeKandis\Entities\EntityPropertyMappings\EntityPropertyMappingInterface;
use CodeKandis\TradioApi\Entities\Enumerations\DateTimeFormats;

/**
 * Represents the entity property mappings of the favorite track entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteEntityPropertyMappings extends AbstractPersistableEntityPropertyMappings
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
			new EntityPropertyMapping( 'usersUri', null ),
			new EntityPropertyMapping( 'timestampCreated', new DateTimeImmutableToStringBiDirectionalConverter( DateTimeFormats::LONG ) ),
			...$entityPropertyMappings
		);
	}
}
