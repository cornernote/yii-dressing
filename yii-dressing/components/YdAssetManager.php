<?php

/**
 * YdAssetManager
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdAssetManager extends CAssetManager
{

    /**
     * Publishes a file or a directory.
     *
     * Will use linkAssets even if $forceCopy is true
     *
     * @param string $path
     * @param bool $hashByName
     * @param int $level
     * @param null $forceCopy
     */
    public function publish($path, $hashByName = false, $level = -1, $forceCopy = null)
    {
        if ($forceCopy && $this->linkAssets)
            $forceCopy = null;
        return parent::publish($path, $hashByName, $level, $forceCopy);
    }

}
