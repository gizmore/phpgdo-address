<?php
namespace GDO\Address\Method;

use GDO\Address\GDO_Address;
use GDO\Address\Module_Address;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\User\GDO_User;

/**
 *
 * GDT_AutoInc::make('address_id'),
 * GDT_Divider::make('div_company_address')->label('div_company_address'),
 * GDT_Realname::make('address_company')->label('company'),
 * GDT_Date::make('address_est')->label('established'),
 * GDT_VAT::make('address_vat'),
 * # Required
 * GDT_Divider::make('div_person_address')->label('div_person_address'),
 * GDT_Realname::make('address_name')->label('address_name'),
 * GDT_String::make('address_street')->max(128)->label('street'),
 * GDT_ZIP::make('address_zip'),
 * GDT_String::make('address_city')->max(128)->label('city'),
 * GDT_Country::make('address_country')->focusable(false),
 * # Optional
 * GDT_Divider::make('div_contact_address')->label('div_contact_address'),
 * GDT_Phone::make('address_phone')->label('phone'),
 * GDT_Phone::make('address_phone_fax')->label('fax'),
 * GDT_Phone::make('address_phone_mobile')->label('mobilephone'),
 * GDT_Email::make('address_email')->label('email'),
 * # Special
 * GDT_CreatedAt::make('address_created'),
 * GDT_CreatedBy::make('address_creator'),
 */
final class Edit extends MethodForm
{

    protected function createForm(GDT_Form $form): void
    {
        $form->addFields(...GDO_Address::table()->gdoColumnsExcept(
            'address_id', 'address_created', 'address_creator'));
        $form->addField(GDT_AntiCSRF::make());
        $form->actions()->addField(GDT_Submit::make());
    }

    /**
     * @throws GDO_DBException
     */
    protected function getPrimaryAddress(): GDO_Address
    {
        $user = GDO_User::current();
        $addr = Module_Address::instance()->cfgUserAddress($user);
        if (!$addr->isPersisted())
        {
            $addr->save();
            $user->saveSettingVar('Address', 'address', $addr->getID());
            $this->message('msg_address_edit_created');
        }
        return $addr;
    }

    /**
     * @throws GDO_DBException
     */
    public function formValidated(GDT_Form $form): GDT
    {
        $addr = $this->getPrimaryAddress();
        $addr->saveVars($form->getFormVars());
        return $this->message('msg_address_edit_saved');
    }

}
