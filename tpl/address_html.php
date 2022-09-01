<?php
namespace GDO\Address\tpl;
use GDO\Country\GDO_Country;
/**
 * @var \GDO\Address\GDT_Address $gdt
 * @var \GDO\Address\GDO_Address $address
 */
$country = GDO_Country::getByISOOrUnknown($address->getCountryID());
?>
<?php if (!$address->emptyAddress()) : ?>
<?php echo $address->getStreet(); ?>,
<?php echo html($address->getCity()); ?>,
<?php echo $country->renderFlag(); ?>
<?php else: ?>
<?php echo t('---n/a---'); ?>
<?php endif; ?>
