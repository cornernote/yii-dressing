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
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdPayPalHelper extends CApplicationComponent
{

    /**
     * @var string sandbox or live
     */
    public $environment = 'sandbox';

    /**
     * @var array PayPal Options
     * @ref https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_IPNandPDTVariables
     */
    public $options = array();

    /**
     *
     */
    public function init()
    {
        $this->options = CMap::mergeArray(array(
            'cmd' => '_xclick-subscriptions',
            'business' => 'webmaster@localhost',
            'lc' => 'AU',
            'no_note' => 1,
            'no_shipping' => 1,
            'rm' => 1,
            'return' => 'https://localhost/checkout/success',
            'cancel_return' => 'https://localhost/checkout/plan',
            'notify_url' => 'https://localhost/checkout/ipn',
            'src' => 1,
            'p3' => 1,
            't3' => 'M',
            'currency_code' => 'AUD',
            'bn' => 'PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted',
            // overwrite these using $options
            'item_name' => 'Subscription',
            'item_number' => 'subscription',
            'a3' => 1.00,
            'custom' => '',
            'invoice' => '',
        ), $this->options);
    }

    /**
     * @param $options
     * @return string
     */
    public function getButton($options)
    {
        $options = $this->getOptions($options);
        $button = '<form action="https://www.' . ($this->environment != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr" method="get">';
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
    public function getLink($options)
    {
        $options = $this->getOptions($options);
        $link = array();
        foreach ($options as $k => $v) {
            $link[] = urlencode($k) . '=' . urlencode($v);
        }
        return 'https://www.' . ($this->environment != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr?' . implode('&', $link);
    }

    /**
     * @return string
     */
    public function getUnsubscribeLink()
    {
        return 'https://www.' . ($this->environment != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr?cmd=_manage-paylist';
    }

}