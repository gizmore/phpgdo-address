<?php
namespace GDO\Address;

use GDO\Core\GDO_Module;
use GDO\User\GDO_User;
use GDO\UI\GDT_Divider;
use GDO\UI\GDT_Link;

/**
 * Module that adds address related functionality.
 * ModuleConfig: site owner address data
 * UserConfig: primary user address
 * UserSettings: primary user address data
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.2.0
 */
final class Module_Address extends GDO_Module
{
	public int $priority = 15;

	public function getClasses() : array
	{
		return [
			GDO_Address::class
		];
	}
	
	public function getDependencies() : array
	{
		return ['Mail', 'Country'];
	}
	
	public function onLoadLanguage() : void { $this->loadLanguage('lang/address'); }
	
	public function getConfig() : array
	{
		return array_merge([
				GDT_Divider::make('div_owner_address')->label('div_owner_address'),
			],
			GDO_Address::table()->gdoColumnsExcept(
				'address_id', 'address_created', 'address_creator',
				'div_company_address', 'div_person_address', 'div_contact_address'
			)
		);
	}
	
	public function cfgCountry() { return $this->getConfigValue('address_country'); }
	public function cfgCountryId() { return $this->getConfigVar('address_country'); }
	public function cfgZIP() { return $this->getConfigVar('address_zip'); }
	public function cfgCity() { return $this->getConfigVar('address_city'); }
	public function cfgStreet() { return $this->getConfigVar('address_street'); }
	
	public function cfgName() { return $this->getConfigVar('address_name'); }
	public function cfgPhone() { return $this->getConfigVar('address_phone'); }
	public function cfgMobile() { return $this->getConfigVar('address_phone_fax'); }
	public function cfgFax() { return $this->getConfigVar('address_phone_mobile'); }
	public function cfgEmail() { return $this->getConfigVar('address_email'); }
	
	public function cfgAddress()
	{
		return GDO_Address::blank([
			'address_name' => $this->cfgName(),
			'address_country' => $this->cfgCountryId(),
			'address_zip' => $this->cfgZIP(),
			'address_city' => $this->cfgCity(),
			'address_street' => $this->cfgStreet(),
			'address_phone' => $this->cfgPhone(),
			'address_phone_fax' => $this->cfgMobile(),
			'address_phone_mobile' => $this->cfgFax(),
			'address_email' => $this->cfgEmail(),
		]);
	}
	
	public function getUserSettings()
	{
		return [
			GDT_Link::make('link_add_address')->href(href('Address', 'Add'))->noacl(),
			GDT_Link::make('link_own_addresses')->href(href('Address', 'OwnAddresses'))->noacl(),
		];
// 		return GDO_Address::table()->gdoColumnsExcept('address_id', 'address_created', 'address_creator');
	}
	
	public function getUserConfig()
	{
		return [
			GDT_Address::make('address'),
		];
	}
	
	public function cfgUserAddress(GDO_User $user)
	{
		if ($address = $this->userSettingValue($user, 'address'))
		{
			return $address;
		}
		else
		{
			return GDO_Address::blank([
				'address_zip' => t('zip'),
				'address_city' => t('city'),
				'address_street' => t('street'),
			]);
		}
	}
	
	############
	### Hook ###
	############
	public function hookUserSettingSaved(GDO_Module $module, GDO_User $user, array $changes)
	{
		if ($module === $this)
		{
			$this->updateUserAddress($user);
		}
	}
	
	private function updateUserAddress(GDO_User $user)
	{
	    $address = GDO_Address::blank([
		    'address_country' => $this->userSettingVar($user, 'address_country'),
		    'address_zip' => $this->userSettingVar($user, 'address_zip'),
		    'address_city' => $this->userSettingVar($user, 'address_city'),
		    'address_street' => $this->userSettingVar($user, 'address_street'),
	    ])->insert();
		$this->saveUserSetting($user, 'address', $address->getID());
	}

}
