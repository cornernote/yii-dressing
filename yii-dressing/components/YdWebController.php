<?php
/**
 * Class YdWebController
 *
 * @see YdWebControllerBehavior
 * @property string $name
 * @property array $menu
 * @property array $breadcrumbs
 * @property string $pageHeading
 * @property string $pageSubheading
 * @property string $pageIcon
 * @property bool $showNavBar
 * @property bool $isModal
 * @property int $metaRefresh
 * @method performValidation() bool performValidation(CActiveRecord|CActiveRecord[] $model)
 * @method performAjaxValidation() void performAjaxValidation(CActiveRecord|CActiveRecord[] $model, string $form)
 * @method loadModel() CActiveRecord loadModel(mixed $id, bool|string $model)
 * @method flashRedirect() void flashRedirect(string $message, string $messageType = 'info', mixed $url)
 * @method addBreadcrumb() void addBreadcrumb(string $name, string|array $link = null)
 * @method getName() string getName(bool $plural = false)
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdWebController extends YdController
{

    /**
     *
     */
    public function init()
    {
        $this->layout = Yii::app()->dressing->defaultLayout;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'webController' => array(
                'class' => 'dressing.behaviors.YdWebControllerBehavior',
            ),
        );
    }

}
