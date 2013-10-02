<?php
Yii::import('zii.widgets.CListView');
/**
 * Class YdListView
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdListView extends CListView
{
    /**
     * @var string
     */
    public $template = "{items}\n{summary}\n{pager}{pageSelect}";

    /**
     * @var array
     */
    public $pager = array(
        'header' => '',
        'maxButtonCount' => 5,
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
    );

    /**
     *
     */
    public function registerClientScript()
    {
        parent::registerClientScript();
    }

    /**
     *
     */
    public function renderPageSelect()
    {
        // TODO page selection is not currently working in ListView
        // returns a jquery error of undefined variable "url"
        return;
        //$options = array('' => 'limit', 5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100, 200 => 200);
        //echo CHtml::dropDownList("pageSize[{$this->id}]", '', $options, array(
        //    'onchange' => "$.fn.yiiListView.update('{$this->id}',{data:{pageSize:{" . str_replace('-', '_', $this->id) . ":$(this).val()}}})",
        //    'class' => 'pageSize',
        //));
    }

}