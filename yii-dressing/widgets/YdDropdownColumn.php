<?php

Yii::import('zii.widgets.grid.CDataColumn');

/**
 * YdDropdownColumn
 *
 * Your model must define getUrl(), or behave as YdLinkBehavior:
 * <pre>
 * public function getUrl($action = 'view', $params = array())
 * {
 *     return array_merge(array('/controllerName/' . $action, 'id' => $this->id), (array)$params);
 * }
 * </pre>
 *
 * If you would like a dropdown menu, your model should also define getMenuLinks():
 * <pre>
 * public function getMenuLinks()
 * {
 *     return array(
 *         array('label' => Yii::t('app', 'Update'), 'url' => $this->getUrl('update')),
 *     );
 * }
 * </pre>
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdDropdownColumn extends TbDataColumn
{
    /**
     * @var array
     */
    public $buttonOptions = array();

    /**
     *
     */
    function init()
    {
        $this->type = 'raw';
        $this->htmlOptions['nowrap'] = 'nowrap';
        $this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? $this->htmlOptions['class'] . ' dropdown-column' : 'dropdown-column';
    }

    /**
     * Renders the data cell content.
     *
     * @param integer $row the row number (zero-based)
     * @param YdActiveRecord $data the data associated with the row
     */
    protected function renderDataCellContent($row, $data)
    {
        ob_start();
        parent::renderDataCellContent($row, $data);
        $parentContents = ob_get_clean();

        if ($data instanceof CActiveRecord) {
            $links = is_callable(array($data, 'getMenuLinks')) ? call_user_func(array($data, 'getMenuLinks')) : array();
            if ($links) {
                if (is_callable(array($data, 'getUrl'))) {
                    $this->buttonOptions['type'] = TbHtml::BUTTON_TYPE_LINK;
                    $this->buttonOptions['url'] = call_user_func(array($data, 'getUrl'));
                }
                echo '<div class="filter-container">';
                $this->buttonOptions['split'] = true;
                echo TbHtml::buttonDropdown($parentContents, $links, $this->buttonOptions);
                echo '</div>';
            }
            else {
                $url = is_callable(array($data, 'getUrl')) ? call_user_func(array($data, 'getUrl')) : false;
                if ($url) {
                    $this->buttonOptions['class'] = isset($this->buttonOptions['class']) ? $this->buttonOptions['class'] . ' btn' : 'btn';
                    echo TbHtml::link($parentContents, $url, $this->buttonOptions);
                }
                else {
                    echo TbHtml::button($parentContents, $this->buttonOptions);
                }
            }
        }
        else {
            echo TbHtml::button($parentContents, $this->buttonOptions);
        }
    }

}
