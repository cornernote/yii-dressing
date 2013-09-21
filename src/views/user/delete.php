<?php
/**
 * @var $this UserController
 * @var $id int
 * @var $task string
 */
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Users')] = Yii::app()->user->getState('index.user', array('/user/index'));
$this->breadcrumbs[] = Yii::t('dressing', ucfirst($task));

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
        $users = User::model()->findAll('t.id IN (' . implode(',', $this->getGridIds($id)) . ')');
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