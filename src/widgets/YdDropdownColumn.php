<?php

Yii::import('zii.widgets.grid.CGridColumn');

/**
 * ItemPriceFieldColumn
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdDropdownColumn extends CDataColumn
{

    /**
     *
     */
    function init()
    {
        $this->type = 'raw';
        $this->htmlOptions['nowrap'] = 'nowrap';
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
        app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
            'buttons' => $links,
        ));
    }

}
