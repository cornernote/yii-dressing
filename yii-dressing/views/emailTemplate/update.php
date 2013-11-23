<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
$this->pageTitle = $this->pageHeading = $emailTemplate->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Update');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Email Templates')] = Yii::app()->user->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[$emailTemplate->getName()] = $emailTemplate->getLink();
$this->breadcrumbs[] = Yii::t('dressing', 'Update');

$this->renderPartial('dressing.views.emailTemplate._menu', array(
    'emailTemplate' => $emailTemplate,
));
$this->renderPartial('dressing.views.emailTemplate._form', array(
    'emailTemplate' => $emailTemplate,
));
