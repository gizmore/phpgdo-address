<?php
declare(strict_types=1);
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * Tax number.
 *
 * @TODO tax validation, depending on country...
 * @author gizmore
 * @version 7.0.3
 */
final class GDT_VAT extends GDT_String
{
	public ?int $max = 32;
	public int $encoding = self::ASCII;
	public bool $caseSensitive = false;

	public function gdtDefaultLabel(): ?string
    {
        return 'vat';
    }

	public function plugVars(): array
	{
		return [
			[$this->getName() => '38/107/05324'],
		];
	}

}
