<?php

/**
 *
 */
class YdClientScript extends CClientScript
{

    /**
     * @var array the registered CSS files (CSS URL=>media type).
     * @since 1.0.4
     */
    protected $cssFiles = array();
    /**
     * @var array
     */
    protected $cssFilesOrder = array();

    /**
     * @var array
     */
    protected $css = array();
    /**
     * @var array
     */
    protected $cssOrder = array();
    /**
     * @var array the registered JavaScript files (position, key => URL)
     * @since 1.0.4
     */
    protected $scriptFiles = array();
    /**
     * @var array
     */
    protected $scriptFilesOrder = array();
    /**
     * @var array the registered JavaScript code blocks (position, key => code)
     * @since 1.0.5
     */
    public $scripts = array();
    /**
     * @var array
     */
    protected $scriptsOrder = array();

    /**
     * Registers a CSS file
     * @param string $url URL of the CSS file
     * @param string $media media that the CSS file should be applied to. If empty, it means all media types.
     * @return YdClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     */
    public function registerCssFile($url, $media = '')
    {
        // do not load these scripts on ajax
        $ignoreAjax = array(
            'yii.css',
            'bootstrap-yii.css',
            'bootstrap-yii.min.css',
            'bootstrap-responsive.css',
            'bootstrap-responsive.min.css',
            'bootstrap.no-responsive.css',
            'bootstrap.no-responsive.min.css',
            'bootstrap.css',
            'bootstrap.min.css',
            'font-awesome.css',
            'font-awesome.min.css',
            'jquery-ui-bootstrap.css',
            'jquery-ui-bootstrap.min.css',
            'bootstrap-notify.css',
            'bootstrap-notify.min.css',
            'jquery.qtip.css',
            'style.css',
        );
        if (app()->request->isAjaxRequest) {
            foreach ($ignoreAjax as $ignore) {
                if ($this->endsWith($url, $ignore))
                    return $this;
            }
        }
        return parent::registerCssFile($url, $media);
    }

    /**
     * Registers a CSS file
     * @param string $url URL of the CSS file
     * @param string $media media that the CSS file should be applied to. If empty, it means all media types.
     * @param int $order
     * @return YdClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     */
    public function registerCssFileOrder($url, $media = '', $order = 0)
    {
        $this->cssFilesOrder[$url] = $order;
        return $this->registerCssFile($url, $media);
    }

    /**
     * @param string $id
     * @param string $css
     * @param string $media
     * @param array $options
     * @return YdClientScript
     */
    public function registerCss($id, $css, $media = '', $options = array())
    {
        $options = array_merge(array(
            'order' => 0,
        ), $options);
        $this->cssOrder[$id] = $options['order'];
        return parent::registerCss($id, $css, $media);
    }

    /**
     * @param string $id
     * @param string $css
     * @param string $media
     * @param int $order
     * @return YdClientScript
     */
    public function registerCssOrder($id, $css, $media = '', $order = 0)
    {
        $this->cssOrder[$id] = $order;
        return $this->registerCss($id, $css, $media);
    }

    /**
     * Renders the registered scripts.
     * This method is called in {@link CController::render} when it finishes
     * rendering content. CClientScript thus gets a chance to insert script tags
     * at <code>head</code> and <code>body</code> sections in the HTML output.
     * @param string $output the existing output that needs to be inserted with script tags
     */
    public function render(&$output)
    {
        if (!$this->hasScripts)
            return;

        $this->renderCoreScripts();

        if (!empty($this->scriptMap))
            $this->remapScripts();

        $this->unifyScripts();
        $this->reorderScripts();

        $this->renderHead($output);
        if ($this->enableJavaScript) {
            $this->renderBodyBegin($output);
            $this->renderBodyEnd($output);
        }
    }

    /**
     *
     */
    public function reorderScripts()
    {
        $this->cssFiles = $this->reorderScriptSet($this->cssFiles, $this->cssFilesOrder);
        $this->css = $this->reorderScriptSet($this->css, $this->cssOrder);
        if (isset($this->scriptFiles[self::POS_END])) {
            $this->scriptFiles[self::POS_END] = $this->reorderScriptSet($this->scriptFiles[self::POS_END], isset($this->scriptFilesOrder[self::POS_END]) ? $this->scriptFilesOrder[self::POS_END] : array());
        }
        if (isset($this->scripts[self::POS_READY])) {
            $this->scripts[self::POS_READY] = $this->reorderScriptSet($this->scripts[self::POS_READY], isset($this->scriptsOrder[self::POS_READY]) ? $this->scriptsOrder[self::POS_READY] : array());
        }
    }

    /**
     * @param $files
     * @param $order
     * @return mixed
     */
    public function reorderScriptSet($files, $order)
    {
        if (!empty($order)) {
            asort($order);
            $newFiles = array();
            foreach ($order as $k => $_) {
                if (!isset($files[$k]))
                    continue;
                $newFiles[$k] = $files[$k];
                unset($files[$k]);
            }
            foreach ($newFiles as $k => $v) {
                $files[$k] = $v;
            }
        }
        return $files;
    }


    /**
     * Registers a javascript file.
     * @param string $url URL of the javascript file
     * @param int|null $position the position of the JavaScript code. Valid values include the following:
     * <ul>
     * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
     * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
     * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
     * </ul>
     * @param array $htmlOptions
     * @return YdClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     */
    public function registerScriptFile($url,$position=null,array $htmlOptions=array())
    {
        // do not load these scripts on ajax
        $ignoreAjax = array(
            'jquery-ui.min.js',
            'jquery-ui.js',
            'jquery-ui-i18n.min.js',
            'jquery-ui-i18n.js',
            'bootstrap.min.js',
            'bootstrap.js',
        );
        if (app()->request->isAjaxRequest) {
            foreach ($ignoreAjax as $ignore) {
                if ($this->endsWith($url, $ignore))
                    return $this;
            }
        }
        return parent::registerScriptFile($url, $position, $htmlOptions);
    }


    /**
     * Registers a javascript file.
     * @param string $url URL of the javascript file
     * @param int|null $position the position of the JavaScript code. Valid values include the following:
     * <ul>
     * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
     * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
     * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
     * </ul>
     * @param int $order
     * @return YdClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     */
    public function registerScriptFileOrder($url, $position = self::POS_HEAD, $order = 0)
    {
        if ($position === null)
            $position = $this->defaultScriptFilePosition;
        $this->scriptFilesOrder[$position][$url] = $order;
        return $this->registerScriptFile($url, $position);
    }

    /**
     * Registers a piece of javascript code.
     * @param string $id ID that uniquely identifies this piece of JavaScript code
     * @param string $script the javascript code
     * @param integer $position the position of the JavaScript code. Valid values include the following:
     * <ul>
     * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
     * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
     * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
     * <li>CClientScript::POS_LOAD : the script is inserted in the window.onload() function.</li>
     * <li>CClientScript::POS_READY : the script is inserted in the jQuery's ready function.</li>
     * </ul>
     * @param array $htmlOptions
     * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     */
    public function registerScript($id,$script,$position=null,array $htmlOptions=array())
    {
        return parent::registerScript($id, $script, $position ,$htmlOptions);
    }

    /**
     * Registers a piece of javascript code.
     * @param string $id ID that uniquely identifies this piece of JavaScript code
     * @param string $script the javascript code
     * @param integer $position the position of the JavaScript code. Valid values include the following:
     * <ul>
     * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
     * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
     * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
     * <li>CClientScript::POS_LOAD : the script is inserted in the window.onload() function.</li>
     * <li>CClientScript::POS_READY : the script is inserted in the jQuery's ready function.</li>
     * </ul>
     * @param int $order
     * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     */
    public function registerScriptOrder($id, $script, $position = null, $order = 0)
    {
        if ($position === null)
            $position = $this->defaultScriptPosition;
        $this->scriptsOrder[$position][$id] = $order;
        return $this->registerScript($id, $script, $position);
    }

    /**
     * Registers a script package that is listed in {@link packages}.
     * @param string $name the name of the script package.
     * @param array $options
     * @return YdClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
     * @see renderCoreScript
     */
    public function registerCoreScript($name, $options = array())
    {
        // do not load these scripts on ajax
        $ignoreAjax = array(
            'jquery',
            'yiiactiveform',
            'bootstrap-yii',
            'jquery-css',
            'notify',
            'bootstrap.js',
            'bootbox',
        );
        if (app()->request->isAjaxRequest && in_array($name, $ignoreAjax)) {
            return $this;
        }
        return parent::registerCoreScript($name);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }

}
