<?php
/**
 * Override CJuiDatePicker
 */
Yii::import('zii.widgets.jui.CJuiDatePicker');
class YdDatePicker extends CJuiDatePicker
{
    public $row; // vertical | horizontal
    public $hint;

    public function init()
    {
        parent::init();
        if (!in_array($this->row, array('vertical', 'horizontal'))) {
            $this->row = false;
        }
        $options = array(
            'showAnim' => 'fold',
            'dateFormat' => 'yy-mm-dd',
            'changeMonth' => true,
            'changeYear' => true,
            'showOn' => 'both', // button | focus | both
        );
        if (Helper::isMobileBrowser()) {
            $options['showOn'] = 'button';
            $options['onClose'] = 'js:function(dateText, inst){$(this).attr("disabled", false);}';
            $options['beforeShow'] = 'js:function(input, inst){$(this).attr("disabled", true);}';
        }
        $this->options = CMap::mergeArray($options, $this->options);
        $this->htmlOptions = CMap::mergeArray(array(
            'autocomplete' => 'off',
        ), $this->htmlOptions);
        parent::init();
    }

    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];

        $cs = app()->getClientScript();

        // show the input, not the calendar
        if ($this->flat === false) {
            $labelOptions = array();

            if ($this->row == 'horizontal') {
                echo '<div class="control-group">';
                $labelOptions['class'] = 'control-label';
            }
            if ($this->row) {
                if ($this->hasModel()) {
                    echo CHtml::activeLabelEx($this->model, $this->attribute, $labelOptions);
                }
                else {
                    echo CHtml::label($this->attribute, $name, $labelOptions);
                }
            }
            if ($this->row == 'horizontal') {
                echo '<div class="controls">';
            }
            echo '<div class="input-append">';
            if ($this->hasModel()) {
                echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
            }
            else {
                echo CHtml::textField($name, $this->value, $this->htmlOptions);
            }
            echo '<span class="add-on"><i id="' . $id . '-button" class="icon-calendar"></i></span>';
            echo '</div>';
            if ($this->hasModel()) {
                echo CHtml::error($this->model, $this->attribute);
            }
            if ($this->hint) {
                echo CHtml::tag('p', array('class' => 'help-block'), $this->hint);
            }
            if ($this->row == 'horizontal') {
                echo '</div>';
                echo '</div>';
            }

            $buttonJs = "jQuery('#{$id}-button').click(function(){ jQuery('#ui-datepicker-div').is(':visible') ? jQuery('#{$id}').datepicker('hide') : jQuery('#{$id}').datepicker('show'); })";
            $buttonCss = 'button.ui-datepicker-trigger{display:none;}';
            $cs->registerScript(__CLASS__ . '#' . $id . '-button', $buttonJs);
            $cs->registerCss(__CLASS__ . '#' . $id . '-button', $buttonCss);
        }

        // show the calendar, not the input
        else {
            if ($this->hasModel()) {
                echo CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
                $attribute = $this->attribute;
                $this->options['defaultDate'] = $this->model->$attribute;
            }
            else {
                echo CHtml::hiddenField($name, $this->value, $this->htmlOptions);
                $this->options['defaultDate'] = $this->value;
            }

            if (!isset($this->options['onSelect']))
                $this->options['onSelect'] = "js:function( selectedDate ) { jQuery('#{$id}').val(selectedDate);}";

            $this->htmlOptions['id'] = $id = $this->htmlOptions['id'] . '_container';
            $this->htmlOptions['name'] = $name = $name . '_container';

            echo CHtml::tag('div', $this->htmlOptions);
        }

        $options = CJavaScript::encode($this->options);

        $js = "jQuery('#{$id}').datepicker($options);";
        if (isset($this->language)) {
            $this->registerScriptFile($this->i18nScriptFile);
            $js = "jQuery('#{$id}').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['{$this->language}'], {$options}));";
        }

        if (isset($this->defaultOptions)) {
            $this->registerScriptFile($this->i18nScriptFile);
            $cs->registerScript(__CLASS__, $this->defaultOptions !== null ? 'jQuery.datepicker.setDefaults(' . CJavaScript::encode($this->defaultOptions) . ');' : '');
        }
        $cs->registerScript(__CLASS__ . '#' . $id, $js);

    }

}
