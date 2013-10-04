<?php
/**
 * @var $this SettingController
 * @var $settings YdSetting[]
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Settings');
$this->menu = YdMenu::getItemsFromMenu('Settings', YdMenu::MENU_ADMIN);

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Settings');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'setting-form',
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($settings);

echo '<h2>' . Yii::t('dressing', 'Core Settings') . '</h2>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Version Settings') . '</legend>';
echo $form->textFieldRow($settings['id'], 'value', array('name' => 'YdSetting[id][value]', 'labelOptions' => array('for' => 'YdSetting_id_value')));
echo $form->dropDownListRow($settings['app_version'], 'value', YdSetting::appVersions(), array('name' => 'YdSetting[app_version][value]', 'labelOptions' => array('for' => 'YdSetting_app_version_value')));
//echo $form->dropDownListRow($settings['yii_version'], 'value', YdSetting::yiiVersions(), array('name' => 'YdSetting[yii_version][value]', 'labelOptions' => array('for' => 'YdSetting_yii_version_value')));
//echo $form->checkBoxRow($settings['yii_lite'], 'value', array('name' => 'YdSetting[yii_lite][value]', 'labelOptions' => array('for' => 'YdSetting_yii_lite_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Debug Settings') . '</legend>';
echo $form->checkBoxRow($settings['debug'], 'value', array('name' => 'YdSetting[debug][value]', 'labelOptions' => array('for' => 'YdSetting_debug_value')));
echo $form->textFieldRow($settings['debug_levels'], 'value', array('name' => 'YdSetting[debug_levels][value]', 'labelOptions' => array('for' => 'YdSetting_debug_levels_value')));
echo $form->checkBoxRow($settings['debug_db'], 'value', array('name' => 'YdSetting[debug_db][value]', 'labelOptions' => array('for' => 'YdSetting_debug_db_value')));
echo $form->textFieldRow($settings['error_email'], 'value', array('name' => 'YdSetting[error_email][value]', 'labelOptions' => array('for' => 'YdSetting_error_email_value')));
echo $form->checkBoxRow($settings['audit'], 'value', array('name' => 'YdSetting[audit][value]', 'labelOptions' => array('for' => 'YdSetting_audit_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'PHP Settings') . '</legend>';
echo $form->textFieldRow($settings['memory_limit'], 'value', array('name' => 'YdSetting[memory_limit][value]', 'labelOptions' => array('for' => 'YdSetting_memory_limit_value')));
echo $form->textFieldRow($settings['time_limit'], 'value', array('name' => 'YdSetting[time_limit][value]', 'labelOptions' => array('for' => 'YdSetting_time_limit_value')));
echo '</fieldset>';

echo '<h2>' . Yii::t('dressing', 'App Settings') . '</h2>';

echo '<fieldset><legend>' . Yii::t('dressing', 'PHP Settings') . '</legend>';
echo $form->dropDownListRow($settings['theme'], 'value', YdSetting::themes(), array('name' => 'YdSetting[theme][value]', 'empty' => '', 'labelOptions' => array('for' => 'YdSetting_theme_value')));
echo $form->textFieldRow($settings['defaultPageSize'], 'value', array('name' => 'YdSetting[defaultPageSize][value]', 'labelOptions' => array('for' => 'YdSetting_defaultPageSize_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Login Settings') . '</legend>';
echo $form->checkBoxRow($settings['allowAutoLogin'], 'value', array('name' => 'YdSetting[allowAutoLogin][value]', 'labelOptions' => array('for' => 'YdSetting_allowAutoLogin_value')));
echo $form->checkBoxRow($settings['rememberMe'], 'value', array('name' => 'YdSetting[rememberMe][value]', 'labelOptions' => array('for' => 'YdSetting_rememberMe_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Company Settings') . '</legend>';
//echo $form->textFieldRow($settings['brand'], 'value', array('name' => 'YdSetting[brand][value]', 'labelOptions' => array('for' => 'YdSetting_brand_value')));
echo $form->textFieldRow($settings['name'], 'value', array('name' => 'YdSetting[name][value]', 'labelOptions' => array('for' => 'YdSetting_name_value')));
//echo $form->textAreaRow($settings['address'], 'value', array('name' => 'YdSetting[address][value]', 'labelOptions' => array('for' => 'YdSetting_address_value')));
//echo $form->textFieldRow($settings['phone'], 'value', array('name' => 'YdSetting[phone][value]', 'labelOptions' => array('for' => 'YdSetting_phone_value')));
//echo $form->textFieldRow($settings['website'], 'value', array('name' => 'YdSetting[website][value]', 'labelOptions' => array('for' => 'YdSetting_website_value')));
echo $form->textFieldRow($settings['email'], 'value', array('name' => 'YdSetting[email][value]', 'labelOptions' => array('for' => 'YdSetting_email_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Recaptcha Settings') . '</legend>';
echo $form->checkBoxRow($settings['recaptcha'], 'value', array('name' => 'YdSetting[recaptcha][value]', 'labelOptions' => array('for' => 'YdSetting_recaptcha_value')));
echo $form->textFieldRow($settings['recaptchaPrivate'], 'value', array('name' => 'YdSetting[recaptchaPrivate][value]', 'labelOptions' => array('for' => 'YdSetting_recaptchaPrivate_value')));
echo $form->textFieldRow($settings['recaptchaPublic'], 'value', array('name' => 'YdSetting[recaptchaPublic][value]', 'labelOptions' => array('for' => 'YdSetting_recaptchaPublic_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Date Settings') . '</legend>';
echo $form->textFieldRow($settings['timezone'], 'value', array('name' => 'YdSetting[timezone][value]', 'labelOptions' => array('for' => 'YdSetting_timezone_value')));
echo $form->textFieldRow($settings['dateFormat'], 'value', array('name' => 'YdSetting[dateFormat][value]', 'labelOptions' => array('for' => 'YdSetting_dateFormat_value')));
echo $form->textFieldRow($settings['dateFormatLong'], 'value', array('name' => 'YdSetting[dateFormatLong][value]', 'labelOptions' => array('for' => 'YdSetting_dateFormatLong_value')));
echo $form->textFieldRow($settings['timeFormat'], 'value', array('name' => 'YdSetting[timeFormat][value]', 'labelOptions' => array('for' => 'YdSetting_timeFormat_value')));
echo $form->textFieldRow($settings['timeFormatLong'], 'value', array('name' => 'YdSetting[timeFormatLong][value]', 'labelOptions' => array('for' => 'YdSetting_timeFormatLong_value')));
echo $form->textFieldRow($settings['dateTimeFormat'], 'value', array('name' => 'YdSetting[dateTimeFormat][value]', 'labelOptions' => array('for' => 'YdSetting_dateTimeFormat_value')));
echo $form->textFieldRow($settings['dateTimeFormatLong'], 'value', array('name' => 'YdSetting[dateTimeFormatLong][value]', 'labelOptions' => array('for' => 'YdSetting_dateTimeFormatLong_value')));
echo '</fieldset>';

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => Yii::t('dressing', 'Save Settings'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
