<?php

Yii::import('bootstrap.widgets.TbGridView');
/**
 *
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
    public $templateLong = "{summary}{pager}{gridButtons}{pageSelect}{gridActions}{multiActions}{items}{summary}{pager}{gridButtons}{pageSelect}{gridActions}{multiActions}{clear}";

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

        // add checkbox when we have multiactions
        if ($this->multiActions) {
            $this->columns = CMap::mergeArray(array(array(
                'class' => 'CCheckBoxColumn',
            )), $this->columns);
        }

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
     *
     */
    public function registerClientScript()
    {
        parent::registerClientScript();

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
                            if ($(this).attr('checked'))
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
                            if (!modalRemote.length) modalRemote = $('<div class="modal hide fade" id="modal-remote"></div>');
                            modalRemote.modalResponsiveFix();
                            modalRemote.touchScroll();
                            modalRemote.html('<div class="modal-header"><h3><?php echo Yii::t('dressing', 'Loading...'); ?></h3></div><div class="modal-body"><div class="modal-remote-indicator"></div>').modal();
                        },
                        success: function (response) {
                            modalRemote.html(response);
                            $(window).resize();
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
        $label = Yii::t('dressing', 'per page');
        $options = array(
            10 => '10 ' . $label,
            100 => '100 ' . $label,
            1000 => '1000 ' . $label,
        );
        echo CHtml::dropDownList("userPageSize[{$this->id}]", $this->getUserPageSize(), $options, array(
            'onchange' => "$.fn.yiiGridView.update('{$this->id}',{data:{userPageSize:{" . str_replace('-', '_', $this->id) . ":$(this).val()}}})",
            'class' => 'page-size',
        ));
    }

    /**
     *
     */
    public function renderMultiActions()
    {
        if ($this->dataProvider->getItemCount() > 0 && $this->multiActions) {
            echo '<div class="form-multi-actions">';
            echo CHtml::dropDownList("multiAction[{$this->id}]", '', CHtml::listData($this->multiActions, 'url', 'name'), array(
                'empty' => Yii::t('dressing', 'with selected...'),
                'class' => 'multi-actions',
            ));
            echo '</div>';
        }
    }

    /**
     *
     */
    public function renderGridActions()
    {
        if ($this->gridActions) {
            echo '<div class="form-grid-actions">';
            echo CHtml::dropDownList("gridAction[{$this->id}]", '', CHtml::listData($this->gridActions, 'url', 'name'), array(
                'empty' => Yii::t('dressing', 'with all matching rows...'),
                'class' => 'grid-actions',
            ));
            echo '</div>';
        }
    }

    /**
     *
     */
    public function renderGridButtons()
    {
        if ($this->gridButtons) {
            echo '<div class="form-grid-buttons">';
            foreach ($this->gridButtons as $gridButton) {
                echo '<button class="btn gridButton" value="' . $gridButton['url'] . '">' . $gridButton['name'] . '</button> ';
            }
            echo '</div>';
        }
    }

    /**
     *
     */
    public function renderClear()
    {
        echo '<div class="clear"></div>';
    }

    /**
     * @return bool
     */
    private function getUserPageSize()
    {
        $key = 'userPageSize.' . str_replace('-', '_', $this->id);
        $size = Yii::app()->user->getState($key, Yii::app()->params['defaultPageSize']);
        if (!$size) {
            $size = Yii::app()->params['defaultPageSize'];
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
        else if (is_array($this->pager)) {
            $pager = $this->pager;
            if (isset($pager['class'])) {
                $class = $pager['class'];
                unset($pager['class']);
            }
        }
        $pager['pages'] = $this->dataProvider->getPagination();

        if ($pager['pages']->getPageCount() > 0) {
            echo '<div class="' . $this->pagerCssClass . '">';
            $this->widget($class, $pager);
            echo '</div>';
        }
        else
            $this->widget($class, $pager);
    }

}