<?phpuse GDO\Address\GDO_Address;
use GDO\UI\GDT_Card;
/** @var $address GDO_Address **/
$address instanceof GDO_Address;$card = GDT_Card::make();foreach ($address->gdoColumnsExcept('address_id', 'address_created', 'address_creator') as $gdt){	if ($gdt->getVar())	{		$card->addField($gdt);	}}echo $card->renderCard();
