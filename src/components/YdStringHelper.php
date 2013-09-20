<?php
/**
 * string functions
 */
class YdStringHelper
{

    /**
     * @param $contents
     * @param $start
     * @param $end
     * @param bool $removeStart
     * @param bool $removeEnd
     * @return string
     */
    static public function getBetweenString($contents, $start, $end, $removeStart = true, $removeEnd = true)
    {
        if ($start) {
            $startPos = strpos($contents, $start);
        }
        else {
            $startPos = 0;
        }

        if ($startPos === false) {
            return false;
        }
        if ($end) {
            $endPos = strpos($contents, $end, $startPos);
            if ($endPos === false) {
                $endPos = $endPos = strlen($contents);
            }
        }
        else {
            $endPos = strlen($contents);
        }

        if ($removeStart) {
            $startPos += strlen($start);
        }
        $len = $endPos - $startPos;
        if (!$removeEnd && $end && $endPos) {
            $len = $len + strlen($end);
        }
        $subString = substr($contents, $startPos, $len);
        return $subString;
    }


    /**
     * @static
     * @param $fileName
     * @return mixed
     */
    public static function getValidFileName($fileName)
    {
        $fileName = preg_replace('/[^0-9a-z ]+/i', '', $fileName);
        return $fileName;
    }

    /**
     * @static
     * @param $string
     * @return mixed|string
     */
    public static function slug($string)
    {
        $string = strtolower($string);
        $string = preg_replace('/[^0-9a-z ]/', '', $string);
        while (strpos($string, '  ') !== false) $string = str_replace('  ', ' ', $string);
        $string = str_replace(' ', '-', $string);
        return $string;
    }

    /**
     * Humanize
     * converts "some_string" or "someString" to "Some String"
     * @param $string
     * @return string
     */
    public static function humanize($string)
    {
        return ucwords(trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $string)))));
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function unserialize($string)
    {
        if (self::isSerialized($string)) {
            return unserialize($string);
        }
        return $string;
    }

    /**
     * @param $data
     * @return bool
     * @ref - http://stackoverflow.com/questions/1369936/check-to-see-if-a-string-is-serialized
     */
    public static function isSerialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
        }
        return false;
    }

    /**
     * @param $contents
     * @param int $limit
     * @return string
     */
    static public function getFirstLineWithIcon($contents, $limit = 50)
    {
        $contentsWithBr = nl2br($contents);
        $contentLines = explode('<br />', $contentsWithBr);
        // printr($issueLines);
        $firstLine = $contentLines[0];
        if (strlen($firstLine) > $limit) {
            $firstLine = substr($firstLine, 0, $limit - 2);
        }
        $icon = l(i(au() . '/icons/comments.png'), 'javascript:void();', array('title' => $contentsWithBr));
        if ($firstLine == $contentsWithBr) {
            $return = $contentsWithBr;
            $return = htmlentities($return);
        }
        else {
            // echo "<br/> not same <br/>";die;
            $return = htmlentities($firstLine) . '...&nbsp;' . $icon;
        }
        return $return;
    }

    /**
     * @param $short
     * @param $long
     * @return string
     */
    static public function getTextWithIcon($short, $long)
    {
        return $short . '...&nbsp;' . l(i(au() . '/icons/comments.png'), 'javascript:void();', array('title' => $long));
    }


    /**
     * @param $class
     * @param $method
     * @param string $tag
     * @return array|string
     */
    public static function getDocComment($class, $method, $tag = '')
    {
        $reflection = new ReflectionMethod($class, $method);
        $comment = $reflection->getDocComment();
        if (!$tag) {
            return $comment;
        }

        $matches = array();
        preg_match_all("/" . $tag . " (.*)(\\r\\n|\\r|\\n)/U", $comment, $matches);

        $returns = array();
        foreach ($matches[1] as $match) {
            $match = explode(' ', $match);
            $type = $match[0];
            $name = isset($match[1]) ? $match[1] : '';
            if (strpos($type, '$') === 0) {
                $name_ = $name;
                $name = $type;
                $type = $name_;
            }
            if (strpos($name, '$') !== 0) {
                $name = '';
            }
            $returns[] = trim($type . ' ' . $name);
        }

        return $returns;
    }

    /**
     * @static
     * @param $class
     * @param $method
     * @param $tag
     * @return array
     */
    public static function getTypeFromDocComment($class, $method, $tag)
    {
        $types = self::getDocComment($class, $method, $tag);
        $returnTypes = array();
        foreach ($types as $k => $type) {
            $filteredType = self::filterDocType($type);
            if ($filteredType) {
                $returnTypes[$k] = trim($filteredType);
            }
        }
        return $returnTypes;

    }

    /**
     * @static
     * @param $type
     * @return mixed|string
     */
    public static function filterDocType($type)
    {
        $ignoreTypes = array('void', 'mixed', 'null');
        $replace = array(
            'bool' => 'boolean',
            'integer' => 'int',
        );
        $filteredType = '';
        if (strpos($type, '|') !== false) {
            $multiType = explode('|', $type);
            $multiTypeSafe = array();
            foreach ($multiType as $singleType) {
                if (!in_array($singleType, $ignoreTypes)) {
                    if (isset($replace[$singleType])) {
                        $singleType = $replace[$singleType];
                    }
                    $multiTypeSafe[] = $singleType;
                }
            }
            $filteredType = implode('|', $multiTypeSafe);
        }
        else {
            if (!in_array($type, $ignoreTypes)) {
                $filteredType = $type;
                if (isset($replace[$type])) {
                    $filteredType = $replace[$type];
                }
            }
        }
        if ($filteredType) {
            $filteredType = str_replace('-', ' ', $filteredType);
            $filteredType = trim($filteredType);
            if (strpos($type, ' ')) {
                $filteredType = StringHelper::getBetweenString($type, false, ' ');
            }
        }

        return $filteredType;

    }

}