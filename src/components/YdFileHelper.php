<?php
/**
 * Class YdFileHelper
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdFileHelper extends CFileHelper
{

    /**
     * @param string $dir
     * @param int $mode
     * @param bool $recursive
     * @return string
     * @throws CException
     */
    public static function createDirectory($dir, $mode = 0755, $recursive = true)
    {
        if (file_exists($dir)) {
            return $dir;
        }
        $created = @mkdir($dir, $mode, $recursive);
        if (!$created) {
            throw new CException('Error occurred when trying to create directory ' . $dir);
        }
        return $dir;
    }

    /**
     * @param $dir
     * @param $removeSelf
     */
    public static function removeDirectory($dir, $removeSelf = true)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        self::removeDirectory($dir . "/" . $object, true);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            if ($removeSelf) {
                rmdir($dir);
            }
        }
    }

    /**
     * @param $source
     * @param $destination
     * @return bool
     */
    public static function zip($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', realpath($file));

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }
                else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        }
        else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

}