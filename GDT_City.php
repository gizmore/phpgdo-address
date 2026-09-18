<?php
namespace GDO\Address;

use GDO\Core\GDT_ObjectSelect;

final class GDT_City extends GDT_ObjectSelect
{

    protected function __construct()
    {
        parent::__construct(); #PP#delete#
        $this->icon('city');
        $this->table(GDO_City::table());
    }


}
