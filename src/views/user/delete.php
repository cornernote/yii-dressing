<?php
/**
 * @var $this UserController
 * @var $id int
 * @var $task string
 */
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));
$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.user', array('/user/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$user = $id ? User::model()->findByPk($id) : new User('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'user-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/user/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($user);
?>

    <fieldset>
        <legend><?php echo t('Selected Users'); ?></legend>
        <?php
        $users = User::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
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
    'label' => t('Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();