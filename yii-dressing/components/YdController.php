<?php
/**
 * YdController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdController extends CController
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            'webUserType' => array('dressing.components.YdWebUserTypeFilter'),
        );
    }

}
