<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('token'))
{
    function token()
    {
			$token = md5(uniqid(rand(), TRUE));
			$_SESSION['token'] = $token;
      return '<input type="hidden" name="token" id="token" value="'.$token.'" />';
    }   
}

?>