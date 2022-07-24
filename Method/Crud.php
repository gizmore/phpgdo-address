<?php
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Core\GDO;
use GDO\Form\MethodCrud;

final class Crud extends MethodCrud
{
	public function showInSitemap() : bool { return false; }
	
	public function hrefList() { return href('Address', 'AddressList'); }

	public function gdoTable() : GDO { return GDO_Address::table(); }
	
}
