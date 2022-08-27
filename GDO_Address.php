<?php
namespace GDO\Address;

use GDO\Country\GDO_Country;
use GDO\Country\GDT_Country;
use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_Template;
use GDO\Core\GDT_String;
use GDO\Mail\GDT_Email;
use GDO\UI\GDT_Divider;
use GDO\User\GDO_User;

/**
 * An address object.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.2.0
 */
final class GDO_Address extends GDO
{
	###########
	### GDO ###
	###########
	public function gdoColumns() : array
	{
		return [
			GDT_AutoInc::make('address_id'),
			GDT_Divider::make('div_company_address')->label('div_company_address'),
			GDT_Realname::make('address_company')->label('company'),
			GDT_VAT::make('address_vat'),
			# Required
			GDT_Divider::make('div_person_address')->label('div_person_address'),
			GDT_Realname::make('address_name')->label('address_name'),
			GDT_String::make('address_street')->max(128)->label('street'),
			GDT_ZIP::make('address_zip'),
			GDT_String::make('address_city')->max(128)->label('city'),
			GDT_Country::make('address_country')->notNull(),
			# Optional
			GDT_Divider::make('div_contact_address')->label('div_contact_address'),
			GDT_Phone::make('address_phone')->label('phone'),
			GDT_Phone::make('address_phone_fax')->label('fax'),
			GDT_Phone::make('address_phone_mobile')->label('mobilephone'),
			GDT_Email::make('address_email')->label('email'),
			# Special
			GDT_CreatedAt::make('address_created'),
			GDT_CreatedBy::make('address_creator'),
		];
	}
	
	##############
	### Getter ###
	##############
	public function getCountry() : ?GDO_Country { return $this->gdoValue('address_country'); }
	public function getCountryID() { return $this->gdoVar('address_country'); }
	public function getZIP() { return $this->gdoVar('address_zip'); }
	public function getCity() { return $this->gdoVar('address_city'); }
	public function getStreet() { return $this->gdoVar('address_street'); }
	public function getRealName() { return $this->gdoVar('address_name'); }
	
	public function getPhone() { return $this->gdoVar('address_phone'); }
	public function getFax() { return $this->gdoVar('address_phone_fax'); }
	public function getMobile() { return $this->gdoVar('address_phone_mobile'); }
	public function getEmail() { return $this->gdoVar('address_email'); }
	
	public function getVAT() { return $this->gdoVar('address_vat'); }
	public function getCompany() { return $this->gdoVar('address_company'); }
	
	public function getCreator() : GDO_User { return $this->gdoValue('address_creator'); }
	public function getCreatorId() : string { return $this->gdoVar('address_creator'); }
	
	public function getAddressLine() : string
	{
		$line = $this->getStreet() . ', ' . $this->getZIP() . ' ' .  $this->getCity();
		return trim($line, ' ,');
	}
	
	##############
	### Helper ###
	##############
	public function emptyAddress()
	{
		return (!($this->getCountryID() || $this->getZIP() || $this->getStreet() || $this->getCity()));
	}
	
	############
	### HREF ###
	############
	public function href_edit() { return href('Address', 'Crud', '&id='.$this->getID()); }
	public function href_btn_set_primary_address() { return href('Address', 'SetPrimary', "&id={$this->getID()}"); }

	##############
	### Render ###
	##############
	public function renderHTML() : string { return GDT_Address::make()->gdo($this)->renderHTML(); }
	public function renderList() : string { return GDT_Template::php('Address', 'listitem/address.php', ['address' => $this]); }
	public function renderCard() : string { return GDT_Template::php('Address', 'card/address.php', ['address' => $this]); }
	public function renderOption() : string { return t('address_choice', [$this->gdoDisplay('address_name'), $this->gdoDisplay('address_street')]); }

}
