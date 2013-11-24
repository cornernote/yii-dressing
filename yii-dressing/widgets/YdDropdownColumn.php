<?php

Yii::import('zii.widgets.grid.CDataColumn');

/**
 * YdDropdownColumn
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
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
     * @param ActiveRecord $data the data associated with the row
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
                'url' => $data->getUrl()
            );
            $items = $data->getMenuLinks();
            if ($items) {
                $links[] = array('items' => $items);
            }
        }
        else {
            $links[] = $parentContents;
        }
        echo '<div class="filter-container">';
        app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
            'buttons' => $links,
        ));
        echo '</div>';
    }

}
