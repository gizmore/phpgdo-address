<?php
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * A phone number.
 *
 * @TODO validate existing country phone codes. validate plausible length.
 * @TODO write a phone-validator module that uses gdo6-sms to validate a phone.
 *
 * @version 7.0.1
 * @since 6.8.0
 * @author gizmore
 */
final class GDT_Phone extends GDT_String
{

	protected function __construct()
	{
		parent::__construct();
		$this->min = 6;
		$this->max = 32;
		$this->pattern = '/^\+?[-\/0-9 ]+$/D';
		$this->encoding = self::ASCII;
		$this->caseS();
		$this->icon('phone');
	}

	public function gdtDefaultLabel(): ?string
    {
        return 'phone';
    }

	public function plugVars(): array
	{
		return [
			[$this->getName() => '+49 176 / 59 59 88 44'],
		];
	}

}
