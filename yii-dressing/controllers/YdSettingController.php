<?php

/**
 * YdSettingController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.controllers
 */
class YdSettingController extends YdWebController
{

    /**
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Update settings
     */
    public function actionIndex()
    {
        // load settings
        /** @var Setting[] $settings */
        $settings = array();
        $_settings = YdSetting::model()->findAll();
        foreach ($_settings as $setting) {
            $settings[$setting->key] = $setting;
        }
//        // load from items
        foreach (self::$_settings() as $key => $value) {
            if (!isset($settings[$key])) {
                $settings[$key] = new YdSetting();
                $settings[$key]->key = $key;
                $settings[$key]->value = $value;
                $settings[$key]->save(false);
            }
        }
        // load from params
        foreach (Yii::app()->params as $key => $value) {
            if (is_scalar($value) && !isset($settings[$key])) {
                $settings[$key] = new YdSetting();
                $settings[$key]->key = $key;
                $settings[$key]->value = $value;
                $settings[$key]->save(false);
            }
        }

        // handle posted data
        if (isset($_POST['YdSetting'])) {

            // begin transaction
            $error = false;
            $transaction = YdSetting::model()->getDbConnection()->beginTransaction();

            // save settings
            foreach ($_POST['YdSetting'] as $key => $value) {
                $value = isset($value['value']) ? $value['value'] : 0;
                $settings[$key]->value = $value;
                if (!$settings[$key]->save()) {
                    $error = true;
                    break;
                }
            }
            if (!$error) {
                // commit transaction
                $transaction->commit();

                // clear cache
                Yii::app()->cache->flush();

                // flash and redirect
                Yii::app()->user->addFlash(Yii::t('dressing', 'Settings have been saved.'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl(array('/setting/index')));
            }

            // rollback transaction and flash error
            $transaction->rollback();
            Yii::app()->user->addFlash(Yii::t('dressing', 'Settings could not be saved.'), 'error');

        }
        // no data posted
        else {
            $settings['script_path']->value = $settings['script_path']->value ? $settings['script_path']->value : dirname($_SERVER['SCRIPT_FILENAME']);
            $settings['script_url']->value = $settings['script_url']->value ? $settings['script_url']->value : dirname($_SERVER['SCRIPT_NAME']);
            $settings['server_name']->value = $settings['server_name']->value ? $settings['server_name']->value : $_SERVER['SERVER_NAME'];
        }

        $this->render('index', array(
            'settings' => $settings,
        ));
    }

}
