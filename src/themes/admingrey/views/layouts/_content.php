<?php
/**
 * @var $this WebController
 * @var $content
 */

$this->widget('widgets.Navbar', array(
    'id' => 'navbar',
    'fixed' => 'top',
    'fluid' => true,
    'collapse' => true,
    'items' => Menu::topMenu(),
    'constantItems' => array(
        Menu::userMenu(),
    ),
));

echo '<div class="holder">';

echo '<div class="container-fluid">';

if ($this->pageHeading) {
    echo '<h1 class="header">' . $this->pageHeading . '</h1>';
}
if (!app()->request->isAjaxRequest) {
    echo '<div id="content">';
}

if ($this->menu) {
    $this->widget('bootstrap.widgets.TbMenu', array(
        'id' => 'menu',
        'type' => 'tabs',
        'items' => $this->menu,
    ));
}
if (!app()->request->isAjaxRequest) {
    echo '<div id="inner">';
}
if ($this->breadcrumbs) {
    $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'htmlOptions' => array(
            'id' => 'breadcrumbs',
        ),
        'separator' => '',
        'links' => $this->breadcrumbs,
    ));
}

echo user()->multiFlash();
echo $content;
if (!app()->request->isAjaxRequest) {
    echo '</div>';
    echo '</div>';
}
echo '</div>';

echo '<footer class="footer">';
echo '<div class="container-fluid">';
$this->renderPartial('/audit/_footer');
echo '<p class="pull-right">' . l(t('Back to Top') . ' &uarr;', '#') . '</p>';
echo '</div>';
echo '</footer>';

echo '</div>';