<?php
/**
 * @var $this YdSiteMenuController
 * @var $id int
 * @var $task string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Site Menus')] = Yii::app()->user->getState('index.siteMenu', array('/siteMenu/index'));
$this->breadcrumbs[] = Yii::t('dressing', ucfirst($task));

$menu = $id ? YdSiteMenu::model()->findByPk($id) : new YdSiteMenu('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'menu-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/menu/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($menu);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$menus = YdSiteMenu::model()->findAll('t.id IN (' . implode(',', $this->getGridIds($id)) . ')');
if ($menus) {
    echo '<ul>';
    foreach ($menus as $menu) {
        echo '<li>';
        echo $menu->getName();
        echo '</li>';
    }
    echo '</ul>';
}
echo '</fieldset>';

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => Yii::t('dressing', 'Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
