<?php
/**
 * @var $this YdSettingController
 * @var $settings YdSetting[]
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = Yii::t('dressing', 'Settings');
$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_MAIN);

/** @var YdActiveForm $form */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'setting-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
));
echo $form->beginModalWrap();
echo $form->errorSummary($settings);

echo '<h2>' . Yii::t('dressing', 'Core Settings') . '</h2>';
echo '<fieldset><legend>' . Yii::t('dressing', 'Version Settings') . '</legend>';
echo $form->textFieldControlGroup($settings['id'], 'value', array('name' => 'YdSetting[id][value]', 'labelOptions' => array('for' => 'YdSetting_id_value')));
echo $form->dropDownListControlGroup($settings['app_version'], 'value', YdSetting::appVersions(), array('name' => 'YdSetting[app_version][value]', 'labelOptions' => array('for' => 'YdSetting_app_version_value')));
//echo $form->dropDownListControlGroup($settings['yii_version'], 'value', YdSetting::yiiVersions(), array('name' => 'YdSetting[yii_version][value]', 'labelOptions' => array('for' => 'YdSetting_yii_version_value')));
//echo $form->checkBoxControlGroup($settings['yii_lite'], 'value', array('name' => 'YdSetting[yii_lite][value]', 'labelOptions' => array('for' => 'YdSetting_yii_lite_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Debug Settings') . '</legend>';
echo $form->checkBoxControlGroup($settings['debug'], 'value', array('name' => 'YdSetting[debug][value]', 'labelOptions' => array('for' => 'YdSetting_debug_value')));
echo $form->textFieldControlGroup($settings['debug_levels'], 'value', array('name' => 'YdSetting[debug_levels][value]', 'labelOptions' => array('for' => 'YdSetting_debug_levels_value')));
echo $form->checkBoxControlGroup($settings['debug_db'], 'value', array('name' => 'YdSetting[debug_db][value]', 'labelOptions' => array('for' => 'YdSetting_debug_db_value')));
echo $form->textFieldControlGroup($settings['error_email'], 'value', array('name' => 'YdSetting[error_email][value]', 'labelOptions' => array('for' => 'YdSetting_error_email_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'PHP Settings') . '</legend>';
echo $form->textFieldControlGroup($settings['memory_limit'], 'value', array('name' => 'YdSetting[memory_limit][value]', 'labelOptions' => array('for' => 'YdSetting_memory_limit_value')));
echo $form->textFieldControlGroup($settings['time_limit'], 'value', array('name' => 'YdSetting[time_limit][value]', 'labelOptions' => array('for' => 'YdSetting_time_limit_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Path Settings') . '</legend>';
echo $form->textFieldControlGroup($settings['script_path'], 'value', array('name' => 'Setting[script_path][value]'));
echo $form->textFieldControlGroup($settings['script_url'], 'value', array('name' => 'Setting[script_url][value]'));
echo $form->textFieldControlGroup($settings['server_name'], 'value', array('name' => 'Setting[server_name][value]'));
echo '</fieldset>';


echo '<h2>' . Yii::t('dressing', 'App Settings') . '</h2>';

echo '<fieldset><legend>' . Yii::t('dressing', 'PHP Settings') . '</legend>';
echo $form->textFieldControlGroup($settings['defaultPageSize'], 'value', array('name' => 'YdSetting[defaultPageSize][value]', 'labelOptions' => array('for' => 'YdSetting_defaultPageSize_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Login Settings') . '</legend>';
echo $form->checkBoxControlGroup($settings['allowAutoLogin'], 'value', array('name' => 'YdSetting[allowAutoLogin][value]', 'labelOptions' => array('for' => 'YdSetting_allowAutoLogin_value')));
echo $form->checkBoxControlGroup($settings['rememberMe'], 'value', array('name' => 'YdSetting[rememberMe][value]', 'labelOptions' => array('for' => 'YdSetting_rememberMe_value')));
echo '</fieldset>';

echo '<fieldset><legend>' . Yii::t('dressing', 'Company Settings') . '</legend>';
//echo $form->textFieldControlGroup($settings['brand'], 'value', array('name' => 'YdSetting[brand][value]', 'labelOptions' => array('for' => 'YdSetting_brand_value')));
echo $form->textFieldControlGroup($settings['name'], 'value', array('name' => 'YdSetting[name][value]', 'labelOptions' => array('for' => 'YdSetting_name_value')));
//echo $form->textAreaControlGroup($settings['address'], 'value', array('name' => 'YdSetting[address][value]', 'labelOptions' => array('for' => 'YdSetting_address_value')));
//echo $form->textFieldControlGroup($settings['phone'], 'value', array('name' => 'YdSetting[phone][value]', 'labelOptions' => array('for' => 'YdSetting_phone_value')));
//echo $form->textFieldControlGroup($settings['website'], 'value', array('name' => 'YdSetting[website][value]', 'labelOptions' => array('for' => 'YdSetting_website_value')));
echo '</fieldset>';

echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('dressing', 'Save Settings'));
$this->endWidget();
