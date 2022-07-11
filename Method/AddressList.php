<?php
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Table\MethodQueryList;

final class AddressList extends MethodQueryList
{
	public function getPermission() : ?string { return 'staff'; }
	
	public function gdoTable() { return GDO_Address::table(); }
}
