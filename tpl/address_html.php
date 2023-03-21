<?php
namespace GDO\Address\tpl;

use GDO\Address\GDO_Address;
use GDO\Address\GDT_Address;
use GDO\Country\GDO_Country;

/**
 * @var GDT_Address $gdt
 * @var GDO_Address $address
 */
$country = GDO_Country::getByISOOrUnknown($address->getCountryID());
?>
<?php
if (!$address->emptyAddress()) : ?>
	<?php
	echo $address->getNameOrCompany(); ?>,
	<?php
	echo $address->getStreet(); ?>,
	<?php
	echo html($address->getCity()); ?>,
	<?php
	echo $country->renderFlag(); ?>
<?php
else: ?>
	<?php
	echo t('---n/a---'); ?>
<?php
endif; ?>
