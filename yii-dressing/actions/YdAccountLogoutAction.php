<?php

/**
 * YdAccountLogoutAction
 *
 * @property YdWebController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 *
 * @package dressing.actions
 */
class YdAccountLogoutAction extends CAction
{

    /**
     *
     */
    public function run()
    {
        $user = Yii::app()->getUser();
        $user->logout();
        $this->controller->redirect($user->loginUrl);
    }

}
