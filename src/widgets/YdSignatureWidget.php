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
        echo '<div class="signature-pad">';
        //echo '<label for="Signature_name">Type Your Name</label>';
        //echo '<input id="Signature_name" type="text" value="" name="Signature[name]">';
        echo '<input id="Signature_signature" type="hidden" value="" name="Signature[signature]">';
        echo '<ul class="sigNav"><li class="typeIt"><a href="#type-it" class="current">Typed Signature</a></li><li class="drawIt"><a href="#draw-it">Draw Signature</a></li><li class="clearButton"><a href="#clear">Clear</a></li></ul>';
        echo '<div class="sig sigWrapper"><div class="typed"></div><canvas class="pad" width="600" height="150"></canvas></div>';
        echo '</div>';
        return ob_get_clean();
    }

    /**
     *
     */
    public function getView()
    {
        echo '<div class="signature-pad">';
        $attributes = array();
        //$attributes[] = array(
        //    'label' => t('Signed By'),
        //    'name' => 'name',
        //    'value' => $this->signature->name,
        //);
        $attributes[] = array(
            'name' => 'signature',
            'value' => '<canvas class="pad" width="600" height="150"></canvas>',
            'type' => 'raw',
        );
        $this->widget('dressing.widgets.YdDetailView', array(
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
        if ($this->action == 'form') {
            $options = json_encode(array(
                //'name' => '#Signature_name',
                'output' => '#Signature_signature',
                'lineTop' => 120,
                'drawOnly' => true,
            ));
            $methodChain = '';
        }
        if ($this->action == 'view') {
            $options = json_encode(array(
                'displayOnly' => true,
            ));
            $methodChain = ".regenerate('" . $this->signature->signature . "')";
        }

        Yii::app()->clientScript->registerPackage('signature-pad');
        Yii::app()->clientScript->registerScript('signature-pad', '$(".signature-pad").signaturePad(' . $options . ')' . $methodChain . ';', CClientScript::POS_READY);
    }

}