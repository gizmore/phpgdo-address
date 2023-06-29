<?php
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * ZIP Code.
 *
 * @TODO implement validator based on city and country in the current gdo, if it has a city and country column. Maybe some optional validatesZIP($bool).
 * @author gizmore
 */
final class GDT_ZIP extends GDT_String
{

	protected function __construct()
	{
		parent::__construct();
		$this->ascii()->caseS()->max(10);
	}

	public function gdtDefaultLabel(): ?string
    {
        return 'zip';
    }

	public function plugVars(): array
	{
		return [
			[$this->getName() => '31224'],
		];
	}

}
