<?php

/**
 * PayPal Helper
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
 * @var array $defaultOptions
 * @var string $imageAltText
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdPayPalHelper extends CApplicationComponent
{

    /**
     * @var string PayPal account email address
     */
    public $business;

    /**
     * @var string sandbox or live
     */
    public $environment = 'sandbox';

    /**
     * @link https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
     * @link https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_IPNandPDTVariables
     * @var array PayPal Options
     */
    public $defaultOptions = array(
        //// example options
        //'cmd' => '_xclick-subscriptions',
        //'return' => 'https://localhost/checkout/success',
        //'cancel_return' => 'https://localhost/checkout/plan',
        //'notify_url' => 'https://localhost/checkout/ipn',
        //'currency_code' => 'AUD',
        //'p3' => 1,
        //'t3' => 'M',
        //'no_shipping' => 1,
        //'no_note' => 1,
        //'charset' => 'utf-8',
        //// overwrite these using $options in linkButton() and formButton()
        //'item_name' => 'Subscription',
        //'item_number' => 'subscription',
        //'a3' => 1.00,
        //'custom' => '',
        //'invoice' => '',
    );

    /**
     * @link https://developer.paypal.com/webapps/developer/docs/classic/archive/buttons/
     * @var string
     */
    public $image = 'https://www.paypalobjects.com/en_AU/i/btn/btn_subscribe_LG.gif';

    /**
     * @var string
     */
    private $imageAltText = 'PayPal - The safer, easier way to pay online.';

    /**
     * @return string
     */
    public function url()
    {
        return 'https://www.' . ($this->environment != 'live' ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr';
    }

    /**
     * @param array $options
     * @return string
     */
    public function formButton($options = array())
    {
        $form = CHtml::beginForm($this->url(), 'get');
        $form .= CHtml::hiddenField('business', $this->business);
        foreach (CMap::mergeArray($this->defaultOptions, $options) as $k => $v)
            $form .= CHtml::hiddenField($k, $v);
        $form .= CHtml::imageButton($this->image, array('border' => 0, 'alt' => $this->imageAltText));
        $form .= CHtml::endForm();
        return $form;
    }

    /**
     * @param array $options
     * @return string
     */
    public function linkButton($options = array())
    {
        $options = CMap::mergeArray($this->defaultOptions, $options);
        $options['business'] = $this->business;
        $image = CHtml::image($this->image, $this->imageAltText);
        $url = $this->url() . ($options ? '?' . http_build_query($options) : '');
        return CHtml::link($image, $url);
    }

    /**
     * @return string
     */
    public function unsubscribeLink()
    {
        return $this->url() . '?cmd=_manage-paylist';
    }

    /**
     * Verify the IPN came from PayPal
     *
     * Example:
     * Yii::app()->payPalHelper->verifyIpn($_POST, $_SERVER['HTTP_USER_AGENT'])
     *
     * NOTE: In addition you should check other POST data including the business, amount, currency, item number and quantity.
     * You may also consider hashing these values with a seed into the custom field.
     * These are not checked here because they come through as different variables depending on the payment type.
     *
     * @link https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNIntro/
     * @param $data - $_POST
     * @param $agent - $_SERVER['HTTP_USER_AGENT']
     * @param $amount
     * @param $tax
     * @param $currency
     * @param $invoice
     * @param $custom
     * @param $itemNumber
     * @param $quantity
     * @return array of errors, or empty array if no errors
     */
    public function verifyIpn($data, $agent)
    {
        $errors = array();

        if (trim(file_get_contents($this->url() . '?cmd=_notify-validate&' . http_build_query($data))) != 'VERIFIED')
            $errors[] = 'Invalid IPN request';

        if (strpos($agent, 'PayPal IPN') === false)
            $errors[] = 'Invalid user agent';

        return $errors;
    }

}