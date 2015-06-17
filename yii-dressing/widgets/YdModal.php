<?php

/**
 * YdModal
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdModal extends CWidget
{
    /**
     *
     */
    public function init()
    {
        // fix modals on mobile devices
        //$baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.bootstrap-modal'), false, 1, YII_DEBUG);
//        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('vendor.jschr.bootstrap-modal'), false, 1, YII_DEBUG);
//        $cs = Yii::app()->clientScript;
//        $cs->registerCssFile($baseUrl . '/css/bootstrap-modal.css');
//        $cs->registerScriptFile($baseUrl . '/js/bootstrap-modalmanager.js', CClientScript::POS_END);
//        $cs->registerScriptFile($baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END);

        // load yiiactiveform so it's not needed to load in remote modal
        Yii::app()->getClientScript()->registerCoreScript('yiiactiveform');

        // Support for AJAX loaded modal window.
        $this->beginWidget('dressing.widgets.YdJavaScriptWidget', array('position' => CClientScript::POS_END));
        ?>
        <script type="text/javascript">
            $(document).on('click', '[data-toggle="modal-remote"]', function (e) {
                e.preventDefault();
                var $modalRemote = $('#modal-remote'),
                    url = $(this).attr('href');

                $.ajax({
                    url: url,
                    beforeSend: function (data) {
                        if (!$modalRemote.length) $modalRemote = $('<div class="modal fade" id="modal-remote" data-backdrop="static"><div class="modal-dialog modal-lg"><div class="modal-content"></div></div></div>');
                        $modalRemote.find('.modal-content').html('<div class="modal-header"><h3><?php echo Yii::t('dressing', 'Loading...'); ?></h3></div><div class="modal-body"><div class="modal-remote-indicator"></div>');
                        $modalRemote.modal();
                    },
                    success: function (data) {
                        $modalRemote.find('.modal-content').html(data);
                        $(window).resize();
                        $modalRemote.find('input:text:visible:first').focus();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $modalRemote.children('.modal-header').html('<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button><h3><?php echo Yii::t('dressing', 'Error!'); ?></h3>');
                        $modalRemote.children('.modal-body').html(XMLHttpRequest.responseText);
                    }
                });
            });
        </script><?php
        $this->endWidget();
    }
}