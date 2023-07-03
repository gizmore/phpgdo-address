<?php
declare(strict_types=1);
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\Table\MethodQueryTable;
use GDO\UI\GDT_Button;
use GDO\UI\GDT_EditButton;
use GDO\User\GDO_User;

/**
 * Overview of own addresses.
 *
 * @version 7.0.3
 * @since 6.9.0
 * @author gizmore
 */
final class OwnAddresses extends MethodQueryTable
{
    public function isCLI(): bool { return true; }

    public function isUserRequired(): bool { return true; }

	public function getMethodTitle(): string
	{
		return t('list_address_ownaddresses', [$this->getTable()->countItems()]);
	}

	public function gdoTable(): GDO
	{
		return GDO_Address::table();
	}

	public function getQuery(): Query
	{
		$uid = GDO_User::current()->getID();
		return GDO_Address::table()->select()->where("address_creator={$uid}");
	}

	public function gdoHeaders(): array
	{
		$a = GDO_Address::table();
		return [
			GDT_EditButton::make(),
			GDT_Button::make('btn_set_primary_address'),
			$a->gdoColumn('address_id'),
			$a->gdoColumn('address_company'),
			$a->gdoColumn('address_name'),
			$a->gdoColumn('address_street'),
			$a->gdoColumn('address_city'),
		];
	}

}
