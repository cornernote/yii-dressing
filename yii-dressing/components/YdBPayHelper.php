<?php
/**
 * Class YdBPayHelper
 *
 * @package dressing.components
 */
class YdBPayHelper
{

    /**
     * @var string
     */
    public $billerCode = '180885';
    /**
     * @var string
     */
    public $heading = 'Telephone & Internet Banking - BPAY';
    /**
     * @var string
     */
    public $text = 'Call your bank, credit union or building society to make this payment from your cheque, savings or credit card account';
    /**
     * @var string
     */
    public $logo = 'http://d2v52na0ig3b4y.cloudfront.net/images/icons/Bpayv54ha.gif';

    /**
     * @param $ref
     * @param string $seperator
     * @param int $crn_length
     * @return string
     */
    public function crn($ref, $seperator = '', $crn_length = 10)
    {
        $ref = $ref + 100000000;
        $revstr = strrev(intval($ref));
        $total = 0;
        for ($i = 0; $i < strlen($revstr); $i++) {

            if ($i % 2 == 0) $multiplier = 2;
            else $multiplier = 1;

            $sub_total = intval($revstr[$i]) * $multiplier;
            if ($sub_total >= 10) {
                $temp = (string)$sub_total;
                $sub_total = intval($temp[0]) + intval($temp[1]);
            }
            $total += $sub_total;
        }

        $check_digit = (10 - ($total % 10)) % 10;
        $crn = str_pad($ref, $crn_length - 1, 0, STR_PAD_LEFT) . $seperator . $check_digit;
        return $crn;
    }

    /**
     * @param $crn
     * @return string
     */
    public function crnLogo($crn)
    {
        return Yii::app()->controller->renderPartial('dressing.views.misc.bpay', array(
            'bPay' => $this,
            'crn' => $crn,
        ), true);
    }


}