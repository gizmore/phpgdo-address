<?php
namespace GDO\Address\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Address\GDO_Address;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\Core\Website;
use GDO\Util\Common;
use GDO\Address\Module_Address;

/**
 * Add an address to your account.
 * @author gizmore
 * @version 6.10.1
 * @since 6.4.0
 */
final class AddAddress extends MethodForm
{
	public function createForm(GDT_Form $form) : void
	{
		$fields = GDO_Address::table()->gdoColumnsExcept('address_id', 'address_creator', 'address_created');
		$form->addFields($fields);
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		$address = GDO_Address::blank($form->getFormVars())->insert();
		Module_Address::instance()->saveSetting('user_address', $address->getID());
		return $this->message('msg_address_created_and_selected')->addField(Website::redirect(Common::getRequestString('rb')));
	}

}
