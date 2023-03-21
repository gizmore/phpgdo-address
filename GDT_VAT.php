<?php
namespace GDO\Address;

use GDO\Core\GDT_String;

/**
 * Tax number.
 *
 * @TODO tax validation, depending on country...
 * @author gizmore
 */
final class GDT_VAT extends GDT_String
{

	public int $max = 32;
	public int $encoding = self::ASCII;
	public bool $caseSensitive = false;

	public function defaultLabel(): self { return $this->label('vat'); }

	public function plugVars(): array
	{
		return [
			[$this->getName() => '38/107/05324'],
		];
	}

}
