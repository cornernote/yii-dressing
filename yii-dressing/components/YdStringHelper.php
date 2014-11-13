<?php

/**
 * Class YdStringHelper
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
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
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return (substr($haystack, 0, strlen($needle)) == $needle);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        return (substr($haystack, strlen($needle) * -1) == $needle);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function serialize($string)
    {
        return serialize($string);
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
     * @param $text
     * @param $length
     * @return string
     */
    static public function truncate($text, $length = 100)
    {
        return YdCakeString::truncate($text, $length, array(
            'ellipsis' => '...&nbsp;' . CHtml::link('<i class="icon-comment"></i>', 'javascript:void();', array('title' => $text)),
        ));
    }

    /**
     * @param int $length
     * @return string
     */
    static public function randomWord($length = 7)
    {
        srand((double)microtime() * 1000000);
        $j = 0;
        $code = '';
        while ($j <= $length) {
            $num = rand() % 33;
            $code .= substr("abcdefghijkmnopqrstuvwxyz", $num, 1);
            $j++;
        }
        return $code;
    }

    /**
     * Helper function to decode html entities.
     *
     * Calls helper function for HTML 4 entity decoding.
     * @link http://www.lazycat.org/software/html_entity_decode_full.phps
     */
    static public function decodeEntities($string, $quotes = ENT_COMPAT, $charset = 'UTF-8')
    {
        return html_entity_decode(preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]+);/', 'self::convertEntity', $string), $quotes, $charset);
    }

    /**
     * Helper function for decodeEntities().
     *
     * This contains the full HTML 4 Recommendation listing of entities, so the default to discard
     * entities not in the table is generally good. Pass false to the second argument to return
     * the faulty entity unmodified, if you're ill or something.
     * @link http://www.lazycat.org/software/html_entity_decode_full.phps
     */
    static public function convertEntity($matches, $destroy = true)
    {
        static $table = array(
            'quot' => '&#34;',
            'amp' => '&#38;',
            'lt' => '&#60;',
            'gt' => '&#62;',
            'OElig' => '&#338;',
            'oelig' => '&#339;',
            'Scaron' => '&#352;',
            'scaron' => '&#353;',
            'Yuml' => '&#376;',
            'circ' => '&#710;',
            'tilde' => '&#732;',
            'ensp' => '&#8194;',
            'emsp' => '&#8195;',
            'thinsp' => '&#8201;',
            'zwnj' => '&#8204;',
            'zwj' => '&#8205;',
            'lrm' => '&#8206;',
            'rlm' => '&#8207;',
            'ndash' => '&#8211;',
            'mdash' => '&#8212;',
            'lsquo' => '&#8216;',
            'rsquo' => '&#8217;',
            'sbquo' => '&#8218;',
            'ldquo' => '&#8220;',
            'rdquo' => '&#8221;',
            'bdquo' => '&#8222;',
            'dagger' => '&#8224;',
            'Dagger' => '&#8225;',
            'permil' => '&#8240;',
            'lsaquo' => '&#8249;',
            'rsaquo' => '&#8250;',
            'euro' => '&#8364;',
            'fnof' => '&#402;',
            'Alpha' => '&#913;',
            'Beta' => '&#914;',
            'Gamma' => '&#915;',
            'Delta' => '&#916;',
            'Epsilon' => '&#917;',
            'Zeta' => '&#918;',
            'Eta' => '&#919;',
            'Theta' => '&#920;',
            'Iota' => '&#921;',
            'Kappa' => '&#922;',
            'Lambda' => '&#923;',
            'Mu' => '&#924;',
            'Nu' => '&#925;',
            'Xi' => '&#926;',
            'Omicron' => '&#927;',
            'Pi' => '&#928;',
            'Rho' => '&#929;',
            'Sigma' => '&#931;',
            'Tau' => '&#932;',
            'Upsilon' => '&#933;',
            'Phi' => '&#934;',
            'Chi' => '&#935;',
            'Psi' => '&#936;',
            'Omega' => '&#937;',
            'alpha' => '&#945;',
            'beta' => '&#946;',
            'gamma' => '&#947;',
            'delta' => '&#948;',
            'epsilon' => '&#949;',
            'zeta' => '&#950;',
            'eta' => '&#951;',
            'theta' => '&#952;',
            'iota' => '&#953;',
            'kappa' => '&#954;',
            'lambda' => '&#955;',
            'mu' => '&#956;',
            'nu' => '&#957;',
            'xi' => '&#958;',
            'omicron' => '&#959;',
            'pi' => '&#960;',
            'rho' => '&#961;',
            'sigmaf' => '&#962;',
            'sigma' => '&#963;',
            'tau' => '&#964;',
            'upsilon' => '&#965;',
            'phi' => '&#966;',
            'chi' => '&#967;',
            'psi' => '&#968;',
            'omega' => '&#969;',
            'thetasym' => '&#977;',
            'upsih' => '&#978;',
            'piv' => '&#982;',
            'bull' => '&#8226;',
            'hellip' => '&#8230;',
            'prime' => '&#8242;',
            'Prime' => '&#8243;',
            'oline' => '&#8254;',
            'frasl' => '&#8260;',
            'weierp' => '&#8472;',
            'image' => '&#8465;',
            'real' => '&#8476;',
            'trade' => '&#8482;',
            'alefsym' => '&#8501;',
            'larr' => '&#8592;',
            'uarr' => '&#8593;',
            'rarr' => '&#8594;',
            'darr' => '&#8595;',
            'harr' => '&#8596;',
            'crarr' => '&#8629;',
            'lArr' => '&#8656;',
            'uArr' => '&#8657;',
            'rArr' => '&#8658;',
            'dArr' => '&#8659;',
            'hArr' => '&#8660;',
            'forall' => '&#8704;',
            'part' => '&#8706;',
            'exist' => '&#8707;',
            'empty' => '&#8709;',
            'nabla' => '&#8711;',
            'isin' => '&#8712;',
            'notin' => '&#8713;',
            'ni' => '&#8715;',
            'prod' => '&#8719;',
            'sum' => '&#8721;',
            'minus' => '&#8722;',
            'lowast' => '&#8727;',
            'radic' => '&#8730;',
            'prop' => '&#8733;',
            'infin' => '&#8734;',
            'ang' => '&#8736;',
            'and' => '&#8743;',
            'or' => '&#8744;',
            'cap' => '&#8745;',
            'cup' => '&#8746;',
            'int' => '&#8747;',
            'there4' => '&#8756;',
            'sim' => '&#8764;',
            'cong' => '&#8773;',
            'asymp' => '&#8776;',
            'ne' => '&#8800;',
            'equiv' => '&#8801;',
            'le' => '&#8804;',
            'ge' => '&#8805;',
            'sub' => '&#8834;',
            'sup' => '&#8835;',
            'nsub' => '&#8836;',
            'sube' => '&#8838;',
            'supe' => '&#8839;',
            'oplus' => '&#8853;',
            'otimes' => '&#8855;',
            'perp' => '&#8869;',
            'sdot' => '&#8901;',
            'lceil' => '&#8968;',
            'rceil' => '&#8969;',
            'lfloor' => '&#8970;',
            'rfloor' => '&#8971;',
            'lang' => '&#9001;',
            'rang' => '&#9002;',
            'loz' => '&#9674;',
            'spades' => '&#9824;',
            'clubs' => '&#9827;',
            'hearts' => '&#9829;',
            'diams' => '&#9830;',
            'nbsp' => '&#160;',
            'iexcl' => '&#161;',
            'cent' => '&#162;',
            'pound' => '&#163;',
            'curren' => '&#164;',
            'yen' => '&#165;',
            'brvbar' => '&#166;',
            'sect' => '&#167;',
            'uml' => '&#168;',
            'copy' => '&#169;',
            'ordf' => '&#170;',
            'laquo' => '&#171;',
            'not' => '&#172;',
            'shy' => '&#173;',
            'reg' => '&#174;',
            'macr' => '&#175;',
            'deg' => '&#176;',
            'plusmn' => '&#177;',
            'sup2' => '&#178;',
            'sup3' => '&#179;',
            'acute' => '&#180;',
            'micro' => '&#181;',
            'para' => '&#182;',
            'middot' => '&#183;',
            'cedil' => '&#184;',
            'sup1' => '&#185;',
            'ordm' => '&#186;',
            'raquo' => '&#187;',
            'frac14' => '&#188;',
            'frac12' => '&#189;',
            'frac34' => '&#190;',
            'iquest' => '&#191;',
            'Agrave' => '&#192;',
            'Aacute' => '&#193;',
            'Acirc' => '&#194;',
            'Atilde' => '&#195;',
            'Auml' => '&#196;',
            'Aring' => '&#197;',
            'AElig' => '&#198;',
            'Ccedil' => '&#199;',
            'Egrave' => '&#200;',
            'Eacute' => '&#201;',
            'Ecirc' => '&#202;',
            'Euml' => '&#203;',
            'Igrave' => '&#204;',
            'Iacute' => '&#205;',
            'Icirc' => '&#206;',
            'Iuml' => '&#207;',
            'ETH' => '&#208;',
            'Ntilde' => '&#209;',
            'Ograve' => '&#210;',
            'Oacute' => '&#211;',
            'Ocirc' => '&#212;',
            'Otilde' => '&#213;',
            'Ouml' => '&#214;',
            'times' => '&#215;',
            'Oslash' => '&#216;',
            'Ugrave' => '&#217;',
            'Uacute' => '&#218;',
            'Ucirc' => '&#219;',
            'Uuml' => '&#220;',
            'Yacute' => '&#221;',
            'THORN' => '&#222;',
            'szlig' => '&#223;',
            'agrave' => '&#224;',
            'aacute' => '&#225;',
            'acirc' => '&#226;',
            'atilde' => '&#227;',
            'auml' => '&#228;',
            'aring' => '&#229;',
            'aelig' => '&#230;',
            'ccedil' => '&#231;',
            'egrave' => '&#232;',
            'eacute' => '&#233;',
            'ecirc' => '&#234;',
            'euml' => '&#235;',
            'igrave' => '&#236;',
            'iacute' => '&#237;',
            'icirc' => '&#238;',
            'iuml' => '&#239;',
            'eth' => '&#240;',
            'ntilde' => '&#241;',
            'ograve' => '&#242;',
            'oacute' => '&#243;',
            'ocirc' => '&#244;',
            'otilde' => '&#245;',
            'ouml' => '&#246;',
            'divide' => '&#247;',
            'oslash' => '&#248;',
            'ugrave' => '&#249;',
            'uacute' => '&#250;',
            'ucirc' => '&#251;',
            'uuml' => '&#252;',
            'yacute' => '&#253;',
            'thorn' => '&#254;',
            'yuml' => '&#255;');
        if (isset($table[$matches[1]])) return $table[$matches[1]];
        return $destroy ? '' : $matches[0];
    }

    /**
     * Replaces html entities with ascii near-equivalents.
     *
     * @param string $text
     * @return string
     *
     * @link https://gist.github.com/wam/668025
     */
    static public function htmlEntitiesToText($text)
    {
        static $table = array();
        if (!$table) {
            // 32 through 127 correspond to ascii letters
            for ($i = 32; $i < 127; $i++) {
                $table["&#$i;"] = chr($i);
            }
            // 32 through 99 have alternates with padding
            for ($i = 32; $i < 100; $i++) {
                $table["&#0$i;"] = chr($i);
            }
            $table["&#160;"] = ' '; # non-breaking space
            $table["&#161;"] = '!'; # inverted exclamation mark
            $table["&#162;"] = 'cents'; # cent sign
            $table["&#163;"] = 'pounds'; # pound sign
            $table["&#164;"] = '$'; # currency sign
            $table["&#165;"] = 'yen'; # yen sign
            $table["&#166;"] = '|'; # broken vertical bar
            $table["&#167;"] = 'Ss'; # section sign
            $table["&#168;"] = '``'; # spacing diaeresis - umlaut
            $table["&#169;"] = '(c)'; # copyright sign
            $table["&#170;"] = 'a'; # feminine ordinal indicator
            $table["&#171;"] = '<<'; # left double angle quotes
            $table["&#172;"] = '~'; # not sign
            $table["&#173;"] = '-'; # soft hyphen
            $table["&#174;"] = '(r)'; # registered trade mark sign
            $table["&#175;"] = '-'; # spacing macron - overline
            $table["&nbsp;"] = ' '; # non-breaking space
            $table["&iexcl;"] = '!'; # inverted exclamation mark
            $table["&cent;"] = 'cents'; # cent sign
            $table["&pound;"] = 'pounds'; # pound sign
            $table["&curren;"] = '$'; # currency sign
            $table["&yen;"] = 'yen'; # yen sign
            $table["&brvbar;"] = '|'; # broken vertical bar
            $table["&sect;"] = 'Ss'; # section sign
            $table["&uml;"] = '``'; # spacing diaeresis - umlaut
            $table["&copy;"] = '(c)'; # copyright sign
            $table["&ordf;"] = 'a'; # feminine ordinal indicator
            $table["&laquo;"] = '<<'; # left double angle quotes
            $table["&not;"] = '~'; # not sign
            $table["&shy;"] = '-'; # soft hyphen
            $table["&reg;"] = '(r)'; # registered trade mark sign
            $table["&macr;"] = '-'; # spacing macron - overline
            $table["&#176;"] = 'deg'; # degree sign
            $table["&#177;"] = '+/-'; # plus-or-minus sign
            $table["&#178;"] = '^2'; # superscript two - squared
            $table["&#179;"] = '^3'; # superscript three - cubed
            $table["&#180;"] = '\''; # acute accent - spacing acute
            $table["&#181;"] = 'u'; # micro sign
            $table["&#182;"] = 'par'; # pilcrow sign - paragraph sign
            $table["&#183;"] = '.'; # middle dot - Georgian comma
            $table["&#184;"] = ','; # spacing cedilla
            $table["&#185;"] = '^1'; # superscript one
            $table["&#186;"] = '^o'; # masculine ordinal indicator
            $table["&#187;"] = '>>'; # right double angle quotes
            $table["&#188;"] = '1/4'; # fraction one quarter
            $table["&#189;"] = '1/2'; # fraction one half
            $table["&#190;"] = '3/4'; # fraction three quarters
            $table["&#191;"] = '?'; # inverted question mark
            $table["&deg;"] = 'deg'; # degree sign
            $table["&plusmn;"] = '+/-'; # plus-or-minus sign
            $table["&sup2;"] = '^2';  # superscript two - squared
            $table["&sup3;"] = '^3';  # superscript three - cubed
            $table["&acute;"] = '\'';  # acute accent - spacing acute
            $table["&micro;"] = 'u'; # micro sign
            $table["&para;"] = 'par'; # pilcrow sign - paragraph sign
            $table["&middot;"] = '.'; # middle dot - Georgian comma
            $table["&cedil;"] = ','; # spacing cedilla
            $table["&sup1;"] = '^1';  # superscript one
            $table["&ordm;"] = '^o';  # masculine ordinal indicator
            $table["&raquo;"] = '>>';  # right double angle quotes
            $table["&frac14;"] = '1/4'; # fraction one quarter
            $table["&frac12;"] = '1/2'; # fraction one half
            $table["&frac34;"] = '3/4'; # fraction three quarters
            $table["&iquest;"] = '?'; # inverted question mark
            $table["&#192;"] = 'A'; # latin capital letter A with grave
            $table["&#193;"] = 'A'; # latin capital letter A with acute
            $table["&#194;"] = 'A'; # latin capital letter A with circumflex
            $table["&#195;"] = 'A'; # latin capital letter A with tilde
            $table["&#196;"] = 'A'; # latin capital letter A with diaeresis
            $table["&#197;"] = 'A'; # latin capital letter A with ring above
            $table["&#198;"] = 'AE'; # latin capital letter AE
            $table["&#199;"] = 'C'; # latin capital letter C with cedilla
            $table["&#200;"] = 'E'; # latin capital letter E with grave
            $table["&#201;"] = 'E'; # latin capital letter E with acute
            $table["&#202;"] = 'E'; # latin capital letter E with circumflex
            $table["&#203;"] = 'E'; # latin capital letter E with diaeresis
            $table["&#204;"] = 'I'; # latin capital letter I with grave
            $table["&#205;"] = 'I'; # latin capital letter I with acute
            $table["&#206;"] = 'I'; # latin capital letter I with circumflex
            $table["&#207;"] = 'I'; # latin capital letter I with diaeresis
            $table["&Agrave;"] = 'A'; # latin capital letter A with grave
            $table["&Aacute;"] = 'A'; # latin capital letter A with acute
            $table["&Acirc;"] = 'A'; # latin capital letter A with circumflex
            $table["&Atilde;"] = 'A'; # latin capital letter A with tilde
            $table["&Auml;"] = 'A'; # latin capital letter A with diaeresis
            $table["&Aring;"] = 'A'; # latin capital letter A with ring above
            $table["&AElig;"] = 'AE'; # latin capital letter AE
            $table["&Ccedil;"] = 'C'; # latin capital letter C with cedilla
            $table["&Egrave;"] = 'E'; # latin capital letter E with grave
            $table["&Eacute;"] = 'E'; # latin capital letter E with acute
            $table["&Ecirc;"] = 'E'; # latin capital letter E with circumflex
            $table["&Euml;"] = 'E'; # latin capital letter E with diaeresis
            $table["&Igrave;"] = 'I'; # latin capital letter I with grave
            $table["&Iacute;"] = 'I'; # latin capital letter I with acute
            $table["&Icirc;"] = 'I'; # latin capital letter I with circumflex
            $table["&Iuml;"] = 'I'; # latin capital letter I with diaeresis
            $table["&#208;"] = 'EDH'; # latin capital letter ETH
            $table["&#209;"] = 'N'; # latin capital letter N with tilde
            $table["&#210;"] = 'O'; # latin capital letter O with grave
            $table["&#211;"] = 'O'; # latin capital letter O with acute
            $table["&#212;"] = 'O'; # latin capital letter O with circumflex
            $table["&#213;"] = 'O'; # latin capital letter O with tilde
            $table["&#214;"] = 'O'; # latin capital letter O with diaeresis
            $table["&#215;"] = 'x'; # multiplication sign
            $table["&#216;"] = '0'; # latin capital letter O with slash
            $table["&#217;"] = 'U'; # latin capital letter U with grave
            $table["&#218;"] = 'U'; # latin capital letter U with acute
            $table["&#219;"] = 'U'; # latin capital letter U with circumflex
            $table["&#220;"] = 'U'; # latin capital letter U with diaeresis
            $table["&#221;"] = 'Y'; # latin capital letter Y with acute
            $table["&#222;"] = 'dh'; # latin capital letter THORN
            $table["&#223;"] = 'th'; # latin small letter sharp s - ess-zed
            $table["&ETH;"] = 'EDH'; # latin capital letter ETH
            $table["&Ntilde;"] = 'N';  # latin capital letter N with tilde
            $table["&Ograve;"] = 'O';  # latin capital letter O with grave
            $table["&Oacute;"] = 'O';  # latin capital letter O with acute
            $table["&Ocirc;"] = 'O';  # latin capital letter O with circumflex
            $table["&Otilde;"] = 'O';  # latin capital letter O with tilde
            $table["&Ouml;"] = 'O';  # latin capital letter O with diaeresis
            $table["&times;"] = 'x';  # multiplication sign
            $table["&Oslash;"] = 'O';  # latin capital letter O with slash
            $table["&Ugrave;"] = 'U';  # latin capital letter U with grave
            $table["&Uacute;"] = 'U';  # latin capital letter U with acute
            $table["&Ucirc;"] = 'U';  # latin capital letter U with circumflex
            $table["&Uuml;"] = 'U';  # latin capital letter U with diaeresis
            $table["&Yacute;"] = 'Y';  # latin capital letter Y with acute
            $table["&THORN;"] = 'dh'; # latin capital letter THORN
            $table["&szlig;"] = 'th'; # latin small letter sharp s - ess-zed
            $table["&#224;"] = 'a'; # latin small letter a with grave
            $table["&#225;"] = 'a'; # latin small letter a with acute
            $table["&#226;"] = 'a'; # latin small letter a with circumflex
            $table["&#227;"] = 'a'; # latin small letter a with tilde
            $table["&#228;"] = 'a'; # latin small letter a with diaeresis
            $table["&#229;"] = 'a'; # latin small letter a with ring above
            $table["&#230;"] = 'ae'; # latin small letter ae
            $table["&#231;"] = 'c'; # latin small letter c with cedilla
            $table["&#232;"] = 'e'; # latin small letter e with grave
            $table["&#233;"] = 'e'; # latin small letter e with acute
            $table["&#234;"] = 'e'; # latin small letter e with circumflex
            $table["&#235;"] = 'e'; # latin small letter e with diaeresis
            $table["&#236;"] = 'i'; # latin small letter i with grave
            $table["&#237;"] = 'i'; # latin small letter i with acute
            $table["&#238;"] = 'i'; # latin small letter i with circumflex
            $table["&#239;"] = 'i'; # latin small letter i with diaeresis
            $table["&agrave;"] = 'a';  # latin small letter a with grave
            $table["&aacute;"] = 'a';  # latin small letter a with acute
            $table["&acirc;"] = 'a';  # latin small letter a with circumflex
            $table["&atilde;"] = 'a';  # latin small letter a with tilde
            $table["&auml;"] = 'a';  # latin small letter a with diaeresis
            $table["&aring;"] = 'a';  # latin small letter a with ring above
            $table["&aelig;"] = 'ae'; # latin small letter ae
            $table["&ccedil;"] = 'c';  # latin small letter c with cedilla
            $table["&egrave;"] = 'e';  # latin small letter e with grave
            $table["&eacute;"] = 'e';  # latin small letter e with acute
            $table["&ecirc;"] = 'e';  # latin small letter e with circumflex
            $table["&euml;"] = 'e';  # latin small letter e with diaeresis
            $table["&igrave;"] = 'i';  # latin small letter i with grave
            $table["&iacute;"] = 'i';  # latin small letter i with acute
            $table["&icirc;"] = 'i';  # latin small letter i with circumflex
            $table["&iuml;"] = 'i';  # latin small letter i with diaeresis
            $table["&#240;"] = 'edh'; # latin small letter eth
            $table["&#241;"] = 'n'; # latin small letter n with tilde
            $table["&#242;"] = 'o'; # latin small letter o with grave
            $table["&#243;"] = 'o'; # latin small letter o with acute
            $table["&#244;"] = 'o'; # latin small letter o with circumflex
            $table["&#245;"] = 'o'; # latin small letter o with tilde
            $table["&#246;"] = 'o'; # latin small letter o with diaeresis
            $table["&#247;"] = '/'; # division sign
            $table["&#248;"] = 'o'; # latin small letter o with slash
            $table["&#249;"] = 'u'; # latin small letter u with grave
            $table["&#250;"] = 'u'; # latin small letter u with acute
            $table["&#251;"] = 'u'; # latin small letter u with circumflex
            $table["&#252;"] = 'u'; # latin small letter u with diaeresis
            $table["&#253;"] = 'y'; # latin small letter y with acute
            $table["&#254;"] = 'th'; # latin small letter thorn
            $table["&#255;"] = 'y'; # latin small letter y with diaeresis
            $table["&eth;"] = 'edh'; # latin small letter eth
            $table["&ntilde;"] = 'n';  # latin small letter n with tilde
            $table["&ograve;"] = 'o';  # latin small letter o with grave
            $table["&oacute;"] = 'o';  # latin small letter o with acute
            $table["&ocirc;"] = 'o';  # latin small letter o with circumflex
            $table["&otilde;"] = 'o';  # latin small letter o with tilde
            $table["&ouml;"] = 'o';  # latin small letter o with diaeresis
            $table["&divide;"] = '/';  # division sign
            $table["&oslash;"] = 'o';  # latin small letter o with slash
            $table["&ugrave;"] = 'u';  # latin small letter u with grave
            $table["&uacute;"] = 'u';  # latin small letter u with acute
            $table["&ucirc;"] = 'u';  # latin small letter u with circumflex
            $table["&uuml;"] = 'u';  # latin small letter u with diaeresis
            $table["&yacute;"] = 'y';  # latin small letter y with acute
            $table["&thorn;"] = 'th'; # latin small letter thorn
            $table["&yuml;"] = 'y';  # latin small letter y with diaeresis
            $table["&#338;"] = 'OE'; # latin capital letter OE
            $table["&#339;"] = 'oe'; # latin small letter oe
            $table["&#352;"] = 'S'; # latin capital letter S with caron
            $table["&#353;"] = 's'; # latin small letter s with caron
            $table["&#376;"] = 'U'; # latin capital letter Y with diaeresis
            $table["&#402;"] = 'f'; # latin small f with hook - function
            $table["&#8194;"] = ' '; # en space
            $table["&#8195;"] = ' '; # em space
            $table["&#8201;"] = ' '; # thin space
            $table["&#8204;"] = ''; # zero width non-joiner,
            $table["&#8205;"] = ''; # zero width joiner
            $table["&#8206;"] = ''; # left-to-right mark
            $table["&#8207;"] = ''; # right-to-left mark
            $table["&#8211;"] = '-'; # en dash
            $table["&#8212;"] = '--'; # em dash
            $table["&#8216;"] = '\''; # left single quotation mark,
            $table["&#8217;"] = '\''; # right single quotation mark,
            $table["&#8218;"] = '"'; # single low-9 quotation mark
            $table["&#8220;"] = '"'; # left double quotation mark,
            $table["&#8221;"] = '"'; # right double quotation mark,
            $table["&#8222;"] = ',,'; # double low-9 quotation mark
            $table["&#8224;"] = '*'; # dagger
            $table["&#8225;"] = '**'; # double dagger
            $table["&#8226;"] = '*'; # bullet
            $table["&#8230;"] = '...'; # horizontal ellipsis
            $table["&#8240;"] = '0/00'; # per mille sign
            $table["&#8249;"] = '<'; # single left-pointing angle quotation mark,
            $table["&#8250;"] = '>'; # single right-pointing angle quotation mark,
            $table["&#8364;"] = 'euro'; # euro sign
            $table["&euro;"] = 'euro'; # euro sign
            $table["&#8482;"] = '(TM)'; # trade mark sign
            $table["&amp;"] = '&'; # ampersand
            $table["&nbsp;"] = ' '; # non-breaking space
            $table["&quot;"] = '"'; # quotation mark
            $table["&mdash;"] = '-'; # em dash
            $table["&trade;"] = '(TM)';
            $table["&trade;"] = '(TM)';
            $table["&bull;"] = '*';

        }
        return strtr($text, $table);
    }

    /**
     * @param string $json
     * @return string
     */
    static public function prettyJson($json)
    {
        $result = '';
        $level = 0;
        $prev_char = '';
        $in_quotes = false;
        $ends_line_level = NULL;
        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if ($ends_line_level !== NULL) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ($char === '"' && $prev_char != '\\') {
                $in_quotes = !$in_quotes;
            }
            else if (!$in_quotes) {
                switch ($char) {
                    case '}':
                    case ']':
                        $level--;
                        $ends_line_level = NULL;
                        $new_line_level = $level;
                        break;

                    case '{':
                    case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ":
                    case "\t":
                    case "\n":
                    case "\r":
                        $char = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level = NULL;
                        break;
                }
            }
            if ($new_line_level !== NULL) {
                $result .= "\n" . str_repeat("\t", $new_line_level);
            }
            $result .= $char . $post;
            $prev_char = $char;
        }

        return $result;
    }

    /**
     * @param $str
     * @param int $width
     * @param string $break
     * @param bool $cut
     * @return string
     */
    static public function wordwrap($str, $width = 75, $break = "\n", $cut = false)
    {
        $lines = explode($break, $str);
        foreach ($lines as &$line) {
            $line = rtrim($line);
            if (mb_strlen($line) <= $width)
                continue;
            $words = explode(' ', $line);
            $line = '';
            $actual = '';
            foreach ($words as $word) {
                if (mb_strlen($actual . $word) <= $width)
                    $actual .= $word . ' ';
                else {
                    if ($actual != '')
                        $line .= rtrim($actual) . $break;
                    $actual = $word;
                    if ($cut) {
                        while (mb_strlen($actual) > $width) {
                            $line .= mb_substr($actual, 0, $width) . $break;
                            $actual = mb_substr($actual, $width);
                        }
                    }
                    $actual .= ' ';
                }
            }
            $line .= trim($actual);
        }
        return implode($break, $lines);
    }

}