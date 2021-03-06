<?php

Yii::import('bootstrap.widgets.TbGridView');

/**
 * YdGridView
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdGridView extends TbGridView
{

    /**
     * @var string
     */
    public $template = "{summary}{pager}{gridButtons}{pageSelect}{gridActions}{multiActions}{items}";

    /**
     * @var string
     */
    public $templateLong = "{summary}{pager}{gridButtons}{pageSelect}{gridActions}{multiActions}{items}{summary}{pager}{gridButtons}{pageSelect}{gridActions}{multiActions}";

    /**
     * @var string
     */
    public $type = 'striped condensed bordered';

    /**
     * @var array
     */
    public $multiActions = array();

    /**
     * @var array
     */
    public $gridActions = array();

    /**
     * @var array
     */
    public $gridButtons = array();

    /**
     * @var int
     */
    public $selectableRows = 1000;

    /**
     * @var int
     */
    public $defaultPageSize = 10;

    /**
     * @var array
     */
    public $pageSizeOptions = array(10, 100, 1000);

    /**
     * @var bool
     */
    public $saveUserPageSize = true;

    /**
     * @var array
     */
    public $pager = array('class' => 'dressing.widgets.YdPager');

    /**
     * @var string
     */
    public $header;

    /**
     * @var string
     */
    public $footer;

    /**
     * @var string
     */
    public $cssFile;

    /**
     *
     */
    public function init()
    {
        // pager labels
        if (!isset($this->pager['firstPageLabel']))
            $this->pager['firstPageLabel'] = '<i class="fa fa-fast-backward"></i>';
        if (!isset($this->pager['lastPageLabel']))
            $this->pager['lastPageLabel'] = '<i class="fa fa-fast-forward"></i>';
        if (!isset($this->pager['nextPageLabel']))
            $this->pager['nextPageLabel'] = '<i class="fa fa-forward"></i>';
        if (!isset($this->pager['prevPageLabel']))
            $this->pager['prevPageLabel'] = '<i class="fa fa-backward"></i>';
        if (!isset($this->pager['maxButtonCount']))
            $this->pager['maxButtonCount'] = 5;
        if (!isset($this->pager['hideFirstAndLast']))
            $this->pager['hideFirstAndLast'] = false;

        // userPageSize drop down changed
        $this->setUserPageSize();

        // set pagination
        $this->dataProvider->pagination->pageSize = $this->getUserPageSize();

        // add checkbox when we have multiactions
        if ($this->multiActions) {
            $this->columns = CMap::mergeArray(array(array(
                'class' => 'CCheckBoxColumn',
            )), $this->columns);
        }

        $cssFile = $this->cssFile;
        $this->cssFile = false;
        parent::init();
        $this->cssFile = $cssFile;
    }

    /**
     *
     */
    public function registerClientScript()
    {
        parent::registerClientScript();
        if ($this->cssFile !== false) {
            if (!$this->cssFile) {
                $this->cssFile = Yii::app()->dressing->getAssetsUrl() . '/css/gridview.css';
            }
            Yii::app()->clientScript->registerCssFile($this->cssFile);
        }

        if ($this->multiActions || $this->gridActions || $this->gridButtons) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->dressing->getAssetsUrl() . '/js/jquery.form.js');
            // put the url from the button into the form action
            // handle submit form to capture the response into a modal
            Yii::app()->controller->beginWidget('dressing.widgets.YdJavaScriptWidget', array('position' => CClientScript::POS_END));
            ?>
            <script type="text/javascript">
                var modalRemote = $('#modal-remote');

                // handle multiActions
                $('#<?php echo $this->id; ?>-form').on('change', '.multi-actions', function () {
                    var checked = false;
                    var action = $('#<?php echo $this->id; ?>-form').attr('action');
                    var url = $(this).val();
                    $(this).val('');
                    if (url) {
                        $('.select-on-check').each(function () {
                            if ($(this).is(':checked'))
                                checked = true;
                        });
                        if (checked) {
                            setupGridViewAjaxForm();
                            $('#<?php echo $this->id; ?>-form').attr('action', url).submit();
                        }
                        else {
                            alert('<?php echo Yii::t('dressing', 'No rows selected.'); ?>');
                        }
                    }
                });

                // handle gridActions
                $('#<?php echo $this->id; ?>-form').on('change', '.grid-actions', function () {
                    var action = $('#<?php echo $this->id; ?>-form').attr('action');
                    var url = $(this).val();
                    $(this).val('');
                    if (url) {
                        setupGridViewAjaxForm();
                        $('#<?php echo $this->id; ?>-form').attr('action', url).submit();
                    }
                });

                // handle gridButtons
                $('#<?php echo $this->id; ?>-form').on('click', '.gridButton', function () {
                    var action = $('#<?php echo $this->id; ?>-form').attr('action');
                    var url = $(this).val();
                    $(this).val('');
                    if (url) {
                        $('#<?php echo $this->id; ?>-form').attr('action', url).submit();
                    }
                });

                // handle form submission
                function setupGridViewAjaxForm() {
                    $('#<?php echo $this->id; ?>-form').ajaxForm({
                        beforeSubmit: function (response) {
                            if (!modalRemote.length) modalRemote = $('<div class="modal fade" id="modal-remote" data-backdrop="static"><div class="modal-dialog modal-lg"><div class="modal-content"></div></div></div>');
                            modalRemote.find('.modal-content').html('<div class="modal-header"><h3><?php echo Yii::t('dressing', 'Loading...'); ?></h3></div><div class="modal-body"><div class="modal-remote-indicator"></div>');
                            modalRemote.modal();
                        },
                        success: function (response) {
                            modalRemote.find('.modal-content').html(response);
                            $('#modal-remote input:text:visible:first').focus();
                        },
                        error: function (response) {
                            modalRemote.children('.modal-header').html('<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button><h3><?php echo Yii::t('dressing', 'Error!'); ?></h3>');
                            modalRemote.children('.modal-body').html(response);
                        }
                    });
                }
            </script>
            <?php
            Yii::app()->controller->endWidget();
        }
    }

    /**
     *
     */
    public function run()
    {
        $this->renderHeader();

        if ($this->multiActions || $this->gridActions || $this->gridButtons) {
            echo CHtml::openTag('div', array(
                    'id' => $this->id . '-multi-checkbox',
                    'class' => 'multi-checkbox-table',
                )) . "\n";
            echo CHtml::beginForm('', 'POST', array(
                'id' => $this->id . '-form',
            ));
            echo CHtml::hiddenField('returnUrl', Yii::app()->returnUrl->getFormValue(true));
        }

        parent::run();

        if ($this->multiActions || $this->gridActions || $this->gridButtons) {
            echo CHtml::endForm();
            echo CHtml::closeTag('div');
        }

        $this->renderFooter();
    }

    /**
     *
     */
    public function renderToggleFilters()
    {
        $js = "jQuery(document).on('click','.toggle-filters',function(){ jQuery(this).closest('.grid-view').find('.filters').toggle(); });";
        Yii::app()->clientScript->registerScript(__CLASS__ . '_toggle-filters', $js);
        echo '<i class="icon-search toggle-filters" title="' . Yii::t('dressing', 'Show Filters') . '"></i>';
    }

    /**
     *
     */
    public function renderPageSelect()
    {
        if (!$this->dataProvider->getItemCount())
            return;

        $label = Yii::t('dressing', 'per page');
        $options = array();
        foreach ($this->pageSizeOptions as $option) {
            $options[$option] = $option . ' ' . $label;
        }
        echo CHtml::dropDownList("userPageSize[{$this->id}]", $this->dataProvider->pagination->pageSize, $options, array(
            'onchange' => "$.fn.yiiGridView.update('{$this->id}',{data:{userPageSize:{" . str_replace('-', '_', $this->id) . ":$(this).val()}}})",
            'class' => 'page-size form-control',
        ));
    }

    /**
     *
     */
    public function renderMultiActions()
    {
        if (!$this->dataProvider->getItemCount())
            return;
        if (!$this->multiActions)
            return;

        echo '<div class="form-multi-actions">';
        echo CHtml::dropDownList("multiAction[{$this->id}]", '', CHtml::listData($this->multiActions, 'url', 'name'), array(
            'empty' => Yii::t('dressing', 'with selected...'),
            'class' => 'multi-actions form-control',
        ));
        echo '</div>';
    }

    /**
     *
     */
    public function renderGridActions()
    {
        if (!$this->dataProvider->getItemCount())
            return;
        if (!$this->gridActions)
            return;

        echo '<div class="form-grid-actions">';
        echo CHtml::dropDownList("gridAction[{$this->id}]", '', CHtml::listData($this->gridActions, 'url', 'name'), array(
            'empty' => Yii::t('dressing', 'with all matching rows...'),
            'class' => 'grid-actions form-control',
        ));
        echo '</div>';
    }

    /**
     *
     */
    public function renderGridButtons()
    {
        if (!$this->gridButtons)
            return;
        echo '<div class="form-grid-buttons">';
        foreach ($this->gridButtons as $gridButton) {
            $class = isset($gridButton['class']) ? $gridButton['class'] . ' ' : '';
            $class .= 'btn gridButton';
            echo '<button class="' . $class . '" value="' . $gridButton['url'] . '">' . $gridButton['name'] . '</button> ';
        }
        echo '</div>';
    }

    /**
     * @return bool
     */
    public function getUserPageSize()
    {
        $key = 'YdGridView_userPageSize_' . str_replace('-', '_', $this->id);
        $user = Yii::app()->getUser();
        $size = 0;
        if (!$size && $this->saveUserPageSize && isset($user->user) && $user->user->asa('EavBehavior'))
            $size = $user->user->getEavAttribute($key);
        if (!$size && $this->saveUserPageSize)
            $size = Yii::app()->user->getState($key, $this->defaultPageSize);
        if (!$size && isset($_GET['userPageSize'][str_replace('-', '_', $this->id)]))
            $size = $_GET['userPageSize'][str_replace('-', '_', $this->id)];
        if (!$size)
            $size = $this->defaultPageSize;
        return $size;
    }

    /**
     *
     */
    private function setUserPageSize()
    {
        if (!$this->saveUserPageSize || !isset($_GET['userPageSize']))
            return;

        $user = Yii::app()->getUser();
        if (!isset($user->user))
            return;

        foreach ($_GET['userPageSize'] as $type => $size) {
            $key = 'YdGridView_userPageSize_' . $type;
            $user->setState($key, (int)$size);
            if ($user->user && $user->user->asa('EavBehavior'))
                $user->user->setEavAttribute($key, (int)$size, true);
        }
        //unset($_GET['userPageSize']);
    }


    /**
     * Renders the pager.
     */
    public function renderPager()
    {
        if (!$this->enablePagination)
            return;

        $pager = array();
        $class = 'CLinkPager';
        if (is_string($this->pager))
            $class = $this->pager;
        elseif (is_array($this->pager)) {
            $pager = $this->pager;
            if (isset($pager['class'])) {
                $class = $pager['class'];
                unset($pager['class']);
            }
        }
        $pager['pages'] = $this->dataProvider->getPagination();
        TbHtml::addCssClass('pager pagination', $pager['htmlOptions']);
        $this->widget($class, $pager);
    }

    /**
     *
     */
    public function renderHeader()
    {
        echo $this->header;
    }

    /**
     *
     */
    public function renderFooter()
    {
        echo $this->footer;
    }


}
