<?php
/**
 * YdGoogleAnalyticsWidget
 *
 * @property string $domainName
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdGoogleAnalyticsWidget extends CWidget
{

    /**
     * @var string
     */
    public $account = '';
    /**
     * @var
     */
    private $_domainName;

    /**
     *
     */
    public function run()
    {
        $contents = '
            var _gaq = _gaq || [];
            _gaq.push(["_setAccount", "' . $this->account . '"]);
            _gaq.push(["_setDomainName", "' . $this->domainName . '"]);
            _gaq.push(["_setAllowLinker", true]);
            _gaq.push(["_trackPageview"]);
            (function () {
                var ga = document.createElement("script");
                ga.type = "text/javascript";
                ga.async = true;
                ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(ga, s);
            })();
        ';
        Yii::app()->clientScript->registerScript($this->id, $contents, $this->position);
    }

    /**
     * @param $domainName
     */
    public function setDomainName($domainName)
    {
        $this->_domainName = $domainName;
    }

    /**
     * @return string
     */
    public function getDomainName()
    {
        if ($this->_domainName)
            return $this->_domainName;
        return $this->_domainName = Yii::app()->request->serverName;
    }
}