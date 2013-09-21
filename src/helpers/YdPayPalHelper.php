<?php
/**
 *
 * Sandbox Accounts:
 * Seller user/pass = seller_1350383460_biz@mrphp.com.au / 350383305
 * Buyer user/pass = buyer_1350383726_per@mrphp.com.au / 350383682
 *
 * Sandbox Api:
 * 'username' => 'seller_1350383460_biz_api1.mrphp.com.au',
 * 'password' => '1350383522',
 * 'signature' => 'Af1LaOyCOePxDWuGMUExRqQv5fPMAq9GPNamfk5MKebSmMzKPs8CYhjb    ',
 * 'email' => 'seller_1350383460_biz@mrphp.com.au',
 * 'identityToken' => 'ifcqMvmR1e7j2E9ZfLwSG_p5eDRxg3PuQUe7Ri-Zo5SRrxKksr7qWKUfb-m',
 * 'business' => 'seller_1350383460_biz@mrphp.com.au',
 *
 */
class YdPayPalHelper
{
    /**
     * @param $options
     * @return array
     * @ref https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_IPNandPDTVariables
     */
    public static function getOptions($options)
    {
        $defaults = array(
            // defaults
            'cmd' => '_xclick-subscriptions',
            'business' => YdSetting::item('paypal', 'business'),
            'lc' => 'AU',
            'no_note' => 1,
            'no_shipping' => 1,
            'rm' => 1,
            'return' => 'https://www.example.com/checkout/success',
            'cancel_return' => 'https://www.example.com/checkout/plan',
            'notify_url' => 'https://www.example.com/checkout/ipn',
            'src' => 1,
            'p3' => 1,
            't3' => 'M',
            'currency_code' => 'AUD',
            'bn' => 'PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted',
            // overwrite these using $options
            'item_name' => Yii::t('dressing', 'Subscription'),
            'item_number' => 'subscription',
            'a3' => 1.00,
            'custom' => '',
            'invoice' => '',
        );
        return CMap::mergeArray($defaults, $options);
    }

    /**
     * @param $options
     * @return string
     */
    public static function getButton($options)
    {
        $options = self::getOptions($options);
        $button = '<form action="https://www.' . (YdSetting::item('paypal', 'env') != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr" method="get">';
        foreach ($options as $k => $v) {
            $button .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $button .= '<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">';
        $button .= '<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">';
        $button .= '</form>';
        return $button;
    }

    /**
     * @param $options
     * @return string
     */
    public static function getLink($options)
    {
        $options = self::getOptions($options);
        $link = array();
        foreach ($options as $k => $v) {
            $link[] = urlencode($k) . '=' . urlencode($v);
        }
        return 'https://www.' . (YdSetting::item('paypal', 'env') != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr?' . implode('&', $link);
    }

    /**
     * @return string
     */
    public static function getUnsubscribeLink()
    {
        return 'https://www.' . (YdSetting::item('paypal', 'env') != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr?cmd=_manage-paylist';
    }

}