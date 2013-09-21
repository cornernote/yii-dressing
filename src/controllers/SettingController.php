<?php

/**
 * SettingController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class SettingController extends YdWebController
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
        // load from items
        foreach (YdSetting::items() as $key => $value) {
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
            $transaction = YdSetting::model()->beginTransaction();

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
                Yii::app()->cache()->flush();

                // flash and redirect
                Yii::app()->user->addFlash(Yii::t('dressing', 'Settings have been saved.'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl(array('/setting/index')));
            }

            // rollback transaction and flash error
            $transaction->rollback();
            Yii::app()->user->addFlash(Yii::t('dressing', 'Settings could not be saved.'), 'error');

        }

        $this->render('dressing.views.setting.index', array(
            'settings' => $settings,
        ));
    }

}
