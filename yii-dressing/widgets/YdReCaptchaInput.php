<?php
/**
 * YdReCaptchaInput class file.
 *
 * @author MetaYii
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008 MetaYii
 * @license
 *
 * Copyright © 2008 by MetaYii
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * - Neither the name of MetaYii nor the names of its contributors may
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 * ReCaptcha generates a CAPTCHA using the service provided by reCAPTCHA {@link http://recaptcha.net/}.
 * See LICENCE.txt for the terms of use for this service.
 *
 * ReCaptcha should be used together with {@link ReCaptchaValidator}.
 *
 * @author MetaYii
 *
 * @package dressing.widgets
 */

class YdReCaptchaInput extends CInputWidget
{

    /**
     * The theme name for the widget. Valid themes are 'red', 'white', 'blackglass', 'clean', 'custom'
     *
     * @var string the theme name for the widget
     */
    private $theme = 'red';

    /**
     * The language for the widget. Valid languages are 'en', 'nl', 'fr', 'de', 'pt', 'ru', 'es', 'tr'
     *
     * @var string the language suffix
     */
    private $language = 'en';

    /**
     * @var string the tab index for the HTML tag
     */
    public $tabIndex = 0;

    /**
     * @var string the id for the HTML containing the custom theme
     */
    public $customThemeWidget = '';

    /**
     * @var string
     */
    public $attribute = 'recapture';

    /**
     * Valid languages
     *
     * @var array
     */
    private $validLanguages = array('en', 'nl', 'fr', 'de', 'pt', 'ru', 'es', 'tr');

    /**
     * Valid themes
     *
     * @var array
     */
    private $validThemes = array('red', 'white', 'blackglass', 'clean', 'custom');

    /**
     * Sets the language
     *
     * @param string $value the language string
     * @return string
     */
    public function setLanguage($value)
    {
        $suffix = empty($value) ? 'en' : (($p = strpos($value, '_')) !== false) ? strtolower(substr($value, 0, $p)) : strtolower($value);
        if (in_array($suffix, $this->validLanguages)) $this->language = $suffix;
    }

    /**
     * Returns the language value
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets the theme
     *
     * @param string $value the theme
     */
    public function setTheme($value)
    {
        if (in_array($value, $this->validThemes)) $this->theme = $value;
    }

    /**
     * Returns the theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $customThemeWidget = (($w = $this->customThemeWidget) != '') ? "'{$w}'" : 'null';
        $cs = Yii::app()->getClientScript();

        if (!$cs->isScriptRegistered(get_class($this) . '_options')) {
            $script = <<<EOP
var RecaptchaOptions = {
   theme : '{$this->theme}',
   custom_theme_widget : {$customThemeWidget},
   lang : '{$this->language}',
   tabindex : {$this->tabIndex}
};
EOP;
            $cs->registerScript(get_class($this) . '_options', $script, CClientScript::POS_HEAD);
        }

        $body = '';
        if ($this->hasModel())
            $body = CHtml::activeHiddenField($this->model, $this->attribute) . "\n";
        echo $body . $this->getHtml();
    }

    /**
     * Gets the challenge HTML (javascript and non-javascript version).
     * This is called from the browser, and the resulting reCAPTCHA HTML widget
     * is embedded within the HTML form it was called from.
     * @param boolean $ssl Should the request be made over ssl? (optional, default is false)
     * @return string - The HTML to be embedded in the user's form.
     */
    protected function getHtml($ssl = true)
    {
        $reCaptcha = Yii::app()->reCaptcha;
        $server = $ssl ? $reCaptcha->secureServer : $reCaptcha->server;
        return '
            <script type="text/javascript" src="' . $server . '/challenge?k=' . $reCaptcha->publicKey . '"></script>
            <noscript>
                <iframe src="' . $server . '/noscript?k=' . $reCaptcha->publicKey . '" height="300" width="500" frameborder="0"></iframe><br/>
                <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
            </noscript>
        ';
    }

}