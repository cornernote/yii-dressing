<?php
/**
 * @var $this WebController
 */

// fix bootsrtap padding on top with responsive views
if (!isset($this->showNavBar) || !$this->showNavBar) {
    cs()->registerCSS('reset', 'body{padding-top:20px;}', '', array('order' => -6));
}
cs()->registerCSSFile(au() . '/css/style.css', '', array('order' => -6));

// font awesome
$this->widget('widgets.FontAwesome');

// load here so modals don't have to load it
cs()->registerCoreScript('yiiactiveform');

// modal for popups
$this->widget('widgets.Modal');

// dropdown JS doesn't work on iPad
// https://github.com/twitter/bootstrap/issues/2975#issuecomment-6659992
cs()->registerScript('bootstrap-dropdown-fix', "$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });", CClientScript::POS_END);

// qtip for tooltips
$this->widget('widgets.QTip');

// google analytics
//$this->renderPartial('/layouts/_google_analytics');

// theme scripts
$this->renderPartial('/layouts/_theme_scripts');