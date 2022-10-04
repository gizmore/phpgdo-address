<?phpnamespace GDO\Address\tpl;use GDO\Address\GDO_Address;
use GDO\UI\GDT_Card;
/** @var $address GDO_Address **/
$address instanceof GDO_Address;$card = GDT_Card::make();$card->creatorHeader();$cols = $address->gdoColumnsExcept(	'address_id', 'address_created', 'address_creator');foreach ($cols as $gdt){// 	if ($gdt->getVar())// 	{		$card->addField($gdt);// 	}}echo $card->render();
