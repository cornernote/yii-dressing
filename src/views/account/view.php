<?php
/* @var $this AccountController */
?>
<?php
$this->pageTitle = $this->pageHeading = t('My Account');
$this->breadcrumbs = array(
    t('My Account'),
);
$this->menu = Menu::getItemsFromMenu('User');
?>

<fieldset>
    <legend><?php echo t('User Details') ?></legend>
    <?php $this->widget('widgets.DetailView', array(
        'data' => $user,
        'attributes' => array(
            'username',
            'name',
            'email',
            'phone',
        ),
    )); ?>
</fieldset>
