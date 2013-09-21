<?php
/**
 * @var $this AccountController
 * @var $user YdUser
 */

$this->pageTitle = $this->pageHeading = t('My Account');
$this->breadcrumbs = array(
    t('My Account'),
);
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