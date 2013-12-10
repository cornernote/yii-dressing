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
     * save returnUrl from submitted data
     */
    public function init()
    {
        $this->setUrlFromSubmitFields();
    }

    /**
     * Get url from submitted data or the current page url
     * for usage in a hidden form element
     *
     * @usage
     * in views/your_page.php
     * CHtml::hiddenField('returnUrl', Yii::app()->returnUrl->getFormValue());
     *
     * @param bool $currentPage
     * @param bool $encode
     * @return null|string
     */
    public function getFormValue($currentPage = false, $encode = false)
    {
        if ($currentPage) {
            $url = Yii::app()->request->getUrl();
            if ($encode) {
                $url = $this->urlEncode($url);
            }
        }
        else {
            $url = $this->getUrlFromSubmitFields();
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
     * @param bool $currentPage
     * @return string
     */
    public function getLinkValue($currentPage = false)
    {
        if ($currentPage) {
            $url = Yii::app()->request->getUrl();
        }
        else {
            $url = $this->getUrlFromSubmitFields();
        }
        // base64 encode so seo urls dont break
        return $this->encodeLinkValue($url);
    }

    /**
     * Get url from submitted data or the current page url
     * for usage in a link
     *
     * @usage
     * in views/your_page.php
     * CHtml::link('my link', array('test/form', 'returnUrl' => Yii::app()->returnUrl->encodeLinkValue($item->getUrl())));
     *
     * @param $url
     * @return string
     */
    public function encodeLinkValue($url)
    {
        return $this->urlEncode($url);
    }

    /**
     * Get url from submitted data or session
     *
     * @usage
     * in YourController::actionYourAction()
     * $this->redirect(Yii::app()->returnUrl->getUrl());
     *
     * @param bool|mixed $altUrl
     * @return mixed|null
     */
    public function getUrl($altUrl = false)
    {
        $url = $this->getUrlFromSubmitFields();
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
     */
    public function setUrlFromSubmitFields()
    {
        $url = $this->getUrlFromSubmitFields();
        if ($url) {
            // save to session
            Yii::app()->user->setReturnUrl($url);
        }
    }

    /**
     * Get the url from the request, decodes if needed
     *
     * @return null|string
     */
    private function getUrlFromSubmitFields()
    {
        $url = YdHelper::getSubmittedField('returnUrl');
        if ($url && isset($_GET['returnUrl']) && base64_decode($url)) {
            $url = $this->urlDecode($url);
        }
        return $url;
    }

    /**
     * @param $input
     * @return string
     */
    private function urlEncode($input)
    {
        $key = uniqid();
        Yii::app()->cache->set('ReturnUrl.' . $key, $input);
        return $key;
    }

    /**
     * @param $key
     * @return string
     */
    private function urlDecode($key)
    {
        return Yii::app()->cache->get('ReturnUrl.' . $key);
    }

}
