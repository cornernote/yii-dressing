<?php

/**
 * Class YdQTip
 */
class YdQTip extends CWidget
{
    /**
     *
     */
    public function init()
    {
        $this->publishAssets();
    }

    // function to publish and register assets on page
    /**
     *
     */
    public function publishAssets()
    {
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.qtip2'), false, 1, YII_DEBUG);

        $cs = Yii::app()->clientScript;
        // auto-qtip on <a title="something">link</a>
        $cs->registerScript('qtip2', '
            $(document).on("mouseover", "a[title],i[title],.icon[title]", function(event) {
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
        ', CClientScript::POS_HEAD);
        $cs->registerCSSFile($baseUrl . '/jquery.qtip.css', 'screen, projection');
        $cs->registerScriptFile($baseUrl . '/jquery.qtip.min.js', CClientScript::POS_HEAD);
    }
}