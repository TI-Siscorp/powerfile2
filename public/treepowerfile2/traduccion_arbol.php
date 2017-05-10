<?php

class Traduccion_arbol
{

	function traduce($codigo)
		{
			@session_start();
				
			$espanol = array('nestruct' => 'Estructura',
					'ntpdoc' => 'Tipos Documentales',
					'nindice' => 'Indices',
					'cnnode' => 'Crear Nuevo', 
					'ceditnode' => 'Editar',
					'cenode' => 'Elmiminar', 
					'ctpdocnode' => 'Tipos Documentales de',  
					'cnodebuscar' => 'Buscar...',
					'cnodeindice' => 'Indices de ',
					'cnodeguardar' => 'Guardar ',
					'cnodecancela' => 'Cancelar ',
					'cnodeindn' => 'Indices de',	
					'cnodedoc' => 'documentales',
					'cnodevalorn' => 'Ingrese el valor de',
					'titdoc' => 'Documentos de',
					'titdocnum' => 'Documentos ',
					'titimage' => 'Imagenes',
					'titnodoc' => 'No posee Documentos', 
					'chkordenar' => 'Ordenar',
					'chktitordenar' => 'Permitir Ordenar las Imagenes',
					'vistapdf' => 'Ver como pdf',
					'titvagrimg' => 'Agregar Imagenes a ',
					'ladocerrar' => 'Cerrar',
					'inputusu' => 'Usuarios',
					'exitopermi' => 'se registro con exito',
					'limpiapermi' => 'se Limpio con exito',
					'titirdoc' => 'Ir a Documento...',
					'traddescargartodo' => 'Descargar Todo',
					'titinotificaa' => 'Notificar a',
					
			);
			
			
			$ingles = array('nestruct' => 'Structure',
					'ntpdoc' => 'Document Type',
					'nindice' => 'Index',
					'cnnode' => 'New',
					'ceditnode' => 'Edit',
					'cenode' => 'Delete',
					'ctpdocnode' => 'Document Type of',
					'cnodebuscar' => 'Search...',
					'cnodeindice' => 'Index of ',
					'cnodeguardar' => 'Save ',
					'cnodecancela' => 'Cancel ', 
					'cnodedoc' => 'Documentaries',
					'cnodevalorn' => 'Enter the value of',
					'titdoc' => 'Documents of',
					'titdocnum' => 'Documents ',
					'titimage' => 'Images',
					'titnodoc' => 'Does not have Documents',
					'chkordenar' => 'Sort',
					'chktitordenar' => 'Allow Sort Images',
					'vistapdf' => 'View as pdf',
					'titvagrimg' => 'Add Images to ',
					'ladocerrar' => 'Close',
					'inputusu' => 'Users',
					'exitopermi' => 'Was successfully registered',
					'limpiapermi' => 'I cleaned successfully',
					'titirdoc' => 'Go to document...',
					'traddescargartodo' => 'Download All',
					'titimigesti' => 'Management file',
					'titinotificaa' => 'Notify the',
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