<?php
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Address\Module_Address;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Net\GDT_Url;
use GDO\UI\GDT_Redirect;

/**
 * Add an address to your account.
 *
 * @version 7.0.1
 * @since 6.4.0
 * @author gizmore
 */
final class Add extends MethodForm
{

	public function gdoParameters(): array
	{
		return [
			GDT_Url::make('_rb')->notNull()->allowInternal(),
		];
	}

	public function createForm(GDT_Form $form): void
	{
		$fields = GDO_Address::table()->gdoColumnsExcept('address_id', 'address_creator', 'address_created');
		$form->addFields(...$fields);
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		$back = $this->gdoParameterVar('_rb');
		$address = GDO_Address::blank($form->getFormVars())->insert();
		Module_Address::instance()->saveSetting('address', $address->getID());
		return GDT_Redirect::make()->redirectMessage('msg_address_created_and_selected')->
		href($back);
	}

}
