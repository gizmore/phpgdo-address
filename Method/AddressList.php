<?php
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Core\GDO;
use GDO\Table\MethodQueryList;

final class AddressList extends MethodQueryList
{
	public function getPermission() : ?string { return 'staff'; }
	
	public function gdoTable() : GDO { return GDO_Address::table(); }

	public function getMethodTitle() : string
	{
		return t('list_address_list');
	}
	
}
