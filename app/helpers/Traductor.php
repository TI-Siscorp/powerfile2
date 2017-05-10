<?php

namespace App\helpers;

 

class Traductor
{
	
	public static  function traduce($codigo)
		{
			@session_start();
			
			$espanol = array('td01' => 'Ver perfil',
							'td02' => 'Ver Notificaciones',
							'td03' => 'Cerrar Sesi&oacute;n',
							'td04' => 'Mi Cuenta',
							'td05' => 'Idiomas',
							'td06' => 'Espa&ntilde;ol',
							'td07' => 'Ingles',
							'td08' => 'Inicio',
							'td09' => 'Administraci&oacute;n',
							'td10' => 'Permisos',
							'td11' => 'Roles',
							'td12' => 'Usuarios',
							'td13' => 'Grupos',
							'td14' => 'Configuraci&oacute;n',
							'td15' => '&Iacute;ndices',
							'td16' => 'Tipo Documental',
							'td17' => 'Tablas',
							'td18' => 'Dependencias',
							'td19' => 'Sistema',
							'td20' => 'Logos',
							'td21' => 'Pantalla Completa',
							'td22' => 'Nuevo Expediente',
							'td23' => 'Ver Expedientes',
							'td24' => 'Modo Muro',
 	
			);
			
			
			$ingles = array('td01' => 'View profile',
							'td02' => 'View Notifications',
							'td03' => 'Sign off',
							'td04' => 'My Account',
							'td05' => 'Languages',
							'td06' => 'Spanish',
							'td07' => 'English',
							'td08' => 'Home',
							'td09' => 'Administration',
							'td10' => 'Permissions',
							'td11' => 'Roles',
							'td12' => 'Users',
							'td13' => 'Groups',
							'td14' => 'configuration',
							'td15' => 'Index',
							'td16' => 'Type of Documentary',
							'td17' => 'Boards',
							'td18' => 'Outbuildings',
							'td19' => 'System',
							'td20' => 'Logos',
							'td21' => 'Fullscreen',
							'td22' => 'New Record',
							'td23' => 'View Records',
							'td24' => 'Modo Muro',
					
			
			);
		
			switch ($_SESSION['lenguaje']) {
				case 'es':
					return $espanol[$codigo];
				break;	
				case 'en':
					return $ingles[$codigo];
				break;
			}	
		}
	
	
	
	
}