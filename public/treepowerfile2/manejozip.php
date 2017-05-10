 <?php
class Zip_manager{
	function Zip_manager(){}
	function listar($input){
		/*
		Lista de los archivos que contiene un paquete zip.
		$input: archivo zip que se va a listar
		*/
		$entries = array();
		$zip = zip_open($input);
		if (!is_resource($zip)){
		echo $this->zipFileErrMsg($zip);
		die ("No se puede leer el archivo zip. Error:".$zip);
		}
		else{
		while ($entry = zip_read($zip)){
		$entries[] = zip_entry_name($entry);
		}
		}
		zip_close($zip);
		return $entries;
	}
	function extraer($input, $destino){
		/*
		Descomprime un paquete zip en un directorio especifico
		$input: archivo zip a descomprimir
		$destino: carpeta donde se descomprime
		*/
		$zip = new ZipArchive;
		if ($zip->open($input) === TRUE) {
		$zip->extractTo($destino);
		$zip->close();
		return true;
		} else {
		return false;
		}
	}
}
?>


<?php
/*//Para utilizar esta clase deberíamos escribir un código como el siguiente:
$zip_manager = new Zip_manager();
$archivo_zip = "prueba1.zip";
$listado = $zip_manager->listar($archivo_zip);
print_r($listado);
$resultado = $zip_manager->extraer($archivo_zip, "carpeta_temporal");
if (!$resultado){
echo "Error: no se ha podido extraer el archivo";
}
else{
echo "Archivo extraido con exito";
}*/
?>