<?php
/**
 * Class YdBPayHelper
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
        return
            '<style type="text/css">
	<!--
	TABLE.bpay{
		width: 200px;
		font-family: Arial, Helvetica, sans-serif;
		background-color: #FFFFFF;
		margin: 0px;
		border: 7px solid #FFFFFF;

	}
	TD.bpayLogo {
		width: 42px;

	}
	TD.customerReferenceBox {
		border: 1px solid #000000;
		padding: 0px 8px;
		height: 54px;
		width: 158px;
	}

	.customerReferenceBoxText {
		font-size: 13px;
		text-transform: capitalize;
		color: #000000;
		white-space: nowrap;
		line-height: 22px;
		font-weight: normal;

	}

	.billerTextHeading {
		font-size: 11px;
		text-transform: capitalize;
		color: #000000;
		white-space: nowrap;
		line-height: 20px;
		font-weight: bold;
	}
	.billerText{
		font-size: 11px;
		color: #000000;
	}
	-->
	</style>
	<div align="left">
	<table border="0" cellpadding="0" cellspacing="0" class="bpay">
	  <tr>
		<td width="1%" class="bpayLogo"><img src="' . $this->logo . '" /></td>
		<td class="customerReferenceBox">
		  <p class="customerReferenceBoxText">Biller Code: ' . $this->billerCode . '<br>
			Ref: ' . $crn . '</p>
		  </td>
	  </tr>
	  <tr><td colspan="2"><p class="billerTextHeading">' . $this->heading . '</p>
	</td></tr>
	<tr><td colspan="2"><p class="billerText">' . $this->text . '</p></td></tr>
	</table>
	</div>
	';
        //MODULE_PAYMENT_BPAY_TEXT_DESCRIPTION
    }


}