<?php
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * A phone number.
 * 
 * @TODO validate existing country phone codes. validate plausible length.
 * @TODO write a phone-validator module that uses gdo6-sms to validate a phone.
 * 
 * @author gizmore
 * @version 6.10.4
 * @since 6.8.0
 */
final class GDT_Phone extends GDT_String
{
	public function defaultLabel() : self { return $this->label('phone'); }
	
	protected function __construct()
	{
	    parent::__construct();
		$this->min = 7;
		$this->max = 20;
		$this->pattern = "/^\\+?[-\\/0-9 ]+$/D";
		$this->encoding = self::ASCII;
		$this->caseS();
		$this->icon('phone');
	}
	
	public function plugVar() : string
	{
	    return '+49 176 / 59 59 88 44';
	}
	
}
