<?php
/**
 * @var $this WebController
 */
$this->pageTitle = $this->pageHeading = t('Help');

// menu
$this->menu = Menu::getItemsFromMenu('Help');

// breadcrumbs
$this->breadcrumbs = array(
    t('Help'),
);
