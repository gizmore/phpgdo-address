<?php
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * ZIP Code.
 * 
 * @TODO implement validator based on city and country in the current gdo, if it has a city and country column. Maybe some optional validatesZIP($bool).
 * @author gizmore
 */
final class GDT_ZIP extends GDT_String
{
    public function defaultLabel() : self { return $this->label('zip'); }
    
    protected function __construct()
    {
        parent::__construct();
        $this->ascii()->caseS()->max(10);
    }
    
    public function plugVar() : string
    {
        return '31224';
    }

}
