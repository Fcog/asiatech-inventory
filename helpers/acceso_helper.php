<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('acceso'))
{
		// if $grupo=NULL => acceso a todos
    function acceso($grupo=NULL)
    {
			if (!isset($_SESSION['usuario']['nombre']))
				redirect('log_user');
			else if ($grupo != NULL && $_SESSION['usuario']['acceso'] != $grupo && $_SESSION['usuario']['acceso'] != 'superadmin')
				redirect('log_user/no_autorizado');
    }   		
}

if ( ! function_exists('permiso'))
{
    function permiso($grupo)
    {
			if ($_SESSION['usuario']['acceso'] != $grupo && $_SESSION['usuario']['acceso'] != 'superadmin')
				return false;
			else
				return true;
    }   		
}

?>