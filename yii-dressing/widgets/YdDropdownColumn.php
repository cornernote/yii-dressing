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

        $links = array();
        if ($data instanceof CActiveRecord) {
            $links[] = array(
                'label' => $parentContents,
                'url' => $data->getUrl(),
            );
            $items = method_exists($data, 'getMenuLinks') ? call_user_func(array($data, 'getMenuLinks')) : array();
            if ($items) {
                $links[] = array('items' => $items);
            }
        }
        else {
            $links[] = $parentContents;
        }
        echo '<div class="filter-container">';
        echo TbHtml::buttonGroup($links);
        echo '</div>';
    }

}
