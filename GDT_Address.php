<?php
namespace GDO\Address;

use GDO\Core\GDT_Template;
use GDO\DB\Query;
use GDO\Core\GDO;
use GDO\Core\GDT_ObjectSelect;
use GDO\User\GDO_User;

/**
 * A GDT_Object for GDO_Address.
 * Filter is searching street and country as well.
 * Can restrict to own addresses.
 * @author gizmore
 * @see GDO_Address
 * @version 6.10.6
 * @since 6.02
 */
final class GDT_Address extends GDT_ObjectSelect
{
    ###########
    ### GDT ###
    ###########
	protected function __construct()
	{
	    parent::__construct();
		$this->table(GDO_Address::table());
		$this->orderField = 'address_street';
	}
	
	public function getChoices()
	{
		if ($this->onlyOwn)
		{
		    # current uid
			$uid = GDO_User::current()->getID();
			# autoselect primary address
			if (module_enabled('Address'))
			{
				$this->var(Module_Address::instance()->settingVar('user_address'));
			}
			# query all own addresses
			return $this->table->allWhere("address_creator=$uid");
		}
		return $this->table->all();
	}
	
	/**
	 * @return GDO_Address
	 */
	public function getAddress()
	{
		return $this->getValue();
	}
	
	################
	### Only own ###
	################
	public $onlyOwn = false;
	public function onlyOwn($onlyOwn=true)
	{
	    $this->onlyOwn = $onlyOwn;
	    return $this;
	}
	
	#############
	### Small ###
	#############
	public $small = false;
	public function small($small) { $this->small = $small; return $this; }
	
	##############
	### Render ###
	##############
	public function renderCell() : string
	{
		$tVars = [
			'gdt' => $this,
			'address' => $this->gdo,
		];
		return GDT_Template::php('Address', 'cell/address.php', $tVars);
	}
	
	public function renderPDF() : string
	{
		$tVars = [
			'field' => $this,
			'address' => $this->gdo,
		];
		return GDT_Template::php('Address', 'card/address_pdf.php', $tVars);
	}

	##############
	### Filter ###
	##############
	public function filterQuery(Query $query, $rq=null) : self
	{
		if ($filter = $this->filterVar($rq))
		{
			$filter = GDO::escapeSearchS($filter);
			$this->filterQueryCondition($query, "address_zip LIKE '%$filter%' OR address_city LIKE '%$filter%' OR address_street LIKE '%$filter%'");
		}
	}
	
	public function filterGDO(GDO $gdo, $filtervalue) : bool
	{
		if ($filter = (string)$filtervalue)
		{
			$address = $this->getAddress();
			$fields = array(
				$address->getZIP(),
				$address->getCity(),
				$address->getStreet(),
			);
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
	
	public function validate($value) : bool
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
	        if ($value->getCreator()->getID() != GDO_User::current()->getID())
	        {
	            return $this->error('err_no_permission');
	        }
	    }
	    
	    # passed
	    return true;
	}
	
}
