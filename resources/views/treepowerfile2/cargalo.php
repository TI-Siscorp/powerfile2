<?php
   @session_start();
   
    //echo $_SESSION['tablaid']; 
	$servername = "localhost";
	$username = "root";
	$password = "desarrollo1";
	$dbname = "powerfile2";
	@$tablaid = @$_REQUEST['tablaid'];
	$conn = mysql_connect($servername, $username, $password, true, 65536) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db($dbname,$conn);
	
	date_default_timezone_set('America/Bogota');
if(isset($_GET['operation'])) {
  try {
    $result = null;
    
      switch($_GET['operation']) {
			case 'analyze':
				var_dump($fs->analyze(true));
				die();
			break;
			case 'get_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$sql = "SELECT * FROM sgd_folders where id_tabla = ".$tablaid;
				$res = mysql_query($sql,$conn);
				$numreg = mysql_num_rows($res);
			
						  //iterate on results row and create new index array of data
						  while( $row = mysql_fetch_assoc($res) ) { 
							$data[] = $row;
						  }
						  $itemsByReference = array();
		
						// Build array of item references:
						foreach($data as $key => &$item) {
						   $itemsByReference[$item['id']] = &$item;
						   // Children array:
						   $itemsByReference[$item['id']]['children'] = array();
						   // Empty data class (so that json_encode adds "data: {}" ) 
						   $itemsByReference[$item['id']]['data'] = new StdClass();
						}
		
						// Set items as children of the relevant parent item.
						foreach($data as $key => &$item)
						   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
							$itemsByReference [$item['parent_id']]['children'][] = &$item;
		
						// Remove items that were added to parents elsewhere:
						foreach($data as $key => &$item) {
						   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
							unset($data[$key]);
						}
						$result = $data;
					
			break;
				
			case 'get_content':
				/*$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
				$node = explode(':', $node);
				if(count($node) > 1) {
					$rslt = array('content' => 'Multiple selected');
				}
				else {
					$temp = $fs->get_node((int)$node[0], array('with_path' => true));
					$rslt = array('content' => 'Selected: /' . implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])). '/'.$temp['nm']);
				}*/
				break;
			case 'create_node':
				
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
        
				$nodeText = isset($_GET['text']) && $_GET['text'] !== '' ? $_GET['text'] : '';			
				
				$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$nodeText."', '".$nodeText."', '".$node."',1,".$tablaid.",'".date("Y-m-d H:i:s")."')";
				
				mysql_query($sql,$conn);
				
				$result = array('id' => mysql_insert_id($conn));
				
			break;
			case 'rename_node':
			
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				
				$nodeText = isset($_GET['text']) && $_GET['text'] !== '' ? $_GET['text'] : '';
				
				$sql ="UPDATE sgd_folders SET nombre ='".$nodeText."',text = '".$nodeText."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = '".$node."'";
				
				mysql_query($sql,$conn);
				
				break;
				
			case 'delete_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				
				$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$node."'";
				
				mysql_query($sql,$conn);
				
				$sql ="DELETE FROM sgd_folders WHERE id = '".$node."'";
				
				mysql_query($sql,$conn);
				
				break;
				
			 case 'guardatipodoc':			 		
			 	  
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
				
				$id_tipodoc = isset($_GET['id_tipodoc']) && $_GET['id_tipodoc'] !== '' ? $_GET['id_tipodoc'] : ''; 
				
				//se eliminan las relacion previas de esa carpeta
				
				$sql ="DELETE FROM sgd_folders_tipodocs WHERE id_folder = ".$node;   
				
				mysql_query($sql,$conn);
				
				//se registran las relaciones de esa carpeta con los tipos documentales q se le asignaron
				
				$id_tipodoc = explode(',',$id_tipodoc);
				
				for ($i = 0; $i < count($id_tipodoc); $i++) {
					
					$sql ="INSERT INTO sgd_folders_tipodocs (id_folder, id_tipodoc,created_at) VALUES(".$node.", ".$id_tipodoc[$i].", '".date("Y-m-d H:i:s")."')"; 
					
					mysql_query($sql,$conn);
					
				}
				break;
			
			case 'move_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
				
				$sql ="UPDATE sgd_folders SET parent_id ='".$parn."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = '".$node."'";
				
				mysql_query($sql,$conn);
				
				break;
			case 'copy_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
				
				//se buscan los datos
				
				$sql = "SELECT * FROM sgd_folders where id = ".$node;
				
				$resf = mysql_query($sql,$conn);
				
				$rowf = mysql_fetch_assoc($resf);
								
				$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$rowf['nombre']."', '".$rowf['nombre']."', '".$parn."',".$rowf['id_estado'].",".$rowf['id_tabla'].",'".date("Y-m-d H:i:s")."')";
				
				mysql_query($sql,$conn);
				
				break;
			default:
				throw new Exception('Unsupported operation: ' . $_GET['operation']);
				break;
		
      default:
			throw new Exception('No se puede realizar la operación: ' . $_GET['operation']);
        break;
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result);
  }
  catch (Exception $e) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
    header('Status:  500 Server Error');
    echo $e->getMessage();
  }
  die();
}


if(isset($_GET['otraoperation'])) {
	try {
		$result = null;

		switch($_GET['otraoperation']) {
			case 'damedocumentales':
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
			
				$sql =" select id_tipodoc from sgd_folders_tipodocs where id_folder = ".$node;
			
				$queryids =  mysql_query($sql,$conn);
			
				$idstp = '';
			
				while($campo2 = mysql_fetch_array($queryids))
				{
					$idstp .= $campo2['id_tipodoc'].'_;_';
				}
				echo  $idstp;
			break;
		}
	}
		catch (Exception $e) {
			header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
			header('Status:  500 Server Error');
			echo $e->getMessage();
	}
	die();
}
	
	
	$sql = "SELECT * FROM sgd_folders ";
	$res = mysql_query($sql,$conn) or die("database error:". mysql_error($conn));
	//iterate on results row and create new index array of data
	while( $row = mysql_fetch_assoc($res) ) {
		$data[] = $row;
	}
	
	//print_r($data);
	$itemsByReference = array();
	
	// Build array of item references:
	foreach($data as $key => &$item) {
		$itemsByReference[$item['id']] = &$item;
		// Children array:
		$itemsByReference[$item['id']]['children'] = array();
		// Empty data class (so that json_encode adds "data: {}" )
		$itemsByReference[$item['id']]['data'] = new StdClass();
	}
	
	// Set items as children of the relevant parent item.
	foreach($data as $key => &$item)
		if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
			$itemsByReference [$item['parent_id']]['children'][] = &$item;
	
			// Remove items that were added to parents elsewhere:
			foreach($data as $key => &$item) {
				if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
					unset($data[$key]);
			}
			// Encode:
			echo json_encode($data);
?>