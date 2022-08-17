<?php
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * A given and lastname.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_Realname extends GDT_String
{
	protected function __construct()
	{
		parent::__construct();
		$this->min(1);
		$this->max(64);
		$this->utf8();
		$this->caseI();
	}
	
}
