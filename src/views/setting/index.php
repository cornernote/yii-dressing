<?php
/**
 * @var $this SettingController
 * @var $settings Setting[]
 */

$this->pageTitle = $this->pageHeading = t('Settings');
$this->menu = Menu::getItemsFromMenu('System');

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'setting-form',
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($settings);

echo '<h2>' . t('Core Settings') . '</h2>';

echo '<fieldset><legend>' . t('Version Settings') . '</legend>';
echo $form->textFieldRow($settings['id'], 'value', array('name' => 'Setting[id][value]'));
echo $form->dropDownListRow($settings['app_version'], 'value', Setting::appVersions(), array('name' => 'Setting[app_version][value]'));
echo $form->dropDownListRow($settings['yii_version'], 'value', Setting::yiiVersions(), array('name' => 'Setting[yii_version][value]'));
echo $form->checkBoxRow($settings['yii_lite'], 'value', array('name' => 'Setting[yii_lite][value]'));
echo '</fieldset>';

echo '<fieldset><legend>' . t('Debug Settings') . '</legend>';
echo $form->checkBoxRow($settings['debug'], 'value', array('name' => 'Setting[debug][value]'));
echo $form->textFieldRow($settings['debug_levels'], 'value', array('name' => 'Setting[debug_levels][value]'));
echo $form->checkBoxRow($settings['debug_db'], 'value', array('name' => 'Setting[debug_db][value]'));
echo $form->textFieldRow($settings['error_email'], 'value', array('name' => 'Setting[error_email][value]'));
echo $form->checkBoxRow($settings['audit'], 'value', array('name' => 'Setting[audit][value]'));
echo '</fieldset>';

echo '<fieldset><legend>' . t('PHP Settings') . '</legend>';
echo $form->textFieldRow($settings['memory_limit'], 'value', array('name' => 'Setting[memory_limit][value]'));
echo $form->textFieldRow($settings['time_limit'], 'value', array('name' => 'Setting[time_limit][value]'));
echo '</fieldset>';

echo '<h2>' . t('App Settings') . '</h2>';

echo '<fieldset><legend>' . t('PHP Settings') . '</legend>';
echo $form->dropDownListRow($settings['theme'], 'value', param('themes'), array('name' => 'Setting[theme][value]'));
echo $form->textFieldRow($settings['defaultPageSize'], 'value', array('name' => 'Setting[defaultPageSize][value]'));
echo '</fieldset>';

echo '<fieldset><legend>' . t('Login Settings') . '</legend>';
echo $form->checkBoxRow($settings['allowAutoLogin'], 'value', array('name' => 'Setting[allowAutoLogin][value]'));
echo $form->checkBoxRow($settings['rememberMe'], 'value', array('name' => 'Setting[rememberMe][value]'));
echo '</fieldset>';

echo '<fieldset><legend>' . t('Company Settings') . '</legend>';
echo $form->textFieldRow($settings['brand'], 'value', array('name' => 'Setting[brand][value]'));
echo $form->textFieldRow($settings['name'], 'value', array('name' => 'Setting[name][value]'));
echo $form->textAreaRow($settings['address'], 'value', array('name' => 'Setting[address][value]'));
echo $form->textFieldRow($settings['phone'], 'value', array('name' => 'Setting[phone][value]'));
echo $form->textFieldRow($settings['website'], 'value', array('name' => 'Setting[website][value]'));
echo $form->textFieldRow($settings['email'], 'value', array('name' => 'Setting[email][value]'));
echo '</fieldset>';

echo '<fieldset><legend>' . t('Recaptcha Settings') . '</legend>';
echo $form->checkBoxRow($settings['recaptcha'], 'value', array('name' => 'Setting[recaptcha][value]'));
echo $form->textFieldRow($settings['recaptchaPrivate'], 'value', array('name' => 'Setting[recaptchaPrivate][value]'));
echo $form->textFieldRow($settings['recaptchaPublic'], 'value', array('name' => 'Setting[recaptchaPublic][value]'));
echo '</fieldset>';

echo '<fieldset><legend>' . t('Date Settings') . '</legend>';
echo $form->textFieldRow($settings['timezone'], 'value', array('name' => 'Setting[timezone][value]'));
echo $form->textFieldRow($settings['dateFormat'], 'value', array('name' => 'Setting[dateFormat][value]'));
echo $form->textFieldRow($settings['dateFormatLong'], 'value', array('name' => 'Setting[dateFormatLong][value]'));
echo $form->textFieldRow($settings['timeFormat'], 'value', array('name' => 'Setting[timeFormat][value]'));
echo $form->textFieldRow($settings['timeFormatLong'], 'value', array('name' => 'Setting[timeFormatLong][value]'));
echo $form->textFieldRow($settings['dateTimeFormat'], 'value', array('name' => 'Setting[dateTimeFormat][value]'));
echo $form->textFieldRow($settings['dateTimeFormatLong'], 'value', array('name' => 'Setting[dateTimeFormatLong][value]'));
echo '</fieldset>';

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => t('Save Settings'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
