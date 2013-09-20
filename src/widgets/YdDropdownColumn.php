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
            'buttons' => $this->getDropdownLinks($data),
        ));
        if ($this->value) {
            parent::renderDataCellContent($row, $data);
        }
    }


    /**
     * Returns an array of links
     *
     * @return array
     */
    public function getDropdownLinks($row, $data)
    {
        $links = array(
            array('label' => $model->getIdString(), 'url' => $this->getUrl()),
        );
        $items = $this->getMenuLinks();
        if ($items) {
            $links[] = array('items' => $items);
        }
        return $links;
    }
	
}
