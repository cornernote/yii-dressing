<?php

Yii::import('zii.widgets.grid.CGridColumn');

/**
 * ItemPriceFieldColumn
 */
class YdDropdownColumn extends CDataColumn
{

    /**
     * @var string
     */
    public $type = 'raw';

    /**
     *
     */
    function init()
    {
        $this->htmlOptions['nowrap'] = 'nowrap';
    }

    /**
     * Renders the data cell content.
     * @param integer $row the row number (zero-based)
     * @param ActiveRecord $data the data associated with the row
     */
    protected function renderDataCellContent($row, $data)
    {
        app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
            'buttons' => $data->getDropdownLinks(),
        ));
        if ($this->value) {
            parent::renderDataCellContent($row, $data);
        }
    }

}
