<?php
declare(strict_types=1);
namespace GDO\Address;

use GDO\Core\GDO;
use GDO\Core\GDO_DBException;
use GDO\Core\GDO_ErrorFatal;
use GDO\Core\GDT;
use GDO\Core\GDT_ObjectSelect;
use GDO\Core\GDT_Template;
use GDO\DB\Query;
use GDO\Table\GDT_Filter;
use GDO\User\GDO_User;

/**
 * A GDT_Object for GDO_Address.
 * Filter is searching street and country as well.
 * Can restrict to own addresses.
 *
 * @version 7.0.3
 * @since 6.02
 * @author gizmore
 * @see GDO_Address
 */
final class GDT_Address extends GDT_ObjectSelect
{

	public bool $onlyOwn = false;

	###########
	### GDT ###
	###########
	public bool $small = false;

	protected function __construct()
	{
		parent::__construct();
		$this->icon('address');
		$this->table(GDO_Address::table());
	}

	public function defaultLabel(): self
	{
		return $this->label('address');
	}

	/**
	 * @throws GDO_DBException
	 * @throws GDO_ErrorFatal
	 */
	public function getChoices(): array
	{
		if ($this->onlyOwn)
		{
			# current uid
			$uid = GDO_User::current()->getID();

// 			if ($uid > 1)
			{
				return $this->table->allWhere("address_creator=$uid");
			}
			# autoselect primary address
// 			if (module_enabled('Address'))
// 			{
// 				$this->var(Module_Address::instance()->settingVar('address'));
// 			}
			# query all own addresses
		}
		return $this->table->all();
	}

	public function onlyOwn(bool $onlyOwn = true): static
	{
		$this->onlyOwn = $onlyOwn;
		return $this;
	}

	public function getAddress(): ?GDO_Address
	{
		return $this->getValue();
	}

	################
	### Only own ###
	################

	public function small(bool $small=true): static
	{
		$this->small = $small;
		return $this;
	}


	##############
	### Render ###
	##############
	public function renderHTML(): string
	{
		$address = $this->getAddress();
		if (!$address)
		{
			return t('---n/a---');
		}
		$tVars = [
			'gdt' => $this,
			'address' => $address,
		];
		return GDT_Template::php('Address', 'address_html.php', $tVars);
	}

	public function renderCard(): string
	{
		return $this->displayCard($this->renderHTML());
	}

	public function renderPDF(): string
	{
		$tVars = [
			'field' => $this,
			'address' => $this->getAddress(),
		];
		return GDT_Template::php('Address', 'address_pdf.php', $tVars);
	}

	##############
	### Filter ###
	##############
	public function filterQuery(Query $query, GDT_Filter $f): static
	{
		if (null !== ($filter = $this->filterVar($f)))
		{
			$filter = GDO::escapeSearchS($filter);
			$this->filterQueryCondition($query, "address_zip LIKE '%$filter%' OR address_city LIKE '%$filter%' OR address_street LIKE '%$filter%'");
		}
		return $this;
	}

	public function filterGDO(GDO $gdo, $filterInput): bool
	{
		if ($filter = (string)$filterInput)
		{
			$address = $this->getAddress();
			$fields = [
				$address->getZIP(),
				$address->getCity(),
				$address->getStreet(),
			];
			foreach ($fields as $field)
			{
				if (mb_strpos($field, $filter) !== false)
				{
					return true;
				}
			}
		}
		return false;
	}

	################
	### Validate ###
	################
	public function validate(int|float|string|array|null|object|bool $value): bool
	{
		# not null etc
		if (!parent::validate($value))
		{
			return false;
		}

		# null seems fine
		if ($value === null)
		{
			return true;
		}

		# Check if only own rule applies
		if ($this->onlyOwn)
		{
			$uid = GDO_User::current()->getID();
			if ($uid > 1)
			{
				if ($value->getCreator()->getID() != $uid)
				{
					return $this->error('err_permission_required');
				}
			}
		}

		# passed
		return true;
	}

	public function plugVars(): array
	{
		if (isset($this->table))
		{
			$query = $this->table->select()->first();
			if ($this->onlyOwn)
			{
				$query->where('address_creator=' . GDO_User::current()->getID());
			}
			$first = $query->exec()->fetchObject();
			if ($first)
			{
				return [
					[$this->name => $first->getID()],
				];
			}
		}
		return GDT::EMPTY_ARRAY;
	}

}
