<?php

/**
 * YdQTip
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdQTip extends CWidget
{

    /**
     * @var string
     */
    public $selector = 'a[title]:not(.fancybox-item,.fancybox-nav),i[title],.icon[title]';

    /**
     *
     */
    public function init()
    {
        $this->publishAssets();
    }

    /**
     * function to publish and register assets on page
     */
    public function publishAssets()
    {
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.qtip2'), true, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();

        // auto-qtip on <a title="something">link</a>
        $cs->registerScript('qtip2', '
            $(document).on("mouseover", "' . $this->selector . '", function(event) {
                var e = $(this);
                index = e.parent().index();
                e.qtip({
                    overwrite: false,
                    style: {
                        classes: "qtip-bootstrap"
                    },
                    show: {
                        ready: true
                    },
                    position: {
                        adjust: {
                            screen: true
                        },
                        my: "bottom center",
                        at: "top center",
                        viewport: $(window)
                    }
                });
            });
        ', CClientScript::POS_READY);
        $cs->registerCSSFile($baseUrl . '/jquery.qtip.css', 'screen, projection');
        $cs->registerScriptFile($baseUrl . '/jquery.qtip.min.js', CClientScript::POS_HEAD);
    }

}