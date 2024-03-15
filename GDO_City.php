<?php
namespace GDO\Address;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_String;
use GDO\Core\GDT_UInt;
use GDO\Country\GDT_Country;
use GDO\Maps\GDT_Lat;
use GDO\Maps\GDT_Position;

final class GDO_City extends GDO
{

    public function gdoColumns(): array
    {
        return [
            GDT_AutoInc::make('city_id'),
            GDT_String::make('city_name')->max(196),
            GDT_Country::make('city_country')->notNull(),

            GDT_ZIP::make('city_zip'),
            GDT_UInt::make('city_population'),
            GDT_Position::make('city_pos'),

            GDT_CreatedAt::make('city_created'),
        ];
    }

}
