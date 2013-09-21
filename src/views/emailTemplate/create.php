<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Email Templates')] = Yii::app()->user->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.emailTemplate._menu', array(
    'emailTemplate' => $emailTemplate,
));
$this->renderPartial('dressing.views.emailTemplate._form', array(
    'emailTemplate' => $emailTemplate,
));
