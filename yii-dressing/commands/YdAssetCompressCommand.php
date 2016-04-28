<?php

/**
 * Class YdAssetCompressCommand
 * @see https://github.com/aarondfrancis/mantis-manager
 */
class YdAssetCompressCommand extends YdConsoleCommand
{

    /**
     * @var string
     */
    public $assetsPath = 'application.assets';
    /**
     * @var array
     */
    public $css = array();
    /**
     * @var array
     */
    public $js = array();

    /**
     * @var
     */
    private $_assetsPath;

    /**
     *
     */
    public function init()
    {
        $this->_assetsPath = Yii::getPathOfAlias($this->assetsPath);

        $this->css = CMap::mergeArray(array(
            'combine' => array(),
            'minify' => true
        ), $this->css);

        $this->js = CMap::mergeArray(array(
            'combine' => array(),
            'minify' => true
        ), $this->js);
    }

    /**
     *
     */
    public function actionIndex()
    {
        $this->consoleEcho("Asset Compress\r\n", "0;35");
        $combine = array_merge($this->css['combine'], $this->js['combine']);
        foreach ($combine as $filename => $files) {
            $this->consoleEcho("Combining ", "0;32");
            $this->consoleEcho("for " . $this->_assetsPath . '/' . $filename . "\r\n");
            $content = $this->combine($files);

            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if ($ext == "css" && $this->css['minify']) {
                $this->consoleEcho("Minifying ", "0;32");
                $this->consoleEcho(" $filename \r\n");
                $content = $this->minifyCSS($content);
            }
            if ($ext == "js" && $this->js['minify']) {
                $this->consoleEcho("Minifying ", "0;32");
                $this->consoleEcho(" $filename \r\n");
                $content = $this->minifyJS($content);
            }

            $dir = dirname($this->_assetsPath . '/' . $filename);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = new SplFileInfo($this->_assetsPath . '/' . $filename);
            $this->consoleEcho("Writing ", "0;32", true);
            $this->consoleEcho($file->getFilename() . " \r\n", null, true);
            file_put_contents($this->_assetsPath . '/' . $filename, $content);
        }
    }

    /**
     * @param array $files
     * @return string
     * @throws CException
     */
    private function combine($files)
    {
        $content = "";
        foreach ($files as $file) {
            $this->consoleEcho("Adding ", "0;32");
            $this->consoleEcho($file . "\r\n");

            list($_assetPath, $file) = explode('|', $file);
            if ($_assetPath == 'application') {
                $assetPath = Yii::getPathOfAlias('www');
                $assetUrl = Yii::app()->baseUrl;
            } else {
                $assetPath = Yii::getPathOfAlias($_assetPath);
                $assetUrl = Yii::app()->assetManager->publish($assetPath);
            }
            $assetUrl = ltrim($assetUrl, '.');

            $relativePath = dirname($assetPath . '/' . $file);
            $relativeUrl = str_replace($assetPath, $assetUrl, $relativePath);

            $_content = file_get_contents($assetPath . '/' . $file);
            if (pathinfo($file, PATHINFO_EXTENSION) == 'css') {
                $_content = preg_replace('%url\s*\(\s*[\\\'"]?(?!(((?:https?:)?\/\/)|(?:data:?:)))([^\\\'")]+)[\\\'"]?\s*\)%', 'url("' . $relativeUrl . '/$3")', $_content);
            }
            $content .= $_content;
        }
        return $content;
    }

    /**
     * @param $contents
     * @return string
     */
    private function minifyCSS($contents)
    {
        if (!$contents) return "";
        return Minify_CSS_Compressor::process($contents);
    }

    /**
     * @param $contents
     * @return string
     */
    private function minifyJS($contents)
    {
        if (!$contents) return "";
        return JShrink\Minifier::minify($contents);
        //return Minify_JS_ClosureCompiler::minify($contents);
    }

    /**
     * @param $msg
     * @param null $color
     */
    public function consoleEcho($msg, $color = null)
    {
        if (Yii::app() instanceof CConsoleApplication) {
            if (!is_null($color)) {
                echo "\033[{$color}m" . $msg . "\033[0m";
            } else {
                echo $msg;
            }
        }
    }

}
