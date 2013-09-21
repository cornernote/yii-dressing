<?php
/**
 * @var $this AccountController
 * @var $user YdUser
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'My Account');

$this->breadcrumbs[] = Yii::t('dressing', 'My Account');

$this->menu = YdMenu::getItemsFromMenu('User');

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $user,
    'attributes' => array(
        'username',
        'name',
        'email',
        'phone',
    ),
));