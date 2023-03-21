<?php
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Address\GDT_Address;
use GDO\Address\Module_Address;
use GDO\Core\Method;

/**
 * Set primary address for a user.
 *
 * @author gizmore
 */
final class SetPrimary extends Method
{

	private GDO_Address $address;

	public function gdoParameters(): array
	{
		return [
			GDT_Address::make('id')->onlyOwn()->notNull(),
		];
	}

	public function onMethodInit()
	{
		$this->address = $this->gdoParameterValue('id');
	}

	public function execute()
	{
		Module_Address::instance()->saveSetting('address', $this->address->getID());
		return $this->redirectMessage('msg_address_set_primary', null)->back();
	}

}
