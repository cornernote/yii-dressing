<?php
/**
 * @var YdBPayHelper $bPay
 * @var string $crn
 * @var string $logo
 */
?>
<table border="0" cellpadding="0" cellspacing="0" style="width: 200px;font-family: Arial, Helvetica, sans-serif;background-color: #FFFFFF;margin: 0px; padding:7px; border:1px solid #000;">
    <tr>
        <td width="1%" style="width: 42px;"><img src="<?php echo $logo; ?>"/></td>
        <td style="border: 1px solid #000000;padding: 0px 8px;height: 54px;width: 158px;">
            <p style="font-size: 13px;text-transform: capitalize;color: #000000;white-space: nowrap;line-height: 22px;font-weight: normal;">
                Biller Code: <?php echo $bPay->billerCode; ?>
                <br/> Ref: <?php echo $crn; ?></p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p style="font-size: 11px;text-transform: capitalize;color: #000000;white-space: nowrap;line-height: 20px;font-weight: bold;"><?php echo $bPay->heading; ?></p>
        </td>
    </tr>
    <tr>
        <td colspan="2"><p style="font-size: 11px;color: #000000;"><?php echo $bPay->text; ?></p></td>
    </tr>
</table>