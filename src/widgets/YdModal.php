<?php

class YdModal extends CWidget
{
    // function to init the widget
    public function init()
    {
        $this->publishAssets();
    }

    // function to publish and register assets on page
    public function publishAssets()
    {
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.modal-responsive-fix'), false, 1, YII_DEBUG);

        $cs = Yii::app()->clientScript;

        $this->registerScript();

        // fix modals on mobile devices
        // http://niftylettuce.github.com/twitter-bootstrap-jquery-plugins/
        $cs->registerScriptFile($baseUrl . '/touchscroll.js', CClientScript::POS_HEAD, array('order' => 1));
        $cs->registerScriptFile($baseUrl . '/modal-responsive-fix.min.js', CClientScript::POS_HEAD, array('order' => 1));
        $cs->registerCSS('modal-responsive-fix', '.modal-body { -webkit-overflow-scrolling:touch; } body.modal-open{overflow: hidden;} @media (max-width: 767px) {.modal.fade.in {top: 10px !important;}}', '', array('order' => 10));

    }

    protected function registerScript()
    {
        $this->beginWidget('dressing.widgets.YdJavaScriptWidget', array('position' => CClientScript::POS_END));
        ?>
        <script type="text/javascript">
            $('.modal').modalResponsiveFix();
            $('.modal').touchScroll();
        </script><?php
        $this->endWidget();

        // Support for AJAX loaded modal window.
        $this->beginWidget('dressing.widgets.YdJavaScriptWidget', array('position' => CClientScript::POS_END));
        ?>
        <script type="text/javascript">
            $('[data-toggle="modal-remote"]').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var modalRemote = $('#modal-remote');

                $.ajax({
                    url: url,
                    beforeSend: function (data) {
                        if (!modalRemote.length) modalRemote = $('<div class="modal hide fade" id="modal-remote"></div>');
                        modalRemote.html('<div class="modal-header"><h3><?php echo Yii::t('dressing', 'Loading...'); ?></h3></div><div class="modal-body"><div class="modal-remote-indicator"></div>');
                        modalRemote.modalResponsiveFix();
                        modalRemote.touchScroll();
                        modalRemote.modal();
                    },
                    success: function (data) {
                        modalRemote.html(data);
                        $(window).resize();
                        //modalRemote.children('input:text:visible:first').focus();
                        $('#modal-remote input:text:visible:first').focus();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        modalRemote.children('.modal-header').html('<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button><h3><?php echo Yii::t('dressing', 'Error!'); ?></h3>');
                        modalRemote.children('.modal-body').html(XMLHttpRequest.responseText);
                    }
                });
            });
        </script><?php
        $this->endWidget();
    }
}