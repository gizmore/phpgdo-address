<?php
namespace GDO\Address\Method;

use GDO\Table\MethodQueryTable;
use GDO\Address\GDO_Address;
use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\User\GDO_User;
use GDO\UI\GDT_Button;

/**
 * Overview of own addresses.
 * @author gizmore
 * @version 7.0.1
 * @since 6.9.0
 */
final class OwnAddresses extends MethodQueryTable
{
	public function isUserRequired() : bool { return true; }
	
	public function getMethodTitle() : string
	{
		return t('list_address_ownaddresses', [$this->getCountQuery()->exec()->fetchValue()]);
	}
	
	public function gdoTable() : GDO
	{
	    return GDO_Address::table();
	}
	
	public function getQuery() : Query
	{
		$uid = GDO_User::current()->getID();
		return GDO_Address::table()->select()->where("address_creator={$uid}");
	}
	
	public function gdoHeaders() : array
	{
		$a = GDO_Address::table();
		return [
			GDT_Button::make('btn_set_primary_address'),
			$a->gdoColumn('address_id'),
			$a->gdoColumn('address_company'),
			$a->gdoColumn('address_name'),
			$a->gdoColumn('address_street'),
			$a->gdoColumn('address_city'),
		];
	}
	
}
