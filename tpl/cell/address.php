<?php
use GDO\Address\GDO_Address;
use GDO\Address\GDT_Address;
use GDO\Country\GDO_Country;

/**
 * @var GDT_Address $gdt;
 */
$gdt instanceof GDT_Address;
$gdo = $gdt->gdo;
$address = GDO_Address::blank($gdo->getGDOVars());
$country = GDO_Country::getByISOOrUnknown($address->getCountryID());
?>
<?php if (!$address->emptyAddress()) : ?>
<?php echo $address->getStreet(); ?>,
<?php echo html($address->getCity()); ?>,
<?php echo $country->renderFlag(); ?>
<?php else: ?>
<?php echo t('---n/a---'); ?>
<?php endif; ?>
