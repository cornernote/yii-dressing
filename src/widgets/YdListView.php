<?php
Yii::import('zii.widgets.CListView');
/**
 * Class YdListView
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.widgets
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
    public $pager = array('class' => 'dressing.widgets.YdPager');

    /**
     *
     */
    public function init()
    {
        // pager labels
        if (!isset($this->pager['firstPageLabel']))
            $this->pager['firstPageLabel'] = '<i class="icon-fast-backward"></i>';
        if (!isset($this->pager['lastPageLabel']))
            $this->pager['lastPageLabel'] = '<i class="icon-fast-forward"></i>';
        if (!isset($this->pager['nextPageLabel']))
            $this->pager['nextPageLabel'] = '<i class="icon-forward"></i>';
        if (!isset($this->pager['prevPageLabel']))
            $this->pager['prevPageLabel'] = '<i class="icon-backward"></i>';
        if (!isset($this->pager['maxButtonCount']))
            $this->pager['maxButtonCount'] = 5;
        if (!isset($this->pager['displayFirstAndLast']))
            $this->pager['displayFirstAndLast'] = true;

        // userPageSize drop down changed
        $this->setUserPageSize();

        // set pagination
        $this->dataProvider->setPagination($this->getPagination());

        parent::init();
    }

    /**
     * @return CPagination
     */
    public function getPagination()
    {
        $pagination = $this->dataProvider ? $this->dataProvider->getPagination() : new CPagination();
        $pagination->pageSize = $this->getUserPageSize();
        return $pagination;
    }

    /**
     * @return bool
     */
    private function getUserPageSize()
    {
        $key = 'userPageSize.' . str_replace('-', '_', $this->id);
        $size = Yii::app()->user->getState($key, Config::setting('default_page_size'));
        if (!$size) {
            $size = Config::setting('defaultPageSize');
        }
        return $size;
    }

    /**
     *
     */
    private function setUserPageSize()
    {
        if (isset($_GET['userPageSize'])) {
            foreach ($_GET['userPageSize'] as $type => $size) {
                Yii::app()->user->setState('userPageSize.' . $type, (int)$size);
            }
            unset($_GET['userPageSize']);
        }
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