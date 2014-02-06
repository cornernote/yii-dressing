<?php

/**
 * YdAssetManager
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdAssetManager extends CAssetManager
{

    /**
     * Publishes a file or a directory.
     *
     * Will set $forceCopy=false if $this->linkAssets is true to prevent throwing an exception
     *
     * @param string $path
     * @param bool $hashByName
     * @param int $level
     * @param null $forceCopy
     */
    public function publish($path, $hashByName = false, $level = -1, $forceCopy = null)
    {
        if ($this->linkAssets)
            $forceCopy = false;
        return parent::publish($path, $hashByName, $level, $forceCopy);
    }

}
