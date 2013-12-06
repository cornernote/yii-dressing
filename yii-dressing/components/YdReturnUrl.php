<?php
/**
 * Wrapper to maintain state of a Return URL
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdReturnUrl extends CApplicationComponent
{

    /**
     * Get url from submitted data or the current page url
     * for usage in a hidden form element
     *
     * @usage
     * in views/your_page.php
     * CHtml::hiddenField('returnUrl', Yii::app()->returnUrl->getFormValue());
     *
     * @static
     * @param bool $currentPage
     * @param bool $encode
     * @return null|string
     */
    static public function getFormValue($currentPage = false, $encode = false)
    {
        if ($currentPage) {
            $url = Yii::app()->request->getUrl();
            if ($encode) {
                $url = self::urlEncode($url);
            }
        }
        else {
            $url = self::getUrlFromSubmitFields();
        }
        return $url;
    }

    /**
     * Get url from submitted data or the current page url
     * for usage in a link
     *
     * @usage
     * in views/your_page.php
     * CHtml::link('my link', array('test/form', 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true)));
     *
     * @static
     * @param bool $currentPage
     * @return string
     */
    static public function getLinkValue($currentPage = false)
    {
        if ($currentPage) {
            $url = Yii::app()->request->getUrl();
        }
        else {
            $url = self::getUrlFromSubmitFields();
        }
        // base64 encode so seo urls dont break
        return self::encodeLinkValue($url);
    }

    /**
     * Get url from submitted data or the current page url
     * for usage in a link
     *
     * @usage
     * in views/your_page.php
     * CHtml::link('my link', array('test/form', 'returnUrl' => Yii::app()->returnUrl->encodeLinkValue($item->getUrl())));
     *
     * @static
     * @param $url
     * @return string
     */
    static public function encodeLinkValue($url)
    {
        return self::urlEncode($url);
    }

    /**
     * Get url from submitted data or session
     *
     * @usage
     * in YourController::actionYourAction()
     * $this->redirect(Yii::app()->returnUrl->getUrl());
     *
     * @static
     * @param bool|mixed $altUrl
     * @return mixed|null
     */
    static public function getUrl($altUrl = false)
    {
        $url = self::getUrlFromSubmitFields();
        if (!$url) {
            // load from given url
            $url = $altUrl;
        }
        if (!$url) {
            // load from session
            $url = Yii::app()->user->getReturnUrl();
        }
        if (!$url) {
            // load from current page
            $url = Yii::app()->request->getUrl();
        }
        // unset the session
        Yii::app()->user->setReturnUrl(null);
        return $url;
    }

    /**
     * If returnUrl is in submitted data it will be saved in session
     *
     * @usage
     * in Controller::beforeAction()
     *
     * @static
     */
    static public function setUrlFromSubmitFields()
    {
        $url = self::getUrlFromSubmitFields();
        if ($url) {
            // save to session
            Yii::app()->user->setReturnUrl($url);
        }
    }

    /**
     * Get the url from the request, decodes if needed
     *
     * @static
     * @return null|string
     */
    static private function getUrlFromSubmitFields()
    {
        $url = YdHelper::getSubmittedField('returnUrl');
        if ($url && isset($_GET['returnUrl']) && base64_decode($url)) {
            $url = self::urlDecode($url);
        }
        return $url;
    }

    /**
     * @param $input
     * @return string
     */
    static private function urlEncode($input)
    {
        $key = uniqid();
        Yii::app()->cache->set('ReturnUrl.' . $key, $input);
        return $key;
    }

    /**
     * @param $key
     * @return string
     */
    static private function urlDecode($key)
    {
        return Yii::app()->cache->get('ReturnUrl.' . $key);
    }

}
