<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $contactUs->getName();

$this->renderPartial('/contactUs/_menu', array(
    'contactUs' => $contactUs,
));

$attributes = array();
$attributes[] = array(
    'name' => 'id',
);
$attributes[] = array(
    'name' => 'name',
);
$attributes[] = array(
    'name' => 'email',
);
$attributes[] = array(
    'name' => 'phone',
);
$attributes[] = array(
    'name' => 'company',
);
$attributes[] = array(
    'name' => 'subject',
);
$attributes[] = array(
    'name' => 'message',
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'ip_address',
);
$attributes[] = array(
    'name' => 'created',
);

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $contactUs,
    'attributes' => $attributes,
));
