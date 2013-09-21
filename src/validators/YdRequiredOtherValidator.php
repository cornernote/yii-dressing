<?php
/**
 * YdRequiredOtherValidator
 * Validates that the specified attribute does not
 * have null or empty value when the otherField has a value.
 *
 * @package app.model.validator
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class YdRequiredOtherValidator extends CRequiredValidator
{

    /**
     * @var string the field name of the otherField.
     */
    public $otherField;

    /**
     * @var string the value of the otherField that will trigger the required.
     */
    public $otherFieldValue = false;

    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object, $attribute)
    {
        if ($this->otherFieldValue === false && !$object->{$this->otherField}) return;
        if ($this->otherFieldValue === false || $object->{$this->otherField} == $this->otherFieldValue) {
            $otherFieldLabel = $object->getAttributeLabel($this->otherField);
            $otherFieldValueLabel = $this->otherFieldValue ? $this->otherFieldValue : Yii::t('dressing', 'not blank');

            $value = $object->$attribute;
            if ($this->requiredValue !== null) {
                if (!$this->strict && $value != $this->requiredValue || $this->strict && $value !== $this->requiredValue) {
                    $message = $this->message !== null ? $this->message : Yii::t('dressing', '{attribute} must be {value} when {otherFieldLabel} is {otherFieldValueLabel}.', 'app', array(
                        '{value}' => $this->requiredValue,
                        '{otherFieldLabel}' => $otherFieldLabel,
                        '{otherFieldValueLabel}' => $otherFieldValueLabel,
                    ));
                    $this->addError($object, $attribute, $message);
                }
            }
            else if ($this->isEmpty($value, true)) {
                $message = $this->message !== null ? $this->message : Yii::t('dressing', '{attribute} cannot be blank when {otherFieldLabel} is {otherFieldValueLabel}.', 'app', array(
                    '{otherFieldLabel}' => $otherFieldLabel,
                    '{otherFieldValueLabel}' => $otherFieldValueLabel,
                ));
                $this->addError($object, $attribute, $message);
            }

        }
    }
}
