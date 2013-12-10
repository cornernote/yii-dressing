<?php
/**
 * @var $this YdWebController
 * @var $content
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
?>
<?php
if ($this->showNavBar) {
    $this->widget('bootstrap.widgets.TbNavbar', array(
        'fixed' => 'top',
        'fluid' => true,
        'collapse' => true,
        'items' => YdSiteMenu::topMenu(),
    ));
}
?>
<div class="holder">
    <div id="body">
        <header class="container-fluid">
            <?php
            if ($this->pageHeading) {
                echo '<h1 class="header">';
                if ($this->pageIcon)
                    echo '<i class="' . $this->pageIcon . '"></i> ';
                echo $this->pageHeading;
                if ($this->pageSubheading)
                    echo '<small>' . $this->pageSubheading . '</small>';
                echo '</h1>';
            }
            if ($this->menu) {
                $this->widget('bootstrap.widgets.TbMenu', array(
                    'id' => 'menu',
                    'type' => 'tabs',
                    'items' => $this->menu,
                ));
            }
            if ($this->breadcrumbs) {
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                    'links' => CMap::mergeArray($this->breadcrumbs, array($this->pageHeading)),
                    'separator' => '<i class="icon-chevron-right"></i>',
                ));
            }
            ?>
        </header>
        <div id="content" class="container-fluid">
            <?php
            echo user()->multiFlash();
            echo $content;
            ?>
        </div>
    </div>
    <footer class="container-fluid">
        <?php
        $this->renderPartial('dressing.views.audit._footer');
        echo '<p class="pull-right">' . l(t('Back to Top') . ' &uarr;', '#') . '</p>';
        ?>
    </footer>
</div>