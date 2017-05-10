<?php
 
namespace App\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use Session;

class Util
{ 
	public static  function conocepermisos($v)
		{
			$user = Auth::user(); 
			
			$usuarios = $user->id; //Usuario::find(Session::get('id_usuario'));
			
			$idusu = $user->id_rol;
			
			$registroper = DB::select("select pr.id_permiso_rol,pr.value from sgd_permiso_rols pr, sgd_permisos p  where p.id_permiso = pr.id_permiso and pr.id_rol = ".$idusu." and pr.value = 1 and llave = '".$v."'");	
			
			
			if (count($registroper) > 0)
				{
					return true;
				}
			else 
				{
					return false;
				}
		}
	
		
		
	public static function contardocumentos($id_expediente){
			
		$regisdocum = DB::select("select count(id_documento) as tdoc from sgd_documentos where id_expediente = ".$id_expediente);
		
			return $regisdocum[0]->tdoc;
		
		}
	public static function contarimagenes($id_expediente){
			
		$regisdocum = DB::select("select count(i.id_imagendocum) as timg from sgd_imagen_documento i, sgd_documentos d where i.id_documento = d.id_documento and d.id_expediente = ".$id_expediente);
	
		return $regisdocum[0]->timg;
	
	}
		
	public static function listadocumental($id_documento){  
			
		$regisdocum = DB::select("select distinct tp.id_tipodoc,tp.nombre,tp.color from sgd_documentos d,sgd_tipodocumentales tp where d.id_tipodocumental = tp.id_tipodoc and d.id_documento = ".$id_documento);
	
		if (count($regisdocum) > 0)
			{
				unset($vidtp);
				unset($vnomtp);
				unset($vcolortp);
				foreach($regisdocum as $dato)
				{
					$vidtp[] = $dato->id_tipodoc;
					$vnomtp[] = $dato->nombre;
					$vcolortp[] = $dato->color;
				}
				return json_encode($vidtp).'_;_'.json_encode($vnomtp).'_;_'.json_encode($vcolortp) ;
			}
			else
			{
				return false;
			}
		
	}
	
	public static function listaindices($id_tipodoc){
			
		$regisdocum = DB::select("select distinct i.nombre,i.id_indice from sgd_indices i,sgd_tipodoc_indices tp,sgd_valorindice iv where i.id_indice = tp.id_indice and tp.id_tipodoc = ".$id_tipodoc);
	
		if (count($regisdocum) > 0)
			{
				unset($vidin);
				unset($vnomin);
				//unset($vdatoind);
				foreach($regisdocum as $dato)
					{
						//buscamos el dato dentro del indice
						
						$vidin[] = $dato->id_indice;
						$vnomin[] = $dato->nombre;
						
					}
				return json_encode($vidin).'_;_'.json_encode($vnomin);
			}
		else
			{
				return false;
			}
	
	}
	public static function contarimagenestp($id_tp,$id_expediente){
			
		$regisdocum = DB::select("select count(i.id_imagendocum) as timg from sgd_imagen_documento i, sgd_documentos d where i.id_documento = d.id_documento and d.id_expediente = ".$id_expediente." and i.id_documento = ".$id_tp);
	
		return $regisdocum[0]->timg;
	
	}
	public static function listadoindices($id_documento,$id_expediente){
		//buscamos LOS INDICES del documentos
		$regisindices = DB::select("select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$id_documento);
		
		if (count($regisindices) > 0)
			{
				unset($vidindi);
				unset($vnomindi);
				unset($vvalindi);
				foreach($regisindices as $dato)
				{
					//buscamos el dato dentro del indice
					$vidindi[] = $dato->id_indice; 
					$vnomindi[] = $dato->nombre;
					$vvalindi[] = $dato->valor;
			
				}
				return json_encode($vnomindi).'_;_'.json_encode($vvalindi).'_;_'.json_encode($vidindi);
			}
		else
			{
				return false;
			}
		
	}
	public static function traeriddocumental($id_documento){
			
		$registpdoc = DB::select("select id_tipodocumental from sgd_documentos  where id_documento = ".$id_documento);
	
		return $registpdoc[0]->id_tipodocumental;	
	}
	public static function traerdocumental($id_tipodocumental){
			
		$registpdoc = DB::select("select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$id_tipodocumental);
	
		return $registpdoc[0]->nombre;
	}
	
	
	public static function datoscadena($id_documento){
			
		$registpdoc = DB::select("select e.nombre as nexpediente,f.nombre as nfolder,tp.nombre as ntpdoc  from sgd_documentos d, sgd_expedientes e,sgd_folders f,sgd_tipodocumentales tp where e.id_expediente = d.id_expediente and f.id = d.id_folder and tp.id_tipodoc = d.id_tipodocumental and  d.id_documento = ".$id_documento);
	
		return $registpdoc[0]->nexpediente." - ".$registpdoc[0]->nfolder." - ".$registpdoc[0]->ntpdoc;
	
	}
	
	public static function datoexpedienteid($id_documento){
			
		$regisexpediente = DB::select("select id_expediente from sgd_documentos where id_documento = ".$id_documento);
	
		return $regisexpediente[0]->id_expediente;
	
	}
	
	public static function datotablaid($id_documento,$iddelexp){
			
		$registablaid = DB::select("select id_tabla from sgd_documentos where id_documento = ".$id_documento." and id_expediente = ".$iddelexp);
	
		return $registablaid[0]->id_tabla;
	
	}
	
	public static function datoffolderid($id_documento,$iddelexp){
			
		$regisffolderid = DB::select("select id_folder from sgd_documentos where id_documento = ".$id_documento." and id_expediente = ".$iddelexp);
	
		return $regisffolderid[0]->id_folder;
	
	}
	
	
	public static function datotipodocid($id_documento){
			
		$registipod = DB::select("select id_tipodocumental from sgd_documentos where id_documento = ".$id_documento);
	
		return $registipod[0]->id_tipodocumental;
	
	}
	
	public static function contarimagenesxdoc($id_documento){
			
		$regisimg = DB::select("select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$id_documento);   
	
		return $regisimg[0]->numimg;
	
	}
	public static function datoscreadocum($id_documento){
			
		$registpdoc = DB::select("select created_at  from sgd_documentos where id_documento = ".$id_documento);
	
		return $registpdoc[0]->created_at;
	
	}
	
	
	public static function dameidfolder_tabla($id_documento){
			
		$registpdoc = DB::select("select id_tabla,id_folder  from sgd_documentos where id_documento = ".$id_documento);
		
		$regisnfol = DB::select("select nombre from sgd_folders where id = ".$registpdoc[0]->id_folder." and id_tabla = ".$registpdoc[0]->id_tabla);
		
		return $regisnfol[0]->nombre;
		
		//return $registpdoc[0]->id_folder.'_;_'.$registpdoc[0]->id_tabla;
	
	}
	
	public static function permisofolder_tabla($id_documento){
			
		$registpdoc = DB::select("select id_tabla,id_folder  from sgd_documentos where id_documento = ".$id_documento);
		
		$idfolder = $registpdoc[0]->id_folder;
		
		$idtabla = $registpdoc[0]->id_tabla;
		
		// se verifica que la dependencia y la tabla esten permisadas		
		
		$regisimg = DB::select("select count(id_dependen_folder) as tpermiso FROM sgd_dependencias_folders WHERE id_folder = ".$idfolder." and id_tabla = ".$idtabla);
		
		if ($regisimg[0]->tpermiso > 0)
			{
				return true;				
			}
		else 
			{
				return false;
			}
	}
	
	public static function permisofolder_tabladepuser($id_documento){
		
		$idusuario = Session::get('id_usuario');
			
		$registpdoc = DB::select("select id_tabla,id_folder  from sgd_documentos where id_documento = ".$id_documento);
	
		$idfolder = $registpdoc[0]->id_folder;
	
		$idtabla = $registpdoc[0]->id_tabla;
	
		// se verifica que la dependencia y la tabla esten permisadas
	
		$regisimg = DB::select("select count(id_dependen_folder) as tpermiso FROM sgd_dependencias_folders WHERE id_folder = ".$idfolder." and id_tabla = ".$idtabla." and id_usuario = ".$idusuario);
	
		if ($regisimg[0]->tpermiso > 0)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
	
	public static  function siencrypt()
	{
		$registroencry = DB::select("select id_encrypt from sgd_encrypt where id_estado = 1");
	
		if (count($registroencry) > 0)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
	
	
	public static function verurl()
	 {
		return sprintf(
				"%s://%s%s",
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				$_SERVER['SERVER_NAME'],
				''
				);
	 }
	 public static function listadodocumentos($id_expediente){
	 	
	 	$regidocument = DB::select("SELECT id_documento,id_tipodocumental FROM sgd_documentos WHERE id_expediente = ".$id_expediente);
	 	
	 	if (count($regidocument) > 0)
		 	{
		 		unset($vdocumtn);
		 		unset($vtpdoc);	 		
		 		
		 		foreach($regidocument as $dato)
		 			{		 				
		 				
		 				$vdocumtn[] =  $dato->id_documento;
		 				
		 				$vtpdoc[] =  $dato->id_tipodocumental;
		 				
				 		
		 			} 		
		 		return json_encode($vdocumtn).'_;_'.json_encode($vtpdoc);
		 	}
	 	else
		 	{
		 		return false;
		 	}
	 
	 }
	 
	 public static function usuarios_notificar($id_usuario,$ruta){ 
	 	
	 	$regidocument = DB::select("SELECT u.name,u.lastname,u.id,u.avatar FROM sgd_usuarios u WHERE u.id > 0 and u.id <> ".$id_usuario);
	 	
	 	$script = '';
	 	 
	 	if (count($regidocument) > 0)
	 		{
	 			foreach($regidocument as $dato)
	 				{
	 					$script .= '<div id="user_'.$dato->id.'" class="status-badge mrg10A" style="cursor:pointer;position:relative;float:left !important" data-idusuariosel="'.$dato->id.'" onclick="marcame(this.id)" title="'.$dato->name.' '.$dato->lastname.'">';
	 					$script .= '<img id="im_'.$dato->id.'" class="img-circle sombradiv agrandar" width="40" src="'.$ruta.'/img/perfiles/'.$dato->avatar.'" alt="">';
	 					//$script .= '<div class="small-badge bg-red"></div>';
	 					$script .= '</div>';
	 				}
	 			return $script;
	 		}
 		else
	 		{
	 			return false;
	 		}
	 			 
	 }
	 
	 public static function misnotifica(){
	 	 
	 	$id_usuario = Session::get('id_usuario');
	 	 
	 	$regidocnoti = DB::select("SELECT d.id_documento,u.avatar FROM sgd_notificacion_usuarios d, sgd_usuarios u WHERE d.id_usuario = ".$id_usuario."  and u.id = d.id_usuario and  d.updated_at IS NULL"); 
	 	
	 	if (count($regidocnoti) > 0)
	 		{
	 			
	 			return true;
	 		}
	 	else 
	 		{
	 			return false;
	 		}
	 }	
	 
	 public static function vernotificaciones(){
	 	
	 	$id_usuario = Session::get('id_usuario');
	 	
	 	$regidocnoti = DB::select("SELECT d.id_documento,u.avatar FROM sgd_notificacion_usuarios d, sgd_usuarios u WHERE d.id_usuario = ".$id_usuario."  and u.id = d.id_usuario and  d.updated_at IS NULL");  
	 	
	 	$script = '<ul class="no-border notifications-box">';
	 	
	 	foreach($regidocnoti as $dato)
	 		{
	 			
	 			
	 			$indicesexp =  Util::listadoindices($dato->id_documento,$dato->id_documento);
	 			
	 			$indicesexp = explode("_;_",$indicesexp);
	 			
	 			$nombresindi = json_decode($indicesexp[0]);
	 			
	 			$valoresindi = json_decode($indicesexp[1]);
	 			
	 			$numimg = Util::contarimagenesxdoc($dato->id_documento);
	 			
	 			//se busca el nombre del folder
	 			
	 			$nfolder = Util::dameidfolder_tabla($dato->id_documento);
	 			
	 			$scriptd = '';
	 						
	 			for ($i = 0; $i < count($nombresindi); $i++)
		 			{
		 				
		 				$scriptd .= '<span class="indicesub"><strong>'.$nombresindi[$i].': </strong></span>'.$valoresindi[$i].', ';
		 				
		 			}
		 			
	 			$script = trim($script,',');
	 			
	 			$idtpdoc = Util::traeriddocumental($dato->id_documento);
	 			
	 			$ntpdoc = Util::traerdocumental($idtpdoc);
	 			
	 			$datosexpe = Util::datoscadena($dato->id_documento); 
	 			
	 			$ruta= Util::verurl();
	 			
			 	$script .= '<li>';
			 	$script .= '<span class="icon-notification sombraicono"><img src="'.$ruta.'/img/perfiles/'.$dato->avatar.'" alt="" class="img-borde_redonde" height="43" width="43"></span>';
			 	$script .= '<span  class="notification-text" style="position:relative;left:7%"><a id="docexpediente_'.$dato->id_documento.'" class="actible visor" href="javascript:;">'.$datosexpe.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.trans('principal.titimage').')</a></span><br>';
			 	$script .= '<span style="position:relative;left:13%">'.$scriptd.'</span>';		
			 	$script .= '</li>';
				 	
	 		}	 	
	 	
	 		$script .= '</ul>';  
	 	return $script;
	 }
	 
	 
	 public static function docleido($id_documento,$idusuario){
	 	
	 	$diahoy = date('Y-m-d H:i:s');
	 	
	 	DB::table('sgd_notificacion_usuarios')->where('id_usuario', '=',$idusuario)
	 	->where('id_documento', '=',$id_documento)
	 	->update(['updated_at' => $diahoy]);
	 	
	 	return true;
	 }
	 
	 public static function verficabodegas(){
	 	
	 	include(public_path().'/sftp/Net/SFTP.php');
	 	
	 	$id_usuario = Session::get('id_usuario');
	 	
	 	//primero se verifica que tenga bodegas registradas por ftp , sftp o local
	 	
	 	
	 	//se comprueba conectividad de bodega
	 	
	 	$regibodegas = DB::select("select * from sgd_setupbodega  where estatus = 1 and id_estado = 1");

	 	
	 	if (count($regibodegas[0]) > 0)
		 	{
		 		// tiene bodegas se verifica si es por local o ftp
		 		if ($regibodegas[0]->modobodega == 'powerfile2')
		 			{
		 				return true;  //es local del sistema no se verifica mas
		 			}	
		 		else
		 			{
		 				if ($regibodegas[0]->modobodega == 'FTP')
		 					{
				 				//se verifica que este activa la bodega en el ftp
				 				$conn_id = ftp_connect($regibodegas[0]->ftp_server,$regibodegas[0]->ftp_port);
				 				
				 				if (!$conn_id )
				 					{
				 						return false;  // la bodega existe pero no tiene acceso al ftp
				 					}
				 				// intentar iniciar sesión
				 				if (@ftp_login($conn_id, $regibodegas[0]->ftp_user, $regibodegas[0]->ftp_pass))
					 				{			 					
					 					
					 					return true;  //tiene acceso al ftp
					 				}
				 				else
					 				{
					 					return false;  // la bodega existe pero no tiene acceso al ftp
					 				}
					 			ftp_close($conn_id);
		 					}		
		 				else
		 					{
		 						if ($regibodegas[0]->modobodega == 'SFTP')
		 							{
		 								$sftp = new Net_SFTP($regibodegas[0]->ftp_server,$regibodegas[0]->ftp_port);
		 								
		 								if (!$sftp->login($regibodegas[0]->ftp_user, $regibodegas[0]->ftp_pass))
			 								{
			 									return false;  // la bodega existe pero no tiene acceso al sftp
			 									
			 								}
			 						     else 
			 						     	{
			 						     		return true;  //tiene acceso al sftp
			 						     	}
		 							}
		 					}
		 			}
		 	}
	 	else
		 	{
		 		return false;  //no tiene aun modo de bodegas registrados
	 		}	
	 }	 
	 
	 
	 /*
	 public static function listadodocumentos($id_expediente){
	 	
	 	$regidocument = DB::select("SELECT id_documento,id_tipodocumental,id_tabla,id_folder FROM sgd_documentos WHERE id_expediente = ".$id_expediente);
	 	
	 	//$regidocument = DB::select("SELECT i.nombre,v.valor,v.id_documento FROM sgd_valorindice v, sgd_indices i  WHERE i.id_indice = v.id_indice AND v.id_documento in (SELECT id_documento FROM sgd_documentos WHERE id_expediente = ".$id_expediente.")");
	 	 
	 	if (count($regidocument) > 0)
		 	{
		 		unset($vdocumtn);
		 		unset($vnomindi);
				unset($vvalindi);
		 		foreach($regidocument as $dato)
		 			{		 				
		 				$regiindice = DB::select("SELECT i.nombre,v.valor FROM sgd_valorindice v, sgd_indices i  WHERE i.id_indice = v.id_indice AND v.id_documento = ".$dato->id_documento);				 		
				 		$vdocumtn[] =  $dato->id_documento;				 		
				 		foreach($regiindice as $datoind)
					 		{
					 			//buscamos el dato dentro del indice
					 			$vnomindi[] = $datoind->nombre;
					 			$vvalindi[] = $datoind->valor;
					 		}
				 		
		 		} 		
		 	return json_encode($vnomindi).'_;_'.json_encode($vvalindi).'_;_'.json_encode($vdocumtn);
		 	}
	 	else
		 	{
		 		return false;
		 	}
	 
	 }
	  
	  */
	 
	
	/*public static function damenomfolder($id_folder){
			
		$registpdoc = DB::select("select nombre from sgd_folders where id = ".$id_folder);
	
		return $registpdoc[0]->id_folder.'_;_'.$registpdoc[0]->id_tabla;
	
	}
	*/
		
}