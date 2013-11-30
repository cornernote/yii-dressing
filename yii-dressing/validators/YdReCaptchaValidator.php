<?php
/**
 * YdReCaptchaValidator class file.
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
 * ReCaptchaValidator validates that the attribute value is the same as the verification code displayed in the CAPTCHA.
 * The CAPTCHA is provided by reCAPTCHA {@link http://recaptcha.net/}. See LICENCE.txt for the terms of use for this service.
 *
 * ReCaptchaValidator should be used together with {@link ReCaptcha}.
 *
 * @author MetaYii
 *
 * @package dressing.validators
 */
class YdReCaptchaValidator extends CValidator
{

    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param $object CModel the object being validated
     * @param $attribute string the attribute being validated
     */
    protected function validateAttribute($object, $attribute)
    {
        if (!$this->checkAnswer($_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'])) {
            $message = $this->message !== null ? $this->message : Yii::t('dressing', 'The verification code is incorrect.');
            $this->addError($object, $attribute, $message);
        }
    }

    /**
     * Calls an HTTP POST function to verify if the user's guess was correct
     * @param string $challenge
     * @param string $response
     * @param array $extra_params an array of extra variables to post to the server
     * @return bool
     */
    protected function checkAnswer($challenge, $response, $extra_params = array())
    {
        $reCaptcha = Yii::app()->reCaptcha;
        if (!$challenge || !$response)
            return false;

        $response = $this->httpPost($reCaptcha->verifyServer, '/recaptcha/api/verify', array(
                'privatekey' => $reCaptcha->privateKey,
                'remoteip' => $_SERVER['REMOTE_ADDR'],
                'challenge' => $challenge,
                'response' => $response
            ) + $extra_params);

        $answers = explode("\n", $response [1]);
        if (trim($answers[0]) != 'true') {
            return false;
        }
        return true;
    }

    /**
     * Submits an HTTP POST to a reCAPTCHA server
     * @param string $host
     * @param string $path
     * @param array $data
     * @param int $port
     * @return array response
     */
    function httpPost($host, $path, $data, $port = 80)
    {

        $req = $this->qsEncode($data);

        $http_request = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($req) . "\r\n";
        $http_request .= "User-Agent: reCAPTCHA/PHP\r\n";
        $http_request .= "\r\n";
        $http_request .= $req;

        $response = '';
        if (false == ($fs = @fsockopen($host, $port, $errno, $errstr, 10))) {
            die ('Could not open socket to ' . $host . ' on port ' . $port);
        }

        fwrite($fs, $http_request);

        while (!feof($fs))
            $response .= fgets($fs, 1160); // One TCP-IP packet
        fclose($fs);
        $response = explode("\r\n\r\n", $response, 2);

        return $response;
    }

    /**
     * Encodes the given data into a query string format
     * @param $data - array of string elements to be encoded
     * @return string - encoded request
     */
    protected function qsEncode($data)
    {
        $req = "";
        foreach ($data as $key => $value)
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';

        // Cut the last '&'
        $req = substr($req, 0, strlen($req) - 1);
        return $req;
    }

}