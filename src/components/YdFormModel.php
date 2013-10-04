<?php
/**
 * Class YdFormModel
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdFormModel extends CFormModel
{

    /**
     * @return string
     */
    public function getErrorString()
    {
        $output = '';
        foreach ($this->getErrors() as $attribute => $errors) {
            $output .= $attribute . ': ' . implode(' ', $errors) . ' | ';
        }
        return $output;
    }


}
