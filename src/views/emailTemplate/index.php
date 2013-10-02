<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
Yii::app()->user->setState('index.emailTemplate', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Email Templates');

$this->renderPartial('dressing.views.emailTemplate._menu');

echo '<div class="spacer">';
if (Yii::app()->user->getState('index.emailTemplate') != Yii::app()->createUrl('/emailTemplate/index')) {
    //echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/emailTemplate/index'),
    ));
}
echo '</div>';

// grid
$this->renderPartial('dressing.views.emailTemplate._grid', array('emailTemplate' => $emailTemplate));
