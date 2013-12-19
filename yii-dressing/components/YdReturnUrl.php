<?php
/**
 * Wrapper to maintain state of a Return Url
 *
 * Allows the user to have multiple tabs open, each will have its own Return Url passed in via the GET or POST params.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdReturnUrl extends CApplicationComponent
{

    /**
     * @var string The key used in GET and POST requests for the Return Url.
     */
    public $requestKey = 'returnUrl';

    /**
     * Get url from submitted data or the current page url
     * for usage in a hidden form element
     *
     * @usage
     * in views/your_page.php
     * <pre>
     * CHtml::hiddenField('returnUrl', Yii::app()->returnUrl->getFormValue());
     * </pre>
     *
     * @param bool $currentPage
     * @param bool $encode
     * @return null|string
     */
    public function getFormValue($currentPage = false, $encode = false)
    {
        if ($currentPage)
            $url = $encode ? $this->urlEncode(Yii::app()->getRequest()->getUrl()) : Yii::app()->getRequest()->getUrl();
        else
            $url = $this->getUrlFromSubmitFields();
        return $url;
    }

    /**
     * Get url from submitted data or the current page url
     * for usage in a link
     *
     * @usage
     * in views/your_page.php
     * <pre>
     * CHtml::link('my link', array('test/form', 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true)));
     * </pre>
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
     * <pre>
     * CHtml::link('my link', array('test/form', 'returnUrl' => Yii::app()->returnUrl->encodeLinkValue($item->getUrl())));
     * </pre>
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
     * <pre>
     * $this->redirect(Yii::app()->returnUrl->getUrl());
     * </pre>
     *
     * @param bool|mixed $altUrl
     * @return mixed|null
     */
    public function getUrl($altUrl = false)
    {
        $url = $this->getUrlFromSubmitFields();
        // alt url or current page
        if (!$url)
            $url = $altUrl ? $altUrl : Yii::app()->request->getUrl();
        return $url;
    }

    /**
     * Get the url from the request, decodes if needed
     *
     * @return null|string
     */
    private function getUrlFromSubmitFields()
    {
        $requestKey = $this->requestKey;
        $url = isset($_GET[$requestKey]) ? $_GET[$requestKey] : (isset($_POST[$requestKey]) ? $_POST[$requestKey] : false);
        return isset($_GET[$requestKey]) ? $this->urlDecode($url) : $url;
    }

    /**
     * @param $input
     * @return string
     */
    private function urlEncode($input)
    {
        $key = uniqid();
        Yii::app()->cache->set($this->requestKey . '.' . $key, $input);
        return $key;
    }

    /**
     * @param $key
     * @return string
     */
    private function urlDecode($key)
    {
        return Yii::app()->cache->get($this->requestKey . '.' . $key);
    }

}
