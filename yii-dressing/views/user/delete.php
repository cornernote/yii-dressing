<?php
/**
 * @var $this UserController
 * @var $id int
 * @var $task string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$user = $id ? User::model()->findByPk($id) : new User('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'user-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/user/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($user);
?>

    <fieldset>
        <legend><?php echo Yii::t('dressing', 'Selected Users'); ?></legend>
        <?php
        $users = User::model()->findAll('t.id IN (' . implode(',', YdHelper::getGridIds($id)) . ')');
        if ($users) {
            echo '<ul>';
            foreach ($users as $user) {
                echo '<li>';
                echo $user->getName();
                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </fieldset>

<?php
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