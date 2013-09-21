<?php
/**
 *
 */
class YdSignatureWidget extends CWidget
{
    /**
     * @var string form|view
     */
    public $action = 'form';

    /**
     * @var Signature signature to view
     */
    public $signature;

    /**
     *
     */
    public function init()
    {
        $this->registerScripts();
    }

    /**
     *
     */
    public function run()
    {
        if ($this->action == 'form') {
            echo $this->getForm();
        }
        if ($this->action == 'view') {
            echo $this->getView();
        }
    }

    /**
     *
     */
    public function getForm()
    {
        ob_start();
        ?>
        <div class="signature-pad">
            <label for="Signature_name">Type Your Name</label>
            <input id="Signature_name" type="text" value="" name="Signature[name]">
            <input id="Signature_signature" type="hidden" value="" name="Signature[signature]">
            <ul class="sigNav">
                <li class="typeIt"><a href="#type-it" class="current">Typed Signature</a></li>
                <li class="drawIt"><a href="#draw-it">Draw Signature</a></li>
                <li class="clearButton"><a href="#clear">Clear</a></li>
            </ul>
            <div class="sig sigWrapper">
                <div class="typed"></div>
                <canvas class="pad" width="600" height="150"></canvas>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     *
     */
    public function getView()
    {
        echo '<div class="signature-pad">';
        $attributes = array();
        $attributes[] = array(
            'label' => t('Signed By'),
            'name' => 'name',
            'value' => $this->signature->name,
        );
        $attributes[] = array(
            'name' => 'signature',
            'value' => '<canvas class="pad" width="600" height="150"></canvas>',
            'type' => 'raw',
        );
        $this->widget('widgets.DetailView', array(
            'data' => $this->signature,
            'attributes' => $attributes,
        ));
        echo '</div>';
        return ob_get_clean();
    }

    /**
     *
     */
    public function registerScripts()
    {
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.signature-pad'), false, 1, YII_DEBUG);

        //cs()->registerCssFile($baseUrl . '/jquery.signaturepad.css');
        cs()->registerScriptFile($baseUrl . '/jquery.signaturepad.min.js');
        $this->beginWidget('dressing.widgets.YdJavaScriptWidget', array('position' => CClientScript::POS_END));
        if ($this->action == 'form') {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".signature-pad").signaturePad({
                        name: '#Signature_name',
                        output: '#Signature_signature',
                        lineTop: 120
                    });
                });
            </script>
        <?php
        }
        if ($this->action == 'view') {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".signature-pad").signaturePad({displayOnly: true}).regenerate('<?php echo $this->signature->signature; ?>');
                });
            </script>
        <?php
        }
        $this->endWidget();
    }

}