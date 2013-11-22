<?php
/**
 * @var YdBPayHelper $bPay
 * @var string $crn
 */
?>
<style type="text/css">
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
            <td width="1%" class="bpayLogo"><img src="<?php echo $bPay->logo; ?>" /></td>
            <td class="customerReferenceBox">
                <p class="customerReferenceBoxText">Biller Code: <?php echo $bPay->billerCode; ?><br>
                    Ref: <?php echo $crn; ?></p>
            </td>
        </tr>
        <tr><td colspan="2"><p class="billerTextHeading"><?php echo $bPay->heading; ?></p>
            </td></tr>
        <tr><td colspan="2"><p class="billerText"><?php echo $bPay->text; ?></p></td></tr>
    </table>
</div>