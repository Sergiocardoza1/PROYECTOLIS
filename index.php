<?php
/**
 *  
 * @package	
 * @author	
 * @copyright	 (https://ellislab.com/)
 * @copyright	 (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	
 * @link	https://codeigniter.com
 * @since	
 * @filesource
 */

 
	define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

 
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('Error 503.', TRUE, 503);
		echo 'El entorno de la aplicación no está configurado correctamente';
		exit(1); 
}

 
	$system_path = 'system';

 
	$application_folder = 'application';

 
	$view_folder = '';

 
 
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
	 
		$system_path = strtr(
			rtrim($system_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		).DIRECTORY_SEPARATOR;
	}

	 
	if ( ! is_dir($system_path))
	{
		header(' 503 Servicio No Disponible.', TRUE, 503);
		echo 'La ruta de la carpeta de su sistema no parece estar configurada correctamente. Abra el siguiente archivo y corrija esto '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3);  
	}

 
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	 
	define('BASEPATH', $system_path);

	 
	define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

	 
	define('SYSDIR', basename(BASEPATH));

	 
	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}
		else
		{
			$application_folder = strtr(
				rtrim($application_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
	{
		$application_folder = BASEPATH.strtr(
			trim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header(' 503 Servicio no disponible', TRUE, 503);
		echo 'La ruta de la carpeta de su aplicación no parece estar configurada correctamente. Abra el siguiente archivo y corrija esto '.SELF;
		exit(3);  
	}

	define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
 
	if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.'views';
	}
	elseif (is_dir($view_folder))
	{
		if (($_temp = realpath($view_folder)) !== FALSE)
		{
			$view_folder = $_temp;
		}
		else
		{
			$view_folder = strtr(
				rtrim($view_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.strtr(
			trim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('503 Servicio no disponible.', TRUE, 503);
		echo 'La ruta de la carpeta de visualización no parece estar configurada correctamente. Abra el siguiente archivo y corrija esto '.SELF;
		exit(3); 
	}

	define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

 
require_once BASEPATH.'core/CodeIgniter.php';
