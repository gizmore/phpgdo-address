<?php
namespace GDO\Address\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Address\GDO_Address;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\Util\Common;
use GDO\Address\Module_Address;
use GDO\UI\GDT_Redirect;

/**
 * Add an address to your account.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.4.0
 */
final class Add extends MethodForm
{
	public function createForm(GDT_Form $form) : void
	{
		$fields = GDO_Address::table()->gdoColumnsExcept('address_id', 'address_creator', 'address_created');
		$form->addFields(...$fields);
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		$address = GDO_Address::blank($form->getFormVars())->insert();
		Module_Address::instance()->saveSetting('address', $address->getID());
		return GDT_Redirect::make()->redirectMessage('msg_address_created_and_selected')->
			href(Common::getRequestString('rb', href('Account', 'AllSettings')));
	}

}
