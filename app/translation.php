<?php
session_start();
/*
 |--------------------------------------------------------------------------
| Translations
|--------------------------------------------------------------------------
|
| This script gets the locale of user and load the appropriate file
| that contain the translations.
|
| English File: /app/lang/en/{section}.php
| Spanish File: /app/lang/es/{section}.php
|
|
|
*/

// Set locales allowed.

$localesAllowed = array('es', 'en');

if ($_SESSION['lenguaje'] == '')
	{
		$_SESSION['lenguaje'] = 'es';
	}
