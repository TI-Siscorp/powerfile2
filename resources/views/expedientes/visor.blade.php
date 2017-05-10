@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titvvisor') }} 
@endsection

@section('tituloPagina')
	<h3 class="titulop">{{ trans('principal.titvvisor') }}/{{ trans('principal.tivexp') }}</h3>
@endsection

@section('contenido')

@inject('permisos','App\helpers\Util')

<?php

	$configdb = $permisos->verurl();
	
	$_SESSION['elidusuario'] = $idusuario;
	
	$ruta= $permisos->verurl();
	
	if ($buscar == '_;_')
		{
			$abuscar = '';
		}
	else
		{
			$abuscar = $buscar;
		}

	$workspace = $_SESSION['espaciotrabajo'];
	
	$permidescarga = $permisos->conocepermisos('down-img');
	
	//se verifica si tiene bodegas ftp y si estan activas y visibles
	
	$puedever = $permisos->verficabodegas();
	
	if ($puedever == true)
	{
		$sevearch = '1';
	}
	else
	{
		if ($puedever == false)
		{
			$sevearch = '0';
		}
	}
	
	//llenamos los usuarios a los cuales se les puede enviar la notificacion del documento 
	
	$scriptu = '';
		
	$scriptu = $permisos->usuarios_notificar($idusuario,$ruta);
	
?>
<meta charset="UTF-8" />
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

	
		
		<script type="text/javascript" charset="utf8" src="<?php echo $ruta;?>/js/jquery/jquery-1.8.2.min.js"></script>

		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
		  <link rel="stylesheet" href="<?php echo $ruta;?>/assets/bootstrap/css/bootstrap.css">
		  
		  <script src="<?php echo $ruta;?>/js/bootstrap.min.js"></script>
		  		  		 
	
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.css">		  
		
	
		  <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.js"></script>
		
		
		  <link rel="stylesheet" href="/dist/themes/default/style.css" />
		
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/icons/fontawesome/fontawesome.css">
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/icons/linecons/linecons.css">
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/css/estilo_powerfile.css">
		 
		 <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/datepicker/datepicker.js"></script>
	     <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.js"></script>
		
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/css/fileinput/fileinput.css">
		  
		  <script src="<?php echo $ruta;?>/js/fileinput/fileinput.js"></script>
		  
		  <script src="<?php echo $ruta;?>/js/jscroll-master/jquery.jscroll.js"></script>
		  
		  <script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>

	    
<style>
	ul.tll {
	  list-style: none;
	  padding: 0;
	}
	li.lni {
	  /*padding-left: 0.5em;*/
	  padding-top:0.5em;
	  padding-bottom:0.5em;
	}
	ul.uind {
	  list-style: none;
	  padding: 0;
	  /*width:50% !important;*/
	}
	li.lni {
	  /*padding-left: 1em;*/
	  padding-top:0.5em;
	  padding-bottom:0.5em;
	  
	}
								
	li.lni:hover {
		  background: #B0E6FF;
		}
	li.lni:before {
	  content: "\f04d"; /* FontAwesome Unicode f100 &#xf00c;*/ 
	  font-family: FontAwesome;
	  display: inline-block;
	  font-size:1.5em;
	 /* color:#00B0A1;*/
	 /* margin-left: 1.3em; /* same as padding-left set on li */
	  width: 1.3em; /* same as padding-left set on li */
	}
	.cder{
		color:#3498DB;
	}
	.cizq{
		color:#2ECC71;
	}
	.actible {
		cursor:pointer;
	}
	.actibleind{
		cursor:pointer;
	}
	.lind{
		color: #ffffff;
		margin-left: 1em !important;
		text-decoration:none; 
	}
	.colsort{
		width: 100% !important;
	}
	
	.colsortder{
		width: 90% !important;
	}
	.noseve{
		display:none;
	}
	.ampliado{
		max-width: 70% !important;
	}
	
	.popover-content{
		overflow-x: hidden;
		max-height: 500px !important;
		/*width:80% !important;*/
	}
	.carousel-indicators li {
	  display: inline-block;
	  width: 10px;
	  height: 10px;
	  margin: 1px;
	  text-indent: -999px;
	  cursor: pointer;
	  background-color: #1600BF \9 !important;
	  background-color: rgba(22, 0, 191, 1) !important;
	  border: 3px solid #1600BF !important;
	  border-radius: 10px;
	}
	.carousel-indicators .active {
	  width: 12px;
	  height: 12px;
	  margin: 0;
	  background-color: #1600BF !important;
	}
	.fileinput-upload-button{
		display:none !important;
	}
	.milazi{
		/*display:none;*/
	}
	.ui-sortable-handle{
		/*cursor: pointer;*/
	}
	
	p.tl-content{
		/*width: 80% !important;*/
		align:justify;
	}
	.btn span.glyphicon {    			
		opacity: 0;				
	}
	.btn.active span.glyphicon {				
		opacity: 1;				
	}
	input[type=checkbox] {
	  display: none;
	}
	/* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}
        .spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}
        .spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}
        .spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}
        @-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
		
</style>


<div id="fondomodal" class="fondomodal">
		<div id="cargando" class="cargando">
			<img src="{{{ asset('assets/images/spinner/loader-dark.gif') }}}" width="100" height="100" alt=""/>
		</div>
</div>	


<div class="modal fade" id="modalgral" role="dialog"> </div>


<div class="panel">
	<div class="panel-body">
	<div id="bloquebusqueda" >
		
    	
    	<div id="botones" class=" btnvisor" style="margin-bottom: 1px !important;position:relative;float:left;">
        	<table width="50%" border="0">
        		<tr>
        			<td width="50%" >
        				<div class="input-group input-group-lg subtitulop" style="width: 100% !important;margin-bottom: 1px !important;position:relative;float:left;"> 
				           	<input id="buscar" name="buscar" type="text" placeholder="{{ trans('principal.buscarque') }} " class="form-control" value="{{ $abuscar }}"> 
				            <div class="input-group-btn">
				               <button id="buscavisor" type="button" class="btn btn-default" tabindex="-1" >
				                  <i class="glyph-icon icon-search sombraicono icoverd" ></i>
				               </button>
				            </div>
				    	</div>
        			</td>
        			
        			<td width="5%" style="padding-left:15px;display:none" class="visis">
        				<a data-toggle="dropdown" href="#"  data-placement="bottom" class="popover-button-header tooltip-button hdr-btn sf-with-ul centrartexto" title="{{ trans('principal.btncerrar') }}">
			        	<!--a href="javascript:;" title="{{ trans('principal.btncerrar') }}" class="sf-with-ul centrartexto"-->
							<i class="glyphicon glyphicon-remove-circle sombraicono iconorojo tam23" onclick="cierrzoomimg()">&nbsp;</i>
						</a>
			        </td>
			        
			        <td id="tddescarga" width="5%" style="display:none" class="visis"> 
			       		<!--a id="itemdescarga" href="javascript:;" title="{{ trans('principal.btndescarg') }}" class="sf-with-ul centrartexto" onclick="quedescarga()"-->
			       		<a id="itemdescarga" data-toggle="dropdown" href="javascript:;"  data-placement="bottom" class="popover-button-header tooltip-button hdr-btn sf-with-ul centrartexto" onclick="quedescarga()" title="{{ trans('principal.btndescarg') }}">
							<i class="glyphicon glyphicon-download-alt sombraicono iconoverde tam23">&nbsp;</i>
						</a>
			         </td>
			         <td width="5%" style="display:none" class="visis"> 
			            <a id="agregai" data-toggle="dropdown" href="javascript:;"  data-placement="bottom" class="popover-button-header tooltip-button hdr-btn sf-with-ul centrartexto" title="{{ trans('principal.btnagregaimg') }}">
			       		<!--a id="agregai" href="javascript:;" title="{{ trans('principal.btnagregaimg') }}" class="sf-with-ul centrartexto" data-d="" data-exp=""--> 
							<i class="glyphicon glyphicon-picture sombraicono iconomorda tam23" onclick="agregarimagenes()" >&nbsp;</i>
						</a>
			         </td>
			         <td id="tdadddoc" width="5%" style="display:none" class="visis"> 
			         	<a id="itemadddoc" data-toggle="dropdown" href="javascript:;"  data-placement="bottom" class="popover-button-header tooltip-button hdr-btn sf-with-ul centrartexto" onclick="agregadocumento()" title="{{ trans('principal.tradadddoc') }}">
			       		<!--a id="itemadddoc" href="javascript:;" title="{{ trans('principal.tradadddoc') }}" class="sf-with-ul centrartexto" onclick="agregadocumento()"-->
							<i class="glyphicon glyphicon-file sombraicono iconoverde tam23">&nbsp;</i>
						</a>
			         </td>
			         	
			        <td width="5%" style="display:none" v>
			        	<div class="popover-content" >
							<a id="itemindi" href="javascript:;" class="sf-with-ul popover-button-default centrartexto" title="{{ trans('principal.btnverind') }}"  data-content="" data-trigger="click" data-placement="right">
							<i class="glyphicon glyphicon-option-vertical sombraicono iconooro tam23" >&nbsp;</i> 
							</a>
						</div>
					</td>		
					
					<td width="5%" class="centrartexto visis" style="display:none"> 
			        	<div class="popover-content" >
							<a id="misdocumentos" href="javascript:;" class="sf-with-ul popover-button-default centrartexto" title="{{ trans('principal.tradverdoc') }}"  data-content="" data-trigger="click" data-placement="bottom">
							<i class="glyphicon glyphicon-folder-open sombraicono iconoladrillo tam23" ></i>
							</a>
						</div>
					</td>	
					
					<td id="tdzoom" width="10%" style="display:none;padding-left:3%" class="visis">  
			       		<label>zoom:</label><input id="rzoom" type="range" min="0" max="500" value="1" oninput="elzoom(this.id)">
			         </td>
			         
			          <td width="10%" class="centrartexto" style="padding-left:30px" >&nbsp;</td>
			         
			         <td id="bizq" width="10%" class="centrartexto visis" style="display:none"><span id="retrocedeimgico" class="glyphicon glyphicon-backward sombraicono iconoazul tam32 clickble" onclick="avanzarimg(2)" style="position:relative;margin-right:3%"></span></td> 
			         
			         <td id="num_dimgcen" width="10%" class="centrartexto visis" style="padding-left:30px;display:none">
			         	<span id="num_imgcen" data-d="" data-1="" style="position:relative;float:right;font-size:2em;padding-right:50%" class="iconoazul sombraiconobl img_listado"></span>
			         </td>
			         
			         <td id="bder" width="10%" class="centrartexto visis" style="padding-left:15px;display:none" ><span valign="top" id="avanzarimgico" class="glyphicon glyphicon-forward sombraicono iconoazul tam32 clickble" onclick="avanzarimg(1)" style="position:relative;"></span>   </td>
			         
			         
        		     
			         
				</tr>	
			</table>	
		</div>
	</div>
	<br><br>
	<hr>	
	

	
	
	<!-- Modal -->
		  <div class="modal fade" id="modaldescarga" role="dialog" style="z-index:9999999 !important;">
		    <div class="modal-dialog" style="width: 70%;overflow-y:auto;overflow-x:none;max-heigth:10%;z-index:99999999 !important;">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="titulodocumentep" class="modal-title">Rango de imagenes a descargar</h4> 
			        </div>
			        <div class="modal-body">
			        
			      
			        	        
			            <input id="otraoperation" type="hidden" name="otraoperation" value="descargarlos">
			            
			            <input id="configdb" type="hidden" name="configdb" value="<?php echo $ruta;?>">
			            
			            <input id="id_usuario" type="hidden" name="id_usuario" value="<?php echo $idusuario;?>">
			   
			   			<input id="id_documentodesc" type="hidden" name="id_documento" value="">   <!-- contiene el id del documento-->		 
			           	
		               
		                
		                <div>
			                <div class="form-group"  style="width:45%;position:relative;float:left"> 
							  <label>Desde</label>
							   <input type="text" id="desdeimg" class="form-control spinner-input" placeholder="Ingrese el n&uacute;mero de imagen inicio" value="" onKeyUp="return ValNumero(this)">
		                    </div>               
			     			&nbsp;
			     			 <div class="form-group" style="width:45%;position:relative;float:left;margin-left:3%">
							  <label>Hasta</label>
							   <input type="text" id="hastaimg" class="form-control spinner-input" placeholder="Ingrese el n&uacute;mero de imagen final" value="" onKeyUp="return ValNumero(this)"> 
		                    </div>
		                    
 				   		</div>
			        	
		      		</div>
		      		 <br> <br> <br>
		      		<div class="modal-footer">
		         		<div class="form-group centrartexto">
							<button id="descargardoc" type="button" class="btn btn-primary" >{{ trans('principal.btndesc') }}</button>  
							<button id="cancelardoc" type="button" class="btn btn-danger btn-close" data-dismiss="modal">{{ trans('principal.btnca') }}</button>
			 			</div>
		      		</div>
		      
		      
		    </div>
		  </div>
		</div>
		
			<!-- Modal -->
		  <div class="modal fade" id="modaldocumentos" style="z-index:9999999 !important;">
		    <div class="modal-dialog" style="width: 70%;overflow-y:auto;overflow-x:none;max-heigth:10%;z-index:99999999 !important;">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="titulodocumentep" lass="modal-title"></h4> 
			        </div>
			        <div class="modal-body">
			        
			        <form id="formdocum" method="POST" action="<?php echo $ruta;?>/treepowerfile2/cargalo_documentos.php?workspace=<?php echo $workspace;?>" accept-charset="UTF-8" class="form-horizontal bpad15L pad15R bordered-row" enctype="multipart/form-data">
			        
			        	<div class="col-md-4" style="width: 90% !important">
				        	<div class="content-box mrg15B" style="position:relative;left:5%">
							        <h3 class="content-box-header clearfix">
							           {{ trans('principal.titinotificaa') }}  					            
							        </h3>
							        <!-- lista de usuarios -->
							        
							        <div id="enviara" class="content-box-wrapper text-center clearfix"><?php echo $scriptu;?> </div>
							</div>
							
						</div>	
			        
			            <input id="otraoperation" type="hidden" name="otraoperation" value="grabardocumentoadd">
			            
			            <input id="origen" type="hidden" name="origen" value="visor_lista">
			            
			            <input id="configdb" type="hidden" name="configdb" value="<?php echo $configdb;?>">
			            <input id="tablaid" type="hidden" name="tablaid" value="">
			            <input id="id_usuario" type="hidden" name="id_usuario" value="<?php echo $idusuario;?>">
			            
			            <input id="workspace" type="hidden" name="workspace" value="<?php echo $workspace;?>">
			   
			           	<input id="id_tipodoc" type="hidden" name="id_tipodoc" value="">    <!-- contiene el id del tipo documental    $idtpdoc;?> --> 	          
			        	<input id="id_folder" type="hidden" name="id_folder" value="">   <!-- contiene el id de la carpeta contenedora     $idffolder;?>--> 
			        	<input id="id_tabla" type="hidden" name="id_tabla" value="">   <!-- contiene el id de la tabla   $tablaid;?>-->
			        	<input id="id_expediente" type="hidden" name="id_expediente" value="">  <!-- contiene el id del expediente    $iddelexp;?>--> 
			        	
			        	<input id="id_eenviara" type="hidden" name="id_eenviara">  <!-- contiene el id de los usuarios a los que les será notificado la creación del documento-->
			        	
			        	<!-- los indices-->
			        	<div id="indicesitems"></div> 
			        	
		                <input id="documentosimg" class="file" type="file" name="documentosimg[]" multiple data-min-file-count="1">
		                <br>
				               
 				   </form>
			        	
		      		</div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		      
		      <div class="form-group centrartexto">
					<button id="guardardoc" type="button" class="btn btn-primary" >{{ trans('principal.btngu') }}</button>  
					<button id="cancelardoc" type="button" class="btn btn-danger btn-close" data-dismiss="modal">{{ trans('principal.btnca') }}</button>
			 </div>
		    </div>
		  </div>
		</div>
	
	
	<!-- actualizar los indices-->
	
	<!-- Modal -->
		  <div class="modal fade" id="modaldocumentosind" role="dialog">
		    <div class="modal-dialog" style="width: 70%;overflow-y:auto;overflow-x:none;max-heigth:10%">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="titulodocumentep" lass="modal-title"></h4> 
			        </div>
			        <div class="modal-body">
			        <!--form id="formdocumind" method="GET" action="<?php echo $ruta;?>/treepowerfile2/cargalo_documentos.php" accept-charset="UTF-8" class="form-horizontal bpad15L pad15R bordered-row" -->
			        
			        {!! Form::model($expedientes, ['method' => 'GET','route' => ['expedientes.actualizar', $idusuario],'class'=>'form-horizontal bordered-row','id'=>'formdocumind']) !!}
			        
			        
			            <input id="otraoperation" type="hidden" name="otraoperation" value="actualizaindocumento">
			            
			            <input id="configdb" type="hidden" name="configdb" value="<?php echo $ruta;?>">
			            <input id="tablaidind" type="hidden" name="tablaidind" value="">   									
			            <input id="id_usuario" type="hidden" name="id_usuario" value="<?php echo $idusuario;?>">
			   
			   			<input id="id_documentoind" type="hidden" name="id_documentoind">    <!-- contiene el id del documento-->		 
			           	<input id="id_tipodocind" type="hidden" name="id_tipodocind">    <!-- contiene el id del tipo documental-->		        
			        	<input id="id_folderind" type="hidden" name="id_folderind">  <!-- contiene el id de la carpeta contenedora-->
			        	<input id="id_tablaind" type="hidden" name="id_tablaind">  <!-- contiene el id de la tabla--> 
			        	<input id="id_expedienteind" type="hidden" name="id_expedienteind">  <!-- contiene el id del expediente--> 
			        	
			        	<!-- los indices-->
			        	<div id="indicesitemsind"></div> 
			        	
		                <br>
				  <!--/form-->       
 				   
			        	
		      		</div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		      
		      <div class="form-group centrartexto">
					<button id="guardardocind" type="button" class="btn btn-primary" >{{ trans('principal.btngu') }}</button>  
					<button id="cancelardocind" type="button" class="btn btn-danger btn-close" data-dismiss="modal">{{ trans('principal.btnca') }}</button>
			 </div>
		    </div>
		  </div>
		</div>
	
	
	
	@if ($message = Session::get('mensaje'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			
			{!! $message !!}
			
			{!! Session::forget('mensaje') !!}
		</div>
	@endif
	

		<!--h3 id="titi" class="title-hero">
           
        </h3-->
        
        
        
        <div class="example-box-wrapper" style="z-index: 999 !important;"> 
            <div class="timeline-box">
            
            
            	<?php
            		
            		$permiorden = $permisos->conocepermisos('order_img');
            		
            		           	
            		$ctl = 0;
            		$ctlexp = 0;
            		foreach($expedientes as $expediente)
            			{
            				
            				$iddoc = $expediente->id_documento;
            				
            				//$permiso_documentos = $permisos->permisofolder_tabla($expediente->id_documento);
            				
            				$permiso_documentos = $permisos->permisofolder_tabladepuser($expediente->id_documento);
            				
            				//se busca el nombre del folder
            				
            				$nfolder = $permisos->dameidfolder_tabla($expediente->id_documento);
            				
            				?>
            									
            				@if ($permiso_documentos == true)
            				
            						<?php
		            				if ($ctlexp != $iddoc)
		            					{
		            						
		            						$ctlexp = $iddoc;
		            						
		            						$ctl = $ctl + 1;
		            						
		            						//buscamos el dia y la hora de creacion del documento   
		            						
		            						$fecha =  $permisos->datoscreadocum($iddoc);   
		            						
		            						$fecha = explode(" ",$fecha);
		            						
		            						$hora = $fecha[1];
		            						
		            						list($ano,$mes,$dia) = explode("-",$fecha[0]);
		            						
		            						$fecha = $dia.'/'.$mes.'/'.$ano;
		            						//los datos de los documentos
		            						
		            						$totaldocumentos =  $permisos->contardocumentos($expediente->id_expediente);
		            						
		            						$totalimagenes =  $permisos->contarimagenesxdoc($iddoc);
		            						
		            						//se busca el tipodocumental del documento
		            						$idtpdocdocum = $permisos->traeriddocumental($iddoc);            						
		            						
		            						//se busca el nombre el tipo docmumental.
		            						$ntpdoc = $permisos->traerdocumental($idtpdocdocum);
		            						
		            						//se arma la lineas de indices
		            						
		            						$indicesexp = $permisos->listadoindices($iddoc,$iddoc);
		            							
		            						$indicesexp = explode("_;_",$indicesexp);
		            							
		            						$nombresindi = json_decode($indicesexp[0]);
		            							
		            						$valoresindi = json_decode($indicesexp[1]);
		            						
		            						$vidsindi = json_decode($indicesexp[2]);
		            						
		            						
		            						$script = '';
		            							
		            						$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';
		            							
		            						for ($i = 0; $i < count($nombresindi); $i++) 
			            						{
			            							$script .= '<span id="ind_'.$vidsindi[$i].'" class="sb-toggle-left ver_indices actibleind indicesub" data-valbuscar="'.$valoresindi[$i].'" data-valor="'.$vidsindi[$i].'" data-tp="'.$idtpdocdocum.'"><strong>'.$nombresindi[$i].': </strong></span>'.$valoresindi[$i].', ';
			            							 
			            							$scriptventana .= '<span class="indicesub"><strong>'.$nombresindi[$i].': </strong></span>'.$valoresindi[$i].'<br>';
			            						}
		            						$script = trim($script,',');
		            						            						
		            						$listatpdocum = $permisos->listadocumental($iddoc);
		            						
		            						if ($listatpdocum != false)
			            						{
			            						
			            							$listatpdocum = explode("_;_",$listatpdocum);
			            							unset($vidtp);
			            							unset($vnomtp);
			            							unset($vcolortp);
			            						
			            							$vidtp = json_decode($listatpdocum[0]);
			            						
			            							$vnomtp = json_decode($listatpdocum[1]);
			            						
			            							$vcolortp = json_decode($listatpdocum[2]);
			            						
			            							$scripttp = '';
			            						
			            							$scripttp .= '<ul class="tll">';
			            							$scriptin = '<ul class="uind">';
			            						
			            							unset($vctlind);
			            						
			            							$vctlind[] = 0;
			            						
			            							for ($i = 0; $i < count($vidtp); $i++) {
			            								 
			            								//buscamos los indices de cada tipo documental si tiene
			            								 
			            								$listaindicetp = $permisos->listaindices($vidtp[$i]); // echo $listaindicetp ;
			            								 
			            								 
			            								if ($listaindicetp != false)
				            								{
				            									unset($vidin);
				            									unset($vnomin);
				            									 
				            									$listaindice = explode("_;_",$listaindicetp);
				            									 
				            									$vidin = json_decode($listaindice[0]);
				            									 
				            									$vnomin = json_decode($listaindice[1]);
				            									 
				            						
				            									/////////////////////////////indices de los tipos documentales /////////////////////////////
				            									 
				            									$ctllind = 0;
				            									 
				            									for ($j = 0; $j < count($vidin); $j++) {
				            										
				            										if (in_array($vidin[$j], $vctlind))
					            										{
					            						
					            										}
				            										else
					            										{
					            											if ($ctllind >= 6 )
						            											{
						            												$ctllind = 0;
						            						
						            												$scriptin .= '<br><br>';
						            											}
					            											 
					            											$scriptin .= '<li class="lind bs-label label-blue-alt actibleind" >'; 
					            						
					            											$scriptin .= '<span id="ind_'.$vidin[$j].'" class="sb-toggle-left ver_indices" data-valor="'.$vidin[$j].'" >'.$vnomin[$j].'</span>';
					            											
					            						
					            											$scriptin .= '</li>';
					            						
					            											$vctlind[] = $vidin[$j];
					            						
					            										}
					            										$ctllind = $ctllind + 1;
				            									}
				            									if (count($vidin) > 0)
					            									{
					            										//$scriptin .= '<hr>';
					            									}
				            								}
			            								else
				            								{
				            									$scriptin = '';
				            									 
				            								}
			            								/////////////////////////////// fin de indices //////////////////////////////////////////
			            								 
			            								$scripttp .= '<li class="lni sombraicono" style="cursor:pointer;color:'.$vcolortp[$i].'">';
			            						
			            								$scripttp .= '<span id="agregaimg_'.$vidtp[$i].'" href="javascript:;" data-valor="'.$vidtp[$i].'">'.$vnomtp[$i].'</span>';
			            								            						
			            								if ($listaindicetp != false)
				            								{
				            									$scripttp .= '<ul>';
				            									 
				            									$listaindice = explode("_;_",$listaindicetp);
				            						
				            									$vidin = json_decode($listaindice[0]);
				            						
				            									$vnomin = json_decode($listaindice[1]);
				            									 
				            									for ($j = 0; $j < count($vidin); $j++) {
				            						
				            										$scripttp .= '<li class="sombraicono"> ';
				            						
				            										$scripttp .= '<span id="indtp_'.$vidin[$j].'" data-valor="'.$vidin[$j].'" style="color:#222222">'.$vnomin[$j].'</span>';
				            						
				            										$scripttp .= '</li>';
				            						
				            									}
				            									 
				            									$scripttp .= '</ul>';
				            								}
			            								 
			            								$scripttp .= '</li>';
			            							}
			            							$scriptin .= '</ul>';
			            							$scripttp .= '</ul>';
			            						}
		            						else
			            						{
			            						
			            							$scripttp = '';
			            							$scriptin = '';
			            						
			            						}
			            						
			            						
			            						/// se cre el listado de todos los documentos q conforman el expediente con sus indices
			            						
			            						$ldocumentos = $permisos->listadodocumentos($expediente->id_expediente);
			            						
			            						$ldocumentos = explode("_;_",$ldocumentos);
			            						
			            						$iddocs = json_decode($ldocumentos[0]);
			            						
			            						$idtpdocv = json_decode($ldocumentos[1]);
			            						
			            						$scriptventanadoc = '<span style="font-size:1em"><strong>'.trans("principal.msgdocume").'</strong></span><br>';
			            						
			            						$id_documento = $iddoc;
			            						
			            						for ($i = 0; $i < count($iddocs); $i++)
			            						{
			            								
			            							if ($id_documento != $iddocs[$i])
			            							{
			            									
			            								$indicesexp = $permisos->listadoindices($iddocs[$i],$iddocs[$i]);
			            									
			            								$indicesexp = explode("_;_",$indicesexp);
			            									
			            								$nombresindi = json_decode($indicesexp[0]);
			            									
			            								$valoresindi = json_decode($indicesexp[1]);
			            									
			            								$scriptd = '';   //ojo
			            									
			            								for ($f = 0; $f < count($nombresindi); $f++)
			            								{
			            									$scriptd .= '<span class="indicesub"><strong>'.$nombresindi[$f].': </strong></span>'.$valoresindi[$f].', ';
			            						
			            								}
			            									
			            								$numimg = $permisos->contarimagenesxdoc($iddocs[$i]);
			            									
			            								//se busca el nombre del folder
			            									
			            								$nfolder = $permisos->dameidfolder_tabla($iddocs[$i]);
			            									
			            								//se verifica que tenga permiso para ver datos de la dependencia y tabla de los documentos filtrados
			            						
			            								$permiso_documentos = $permisos->permisofolder_tabladepuser($iddocs[$i]);
			            						
			            								if ($permiso_documentos == true)
			            								{
			            										
			            									//se busca el nombre el tipo docmumental.
			            									$ntpdoc = $permisos->traerdocumental($idtpdocv[$i]);
			            										
			            									$scriptventanadoc .= '<br>';
			            									$scriptventanadoc .= '<a href="javascript:;"  id="docexpediente_'.$iddocs[$i].'" class="actible" onclick="visor_dopc('.$iddocs[$i].')">'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.trans('principal.titimage').')</a><br>';
			            									//- LOS INDICES Y SUS VALORES
			            									$scriptventanadoc .= '<span>'.$script.'</span><br>';
			            									$scriptventanadoc .= '<span><a href="javascript:;"  id="eldocumento_'.$iddocs[$i].'" class="actible" onclick="visor_dopc('.$iddocs[$i].')">'.trans("principal.titirdoc").'</span>';
			            									$scriptventanadoc .= '<hr style="margin-top:1px !important;margin-bottom:1px !important;">';
			            						
			            								}
			            							}
			            						}
		            						
		            						if ($ctl%2==0)
		            							{?>
		            								<div class="tl-row">
		            									<div class="tl-item float-right">
		            										<div class="tl-icon bg-info">
		            									    	<i class="glyphicon glyphicon-align-right"></i>
		            									    </div>
		            									    <div class="tl-panel">
		            									   		{{ $hora }}
		            									   	</div>
		            									   	<div class="popover right ampliado">
		            									   		<div class="arrow"></div>
		            									        	<div class="popover-content" >
		            									            	<div id="docexp_{{ $iddoc }}" class="tl-label bs-label label-info actible" data-monta="{{ $scriptventanadoc }}" data-exp="{{ $expediente->id_expediente }}">{{ $expediente->nombre }}&nbsp;&nbsp;-&nbsp;&nbsp;{{ $nfolder }}&nbsp;&nbsp;-&nbsp;&nbsp;{{ $ntpdoc }}</div>
		            									            		<p class="tl-content">
		            									            			<?php
		            									            				if ($totaldocumentos > 0)   
		            									            					{?>
		            												            			<span class="encuadre"><?php echo  $script;?></span>
		            																	    <br><?php
		            																		if ($totalimagenes > 0)
		            																			{  
		            																		    	
		            																				echo '<a id="limagen_'.$iddoc.'" class="sb-toggle-right ver_imagenes actibleind" data-valor="'.$expediente->id_expediente.'" data-tp="'.$idtpdocdocum.'"> Imagenes: '.$totalimagenes.'</a>';
		            																		    }	
		            																		 else
		            																		 	{
		            																		    	
		            																		 		echo '<span id="limagen_'.$iddoc.'" data-valor="'.$expediente->id_expediente.'" data-tp="'.$idtpdocdocum.'"> Imagenes: '.$totalimagenes.'</span>';
		            																		    }	
		            																		 echo '<br>';
		            																		
		            																	}
		            									            				else 
		            									            					{?>
		            									            						<!--Documentos: {{ $totaldocumentos }}<br-->
		            								            							Imagenes: {{ $totalimagenes }} <br>
		            								            							<?php
		            																		
		            								            						}	?>
		            													     </p>
		            									            		<div class="tl-time">
		            									            			<i class="glyphicon glyphicon-calendar cder sombraicono"></i>
		            									            				{{ $fecha }}
		            									            		</div>
		            									            </div>
		            									  </div>
		            								  </div>
		            							   </div><?php
		            							  }
		            						else
		            							{?>
		            								<div class="tl-row">
		            								 	<div class="tl-item">
		            										<div class="tl-icon bg-azure">
		            									    	<i class="glyphicon glyphicon-align-left"></i>
		            									    </div>
			            									<div class="tl-panel">
			            										{{ $hora }}
			            								    </div>
			            								    <div class="popover left ampliado">
			            										<div class="arrow"></div>
			            									    <div class="popover-content">
			            											<div id="docexp_{{ $iddoc }}" class="tl-label bs-label label-success actible" data-monta="{{ $scriptventanadoc }}"  data-exp="{{ $expediente->id_expediente }}">{{ $expediente->nombre }}&nbsp;&nbsp;-&nbsp;&nbsp;{{ $nfolder }}&nbsp;&nbsp;-&nbsp;&nbsp;{{ $ntpdoc }}</div>
			            										    	<p class="tl-content">
				            										        <?php
				            								            	if ($totaldocumentos > 0)
			            								            			{?>
			            											            	
			            															<span><?php echo  $script;?></span>
			            															<br><?php
			            															if ($totalimagenes > 0)
				            															{
				            																
				            																echo '<a id="limagen_'.$iddoc.'" class="sb-toggle-right ver_imagenes actibleind" data-valor="'.$expediente->id_expediente.'" data-tp="'.$idtpdocdocum.'"> Imagenes: '.$totalimagenes.'</a>';
				            															}
			            															else
				            															{
				            																
				            																echo '<span id="limagen_'.$iddoc.'" data-valor="'.$iddoc.'" data-tp="'.$idtpdocdocum.'"> Imagenes: '.$totalimagenes.'</span>';
				            															}
			            														    echo '<br>';
			            															
			            								            			}
			            								            		else 
			            								            			{?>
			            								            				<!--Documentos: {{ $totaldocumentos }}<br-->
			            								            				Imagenes: {{ $totalimagenes }} <br><?php
			            								            				           												
			            								            			}	?>
			            								            	</p>			
			            										        <div class="tl-time">
			            											    	<i class="glyphicon glyphicon-calendar cizq sombraicono"></i>
			            											        	{{ $fecha }}
			            										        </div>
			            									    </div>
			            								  </div>
		            								 </div>
		            							  </div><?php
		            						}
		            						
		            					}?>
		            		@endif			
		            					
            					<?php
            			}
            			
            	?>	
            </div>   <!----- fin de timeline-box---->
        </div>
       
        <div id="addimg" class="noseve" style="z-index:999999"> 
        	<iframe id="paddimg" src=""  height="700" width="100%" style="margin-top:1%" frameborder="0" ></iframe>
        </div>
        
        
		
        <div id="deimagenes" class="noseve">
        	<!--span id="num_imgcen" data-d="" data-1="" style="position:relative;float:right;font-size:2em;padding-right:50%" class="iconoazul sombraiconobl img_listado"></span>
        	<br><br>
        	
        	<div style="text-align:center">
        		<span id="retrocedeimgico" class="glyphicon glyphicon-backward sombraicono iconoazul tam32 clickble" onclick="avanzarimg(2)" style="position:relative;margin-right:3%"></span>
        		<span valign="top" id="avanzarimgico" class="glyphicon glyphicon-forward sombraicono iconoazul tam32 clickble" onclick="avanzarimg(1)" style="position:relative;"></span>        	
        	</div-->
      		<br><br>
      		<div id="imagen_visual" class="carousel-inner" style="width: 100% !important;margin: 0 auto !important;" data-bod="" data-img="" data-ext="" data-orden="" data-imgact="0" data-d="'.$iddocumento.'" data-numimg="" data-exp="">&nbsp;
				<img id="image_central" src="" data-d="" data-1=""  data-2="" class="sb-toggle-right imgcentral" onclick="zoomimg(this.id,1)" data-exp="" data-num="" alt="" width="80%" max-width="100%" style="cursor:pointer">
			</div>	
        </div> 
        
	</div>
</div>

<script type="text/javascript" src="{{ asset('assets/widgets/interactions-ui/draggable.js') }}"></script> 
<script type="text/javascript" src="{{ asset('assets/widgets/interactions-ui/sortable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/interactions-ui/selectable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/lazyload/lazyload.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/slidebars/slidebars.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/spinner/spinner.js') }}"></script>



<script type="text/javascript">

	$(function() { "use strict";
		$(".spinner-input").spinner();
	});
    /* Sortable elements */

    $(function() { "use strict";
        $(".sortable-elements").sortable();
    });

    
</script>

<script type="text/javascript">
	var docactivo = 0;
	var eltiti = $('#titi').text();
	$(document).ready(function() {
		
		$('#bppal').attr('data-visor','visor');

		$('#bppal').attr('data-controller','expedientes'); 
		 
		$('#fondomodal').show();

		var idusuario = '{{ $idusuario }}'; 

		var ruta = 	'{{ $ruta }}';

		 $('#fondomodal').hide();	   			
		 
		/////// se limpia la carpeta de imagenes del usuario
		/*var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=limpiarlo'+'&idusuario='+idusuario;   
		$.ajax({
		   type: "GET",
		   async:false, 
		   url: enlacerecep,
		   success: function(msg){  

			   $('#fondomodal').hide();	   				   
		   },
			error: function(x,err,msj){alert(msj) }
		  });*/
		 //////// 

		
			/*$(function() {
		        $("img.milazi").lazyload({
		            effect: "fadeIn",
		            threshold: 100
		        });
		    });*/

		esmovil= is_mobile();
			
		if (esmovil == true)
			{
				$('#botones').removeClass('btnvisor');

				$('#botones').addClass('btnvisormovil');
			}
			   
	});

	$('#buscavisor').bind('click', function () {

		var workspace = '{{ $workspace }}';
		
		var ejecutar = $.trim($('#buscar').val()); 

		if (ejecutar.length >=3)
			{

				if (ejecutar == ''){ejecutar='_;_';}
		
				ejecutar = ejecutar.replace(/%/g, '_..._');
		
				window.location.href = '{{ $ruta }}/'+workspace+'/expedientes/'+ejecutar+'/visor';	
			}
	});

	$('#buscar').keyup(function(e) {
		if(e.which == 13) { 
			var workspace = '{{ $workspace }}';
			
			var ejecutar = $.trim($('#buscar').val());  

			if (ejecutar.length >=3)
				{
			
					if (ejecutar == ''){ejecutar='_;_';}
					
					ejecutar = ejecutar.replace(/%/g, '_..._');

					ejecutar = ejecutar.replace('/', '_...._');
					
					window.location.href = '{{ $ruta }}/'+workspace+'/expedientes/'+ejecutar+'/visor';	
				}	
			}		
		
	});

	
	$( "#guardardoc" ).click(function() { 

		var ruta = '<?php echo $ruta;?>';  
		
		var id_usuario = '<?php echo $idusuario;?>';  
		$('#modaldocumentos').modal('hide');	
		$('#formdocum').submit();

	});

	$( "#guardardocind" ).click(function() { 

		var ruta = '<?php echo $ruta;?>';  
		
		var id_usuario = '<?php echo $idusuario;?>';  
		$('#modaldocumentosind').modal('hide');	
		$('#formdocumind').submit();

	});

	

	function agregarimagenes(){
		
		   var configdb = '{{ $ruta }}';

		   var ruta = '{{ $ruta }}';

		   var buscar = '{{ $buscar }}'; 

		   buscar = buscar.replace(/%/g, '_..._');

		   var idusuario = '{{ $idusuario }}';

		   var id_documento = $('#itemdescarga').attr('data-d'); 
			
		   var 	id_expediente = $('#itemdescarga').attr('data-exp');   

		   var id_tipodoc = $('#itemdescarga').attr('data-tp');   

		   var ntipdoc = $('#docexp_'+id_documento).text();
		   
		    $('#id_documento').val(id_documento);

	   		$('#id_expediente').val(id_expediente);
	   		
	   		$('#paddimg').attr('src',ruta+"/treepowerfile2/arbol_agregaimg.php?id_tipodoc="+id_tipodoc+"&id_documento="+id_documento+"&id_expediente="+id_expediente+"&ruta="+ruta+"&id_usuario="+idusuario+"&buscar="+buscar+"&ntipdoc="+ntipdoc+"&vi=v");

	   		 		
	   		$('.timeline-box').fadeOut('slow');

	   		$('#botones').fadeOut('slow'); 

	   		$('#deimagenes').fadeOut('slow');  

	   		$('#addimg').fadeIn('slow');
	}
	
	
	
	function zoomtodo(id){ 
		$('#fondomodal').show();
		var idusuario = '{{ $idusuario }}'; 
		
		var ruta = 	'{{ $ruta }}';

		var permiorden = '{{ $permiorden }}';
		
		var workspace = '{{ $workspace }}'; 
		
		//se recorren las imagenes
		var td1 = '';
		var td2 = '';
		var d = 0;
		$(".tiraimg").each(function(){
			var id = $(this).attr('id'); 
			var valord1 = $('#'+id).attr('data-1');
			var valord2 = $('#'+id).attr('data-2');  
			if (d == 0)
				{
					d = $('#'+id).attr('data-d'); 
				}
			td1 += valord1+'_;_';
			td2 += valord2+'_;_';						
		});
		
		var tabla = ''; 
		var script = '';
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=descargartodo'+'&d1='+td1+'&d2='+td2+'&iddoc='+d+'&idusuario='+idusuario+'&workspace='+workspace;   
		$.ajax({
		   type: "GET",
		   async:false, 
		   url: enlacerecep,
		   success: function(msg){  
			   
			   laimg = ruta+"/img/descargas/"+workspace+"/"+idusuario+"/Powerfiledoc_"+d+"_.pdf" ; 
			   				   
		   },
			error: function(x,err,msj){alert(msj) }
		  });

		if (permiorden == 1)
			{
				script +='<iframe id="print-iframe" name="print-iframe" src="'+laimg+'" height="1000" width="80%"></iframe>';
			}
		else
			{
				script +='<iframe id="print-iframe" name="print-iframe" src="'+laimg+'#toolbar=0" height="1000" width="80%"></iframe>';
			}	
			

		if ($("#deimagenes").is(":visible") == true) 
			{ 
				//se montan las imagenes
				$("#deimagenes").html(script);
			}
		else
			{
				//se cargan las imagenes y se muestra el div de imagenes y se oculta el de los expedientes
				var options = {};
				$("#deimagenes").html(script);						
				$(".timeline-box").fadeOut('slow');
				$("#deimagenes").fadeIn('slow');	
				$("#botones" ).show();				
			}
		$('#fondomodal').hide();
	}
	
	function zoomimg(id,v)
   	{
	   $('#fondomodal').show();
	   
	   var ruta = 	'{{ $ruta }}';

	   var idusuario = '{{ $idusuario }}'; 

	   var id_documento = 	$('#'+id).attr('data-d');  

	   $('#id_documentodesc').val(id_documento);
	    
	   $('.example-box-wrapper').hide(); 
	   
       if (v == 1)
       	{
			//se toma el src de la imagen y se muestra grande en el centro de la pantalla

			var docum = $('#'+id).attr('src');  

			var d1 = $('#'+id).attr('data-1');

			var d2 = $('#'+id).attr('data-2'); 

			var bod = $('#'+id).attr('data-bod');  

			var idtp = $('#'+id).attr('data-tp'); 

			var numim = $('#'+id).attr('data-num');     

			var ioid = id.split('_');     

			var d = $('#'+id).attr('data-d');     

		    var expe = $('#'+id).attr('data-exp');   

			var nexpe = $('#exp_'+id).text(); 

			$("#itemdescarga").attr('data-d',d);

			$("#itemdescarga").attr('data-exp',expe);

			$("#itemdescarga").attr('data-tp',idtp);	

			var permiorden = '{{ $permiorden }}';	

			var workspace = '{{ $workspace }}';  

			var permidescarga = '{{ $permidescarga }}';  
			
			var script = '';

			var laimg =  '';

			$('#num_imgcen').html(numim);

			$("#imagen_visual").attr('data-d',id_documento);	    

			if (numim > 0)
				{
					numimg = numim - 1; 
				}

			$("#imagen_visual").attr('data-imgact',numimg);

			$("#imagen_visual").attr('data-exp',expe);	

			//se cuentan las imagenes del documento
			
			var conteo = $("#imagen_visual").attr('data-orden'); 

			conteo = conteo.split('_,_');

			var tconteo = conteo.length;  
			
			$("#imagen_visual").attr('data-numimg',tconteo);	


			$("#num_imgcen").attr('data-d',id_documento);

			$("#num_imgcen").attr('data-1',d1);

			
			
		//se buscan los indices y se montan
		var tabla = ''; 
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=losindices'+'&d1='+d1+'&d2='+d2+'&iddoc='+d+'&idusuario='+idusuario+'&workspace='+workspace;
		$.ajax({
		   type: "GET",
		   async:false, 
		   url: enlacerecep,
		   success: function(msg){  

			   tabla = msg
			   			   				   
		   },
			error: function(x,err,msj){alert(msj) }
		  });
		
			
		//se montan los datos para el guardado de docuemntos nuevos
		
		$("#itemindi").attr("data-content", tabla) ;  	

		//se montan los documentos de ese expediente
		
		var dmonta = $('#docexp_'+d).attr('data-monta');
		
		$("#misdocumentos").attr("data-content", dmonta) ;  	 

		$("#bloquebusqueda").show();

		$("#bloquebusqueda").css('z-index',9999999);
		
			
		if (permidescarga == true)
			{	
				$("#tddescarga").show();
			}	

		$(".visis").show();
			
		if ($("#deimagenes").is(":visible") == true) 
			{ 
					if ($("#ladoizq").is(":visible") == true) 
					{
						$("#botones").removeClass('btnvisor');
						$("#botones").addClass('btnvisorladoizq');  
						$("#botones").show();		
					}
				else
					{
						$("#botones").removeClass('btnvisorladoizq');
						$("#botones").addClass('btnvisor');
					}
				
				var $scriptimg = '<img id="image_central" src="'+docum+'" data-1="'+d1+'"  data-2="'+d2+'" class="sb-toggle-right imgcentral" onclick="zoomimg(this.id,1)" data-exp="'+expe+'" data-d="'+id_documento+'" data-num="'+numim+'" alt="" width="80%" max-width="100%" style="cursor:pointer">';

				$('#imagen_visual').html($scriptimg);
			
				//se abre el lado derecho con las imagenes en miniatura del documento	
				
				var datoor = $('.slimScrollDiv').html();	

				var configdb = '{{ $ruta }}';

				
				
				//buscamos las imagenes de ese expedientes y las montamos en el div derecho
				var script = '';
				var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenesdoc'+'&id_documento='+id_documento+'&configdb='+configdb+'&permiorden='+permiorden+'&permidescarga='+permidescarga+'&workspace='+workspace; 
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){     
						   
						   script += msg; 
						   
					   },
						error: function(x,err,msj){alert(msj) }
					  });
				
				setTimeout(cargalo(script), 7000);
				
			}
		else
			{
				//se cargan las imagenes y se muestra el div de imagenes y se oculta el de los expedientes
				var configdb = '{{ $ruta }}';
				//buscamos las imagenes de ese expedientes y las montamos en el div derecho
				var script = '';
				var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenesdoc'+'&id_documento='+id_documento+'&configdb='+configdb+'&permiorden='+permiorden+'&permidescarga='+permidescarga+'&workspace='+workspace; 
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){     
						   
						   script += msg; 
						   
					   },
						error: function(x,err,msj){alert(msj) }
					  });
				
				setTimeout(cargalo(script), 7000);
				
				if ($("#ladoizq").is(":visible") == true) 
					{
						$("#botones").removeClass('btnvisor');
						$("#botones").addClass('btnvisorladoizq');  
					}
				else
					{
						$("#botones").removeClass('btnvisorladoizq');
						$("#botones").addClass('btnvisor');
					}
				var options = {};
				
				var $scriptimg = '<img id="image_central" src="'+docum+'" data-1="'+d1+'"  data-2="'+d2+'" class="sb-toggle-right imgcentral" onclick="zoomimg(this.id,1)" data-d="'+id_documento+'" data-exp="'+expe+'" data-num="'+numim+'" alt="" width="80%" max-width="100%" style="cursor:pointer">';

				$('#imagen_visual').html($scriptimg);
				
				$(".timeline-box").fadeOut('slow');
				$("#deimagenes").fadeIn('slow');	
				$("#botones").show();				
			}

			$(function() { "use strict";
				$(".colsortder").sortable({
				    connectWith: ".colsortder",
		
				    stop: function( ) {
				    	 var idimgctl = 0;
				 		
				           var contadorimg = 0;
			
				           var iddocumimg = 0;
			
				           var vidimagen = new Array();

				         //si el check esta marcado y tiene permiso se efectua el ordenamiento en base de datos de lo contrario no lo realiza 
				          if ($("#vordernoarlos").prop('checked') == true)
				           	{
				           
							       $(".img_listado").each(function(){
										var idimglist = $(this).attr('id'); 

										var idmiganetomada = $('#'+idimglist).attr('data-1');
										if ( jQuery.inArray( idmiganetomada, vidimagen ) == -1)
											{
												idimgctl = idmiganetomada;
												contadorimg = contadorimg + 1;
												if(contadorimg == 1)
													{
														iddocumimg = $('#'+idimglist).attr('data-d');
													}
												$('#'+idimglist).html(contadorimg);
												vidimagen[contadorimg - 1] = $('#'+idimglist).attr('data-1');								
											}
														
									});    
								 // se envia el nuevo orden a la tabla de imagenes
							     var configdb = '{{ $ruta }}';
					
								 var ruta = '{{ $ruta }}';	  

								 var workspace = '{{ $workspace }}';  
			
								 var jsonvidimagen = JSON.stringify(vidimagen);  
								 
								 var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=ordena_imagenes'+'&id_documento='+iddocumimg+'&configdb='+configdb+'&idsimg='+jsonvidimagen+'&workspace='+workspace; 
			
									$.ajax({
										   type: "GET",
										   async:false, 
										   url: enlacerecep,
										   success: function(msg){ 
											   
										   },
											error: function(x,err,msj){alert(msj) }
										  });
			           		}
							  
			        }//fin del evento stop del sorteable
		
		        	/////fin del proceso de ordenamiento en base de datos
		
		        
				});
			});	
				
			if ($("#ladoder").is(":visible") == true) 
			{ 
	
			}	
		else
			{
				//$('#ladoizq').fadeOut('slow');
				var estiloc = $('.sb-left').attr('style');
				estiloc +=  ';transform:translate(-350px)';
				$('.sb-left').attr('style', estiloc);
				
				$('#ladoder').fadeIn('slow');
				var estiloc = $('.sb-right').attr('style');
				estiloc +=  ';transform:translate(-350px)';
				$('.sb-right').attr('style', estiloc);
				$('#lderecho').show(); 
				$('.slimScrollDiv').show();
			}
		
       	}
      else
      	{
    	  	
      	}     
       $('#fondomodal').hide();	    
   	}
  	
 	function mostrartabla(id){	 
 	 	var idite = id.split('_');
 		$("#vertabla_"+idite[1]).fadeIn('slow');
 	}
 	function nomostrartabla(id){	 
 	 	var idite = id.split('_');
 		$("#vertabla_"+idite[1]).fadeOut('slow');
 	}
 	
	function cierrzoomimg(){  
		if ($("#deimagenes").is(":visible") == true) 
			{	
				//$("#deimagenes").html('');		
				$("#deimagenes").fadeOut('slow');					
				$(".timeline-box").fadeIn('slow');
				$("#botones").hide();	

				$('.example-box-wrapper').show(); 

				//$('#bloquebusqueda').hide();
				
				$('#botones').hide();  

				cierraderlado();
				
				docactivo = 0;	 
			}		
		$('#titi').html(eltiti);
	}
 	
   function abrelo(){
			alert('sami');
	}

   function elzoom(id){
 	   var zm = $('#'+id).val()+'%';
 	   
 	   $('#image_central').css("width",zm) ;
 		
    }     

   function mhori(id){
	   var mover = $('#'+id).val()+'%';
	   	   	   
	   $('#imgcentral').css("left",mover) ;
		
   } 
   
   function mver(id){
	   var mover = $('#'+id).val()+'%';
	   	   	   
	   $('#imgcentral').css("top",mover) ;
		
   } 

	
	$('.actible').bind('click', function () {
		
		
		
	});

	$('.ver_indices').bind('click', function () {  
		
		var id_indice = $(this).attr('data-valor');

		var id_tpdoc = $(this).attr('data-tp');

		var datoor = $('.slimScrollDiv').html();	

		var configdb = '{{ $ruta }}';

		var ira = 'expedientes.mostrar';

		var ruta = '{{ $ruta }}';

		 var workspace = '{{ $workspace }}';  

		var valorinbus =  $(this).attr('data-valbuscar'); 

		var script = '<div class="row" style="overflow-x:none;overflow-y:auto;max-height:100%;padding-left:3%">'; 
		
		//buscamos los documentos que tengan ese indice
		var script = '';
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=damedocumentosxind'+'&id_indice='+id_indice+'&configdb='+configdb+'&id_tpdoc='+id_tpdoc+'&valorinbus='+valorinbus+'&workspace='+workspace; 
		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){   
				   
				   script += msg;
				   				   
			   },
				error: function(x,err,msj){alert(msj) }
			  });

	    script += '</div>';
	    
		$('#ladoizq').html(script);  

				
		$(function() { "use strict";
			$(".column-sort").sortable({
			    connectWith: ".column-sort"
			});
		});
		
	});

	

	
	$('.ver_imagenes').bind('click', function () {
		
		var id_expediente = $(this).attr('data-valor');		

		var id_tpdocumental = $(this).attr('data-tp');	 
		
		var id_documentodat = $(this).attr('id');

	    id_documentodat = id_documentodat.split('_');

	    var id_documento = id_documentodat[1];

		var datoor = $('.slimScrollDiv').html();	

		var configdb = '{{ $ruta }}';

		var ira = 'expedientes.mostrar';

		var ruta = '{{ $ruta }}';

		//el permiso de ordenar
		
		var permiorden = '{{ $permiorden }}'; 

		var workspace = '{{ $workspace }}';  

		//el permiso de descarga
		
		var permidescarga = '{{ $permidescarga }}';  

		var puedever = '{{ $sevearch }}';   

		if (puedever == '1')
			{	
		
						//id_documento
				
						//se busca la tabla y el folder del documento 
						 
						var idtabla = 0;
				
						var idfolder = 0;
						
						 var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=idtabla_folder'+'&id_documento='+id_documento+'&configdb='+configdb+'&workspace='+workspace;  
									
						$.ajax({
							   type: "GET",
							   async:false, 
							   url: enlacerecep,
							   success: function(msg){    
				
							   		var ttabfol = msg.split('_;_');			
					
							   		idtabla = ttabfol[0];
				
							   		idfolder = ttabfol[1];	   	
								   
							   },
								error: function(x,err,msj){alert(msj) }
							  });
						
				
						$("#bloquebusqueda").attr('data-id_tpdocumental',id_tpdocumental); 
				
						$("#bloquebusqueda").attr('data-idtabla',idtabla); 
				
						$("#bloquebusqueda").attr('data-idfolder',idfolder); 
						
						
						//buscamos las imagenes de ese documento y las montamos en el div derecho  . 
						
						var script = '';
						
						var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenes'+'&id_documento='+id_documento+'&configdb='+configdb+'&id_expediente='+id_expediente+'&id_tpdocumental='+id_tpdocumental+'&permiorden='+permiorden+'&permidescarga='+permidescarga+'&workspace='+workspace;  
						
						$.ajax({
							   type: "GET",
							   async:false, 
							   url: enlacerecep,
							   success: function(msg){    
								   
								   script += msg;
								   
									// se buscan y se colocan los valores del arreglo de datos para manejar las imagenes atras y adelante
								   var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dlistadatosimg'+'&id_documento='+id_documento+'&configdb='+configdb+'&id_expediente='+id_expediente+'&id_tpdocumental='+id_tpdocumental+'&workspace='+workspace;  
									
									$.ajax({
										   type: "GET",
										   async:false, 
										   url: enlacerecep,
										   success: function(msg){  
										   	//se desglosa el contenido
				
										   	var titra = msg.split('_;_');
				
											var elorden = titra[0];
				
											elorden = elorden.substring(0,elorden.length-3);	
				
											var elorden = titra[0];
				
											elorden = elorden.substring(0,elorden.length-3);	
				
											var labodega = titra[1];
				
											labodega = labodega.substring(0,labodega.length-3);	 
				
											var lasimg = titra[2];
				
											lasimg = lasimg.substring(0,lasimg.length-3);	
				
											var lasext = titra[3];
				
											lasext = lasext.substring(0,lasext.length-3); 
												
											$("#imagen_visual").attr('data-bod',labodega);
				
											$("#imagen_visual").attr('data-img',lasimg);
				
											$("#imagen_visual").attr('data-orden',elorden);
				
											$("#imagen_visual").attr('data-ext',lasext);												   	
											   
										   },
											error: function(x,err,msj){alert(msj) }
										  });
									  
							   },
								error: function(x,err,msj){alert(msj) }
							  });
						setTimeout(cargalo(script), 7000);

			}
		else
			{
				if (puedever == '0')
					{	
						alert('Unable to connect to ftp');
						$('#ladoder').html('');  
						$('#ladoder').hide();
					}
			}		

		
		
	});

	function cargalo(script){ 
		$('#ladoder').hide();
		$('#ladoder').html(script);  
		$('#ladoder').fadeIn('slow');

		$(function() { "use strict";
			$(".colsortder").sortable({
			    connectWith: ".colsortder",

			    stop: function( ) {
		           var idimgctl = '';

		           var contadorimg = 0;

		           var iddocumimg = 0;

		           var vidimagen = new Array();

					
				   //si el check esta marcado y tiene permiso se efectua el ordenamiento en base de datos de lo contrario no lo realiza 
		           if ($("#vordernoarlos").prop('checked') == true)
		           		{
					       $(".img_listado").each(function(){
								var idimglist = $(this).attr('id');
								if (idimgctl != idimglist) 
									{
										idimgctl = idimglist;
										contadorimg = contadorimg + 1;
										if(contadorimg == 1)
											{
												iddocumimg = $('#'+idimglist).attr('data-d');
											}
										$('#'+idimglist).html(contadorimg);
										vidimagen[contadorimg - 1] = $('#'+idimglist).attr('data-1');								
									}
													
							});    
							
							 // se envia el nuevo orden a la tabla de imagenes
						     var configdb = '{{ $ruta }}';
				
							 var ruta = '{{ $ruta }}';	  

							 var workspace = '{{ $workspace }}';	    
		
							 var jsonvidimagen = JSON.stringify(vidimagen);  
							 
							 var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=ordena_imagenes'+'&id_documento='+iddocumimg+'&configdb='+configdb+'&idsimg='+jsonvidimagen+'&workspace='+workspace; 
		
								$.ajax({
									   type: "GET",
									   async:false, 
									   url: enlacerecep,
									   success: function(msg){ 
										   
									   },
										error: function(x,err,msj){alert(msj) }
									  });
		           		}
						  
		        }//fin del evento stop del sorteable

	        	/////fin del proceso de ordenamiento en base de datos

	        
			});
		});	

		$('.scroll').jscroll();
	}
	//script

	function verimgtp(id){
		var iddoc = $('#'+id).attr('data-valor');

		var idexp = $('#'+id).attr('data-exp');

		var idtpdoc = $('#'+id).attr('data-tp');

		$("#itemdescarga").attr('data-d',iddoc);

		$("#itemdescarga").attr('data-exp',idexp);

		$("#itemdescarga").attr('data-tp',idtpdoc);		
		
		if (iddoc != docactivo)
			{
				docactivo = iddoc;
				//se carga el lote de imagenes
			
				var configdb = '{{ $ruta }}';
		
				var ira = 'expedientes.mostrar';
		
				var ruta = '{{ $ruta }}';

				var workspace = '{{ $workspace }}';

				
			
				//buscamos las imagenes de ese documento y las montamos en el div deimagenes 
				var script = '';
				var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenescentro'+'&id_documento='+iddoc+'&configdb='+configdb+'&anc=20'+'&workspace='+workspace;  
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){    
						   
						    
						   script += msg;
						   
					   },
						error: function(x,err,msj){alert(msj) }
					  });
				  
				//se verifica que no este visible el div de imagenes
				
				var montaje = script.split('_;_');

				$("#bizq").html(montaje[1]);
				
				$("#num_dimgcen").html(montaje[2]);

				$("#bder").html(montaje[3]);
				
				if ($("#deimagenes").is(":visible") == true) 
					{ 
						//se montan las imagenes
						$("#deimagenes").html(montaje[0]);
					}
				else
					{
						//se cargan las imagenes y se muestra el div de imagenes y se oculta el de los expedientes
						
						$("#deimagenes").html(montaje[0]);						
						$(".timeline-box").fadeOut('slow');
						$("#deimagenes").fadeIn('slow');	
						$("#botones").fadeIn('slow'); 	
						$(".visis").fadeIn('slow'); 	 
											
					}
				//busco el valor de tabla
				$("#image_central").attr('data-exp',idexp);
				$("#image_central").attr('data-exp',idexp);
				
				$("#imagen_visual").attr('data-exp',idexp);


				var idtabla = 0;

				var idfolder = 0;
				
				 var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=idtabla_folder'+'&id_documento='+iddoc+'&configdb='+configdb+'&workspace='+workspace;  
							
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){   

					   		var ttabfol = msg.split('_;_');			
			
					   		idtabla = ttabfol[0];

					   		idfolder = ttabfol[1];	   	
						   
					   },
						error: function(x,err,msj){alert(msj) }
					  });
				

				$("#bloquebusqueda").attr('data-id_tpdocumental',idtpdoc); 

				$("#bloquebusqueda").attr('data-idtabla',idtabla); 

				$("#bloquebusqueda").attr('data-idfolder',idfolder); 
				
				
				//se buscan los indices del documento


				var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dametabladeindices'+'&id_documento='+iddoc+'&configdb='+configdb;   
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){    
						   
						   $("#itemindi").attr('data-content',msg);

						   $("#botones").removeClass('btnvisorladoizq');
						    
						   $("#botones").show();	
						   
					   },
						error: function(x,err,msj){alert(msj) }
					  });
							
			}
		else
			{
				//se oculta el div de imegenwes y se muestra el de expedientes
				$(".timeline-box").fadeIn('slow');
				$("#deimagenes").fadeOut('slow');	
				$("#deimagenes").html('');
				$("#botones").addClass('btnvisorladoizq');
				$("#botones").hide();	
				docactivo = 0;
			}
	}

	function verimgtpfull(id){  //muestra el total de imagenes del documento en el centro
		var iddoc = $('#'+id).attr('data-valor');   
		var idfolder = $('#'+id).attr('data-folder');
		
		$('#addimg').hide();
		if (iddoc != docactivo)
			{
				docactivo = iddoc;
				//se carga el lote de imagenes
			
				var configdb = '{{ $ruta }}';
		
				var ira = 'expedientes.mostrar';
		
				var ruta = '{{ $ruta }}';

				var workspace = '{{ $workspace }}'; 
			
				//buscamos las imagenes de ese folder y las montamos en el div deimagenes 
				var script = '';
				
				var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenescentrofullexp'+'&id_documento='+iddoc+'&configdb='+configdb+'&anc=20'+'&workspace='+workspace;  
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){     
						   
						    
						   script += msg;
						   
					   },
						error: function(x,err,msj){alert(msj) }
					  });
				  
				//se verifica que no este visible el div de imagenes
				if ($("#deimagenes").is(":visible") == true) 
					{ 
						//se montan las imagenes
						$("#deimagenes").html(script);

						$("#retro").css('width','20%');
						
					}
				else
					{
						//se cargan las imagenes y se muestra el div de imagenes y se oculta el de los expedientes
						
						$("#deimagenes").html(script);						
						$(".timeline-box").fadeOut('slow');
						$("#deimagenes").fadeIn('slow');						
					}
			}
		else
			{
				//se oculta el div de imegenwes y se muestra el de expedientes
				$(".timeline-box").fadeIn('slow');
				$("#deimagenes").fadeOut('slow');	
				$("#deimagenes").html('');
				$("#botones").hide();	
				docactivo = 0;
			}
	}


	
   function verimagenes(id){
	   
	   var id_expediente = $('#'+id).attr('data-valor'); 

		var datoor = $('.slimScrollDiv').html();	

		var configdb = '{{ $ruta }}';

		var ira = 'expedientes.mostrar';

		var ruta = '{{ $ruta }}';

		var workspace = '{{ $workspace }}'; 
		
		//buscamos las imagenes de ese expedientes y las montamos en el div derecho
		var script = '';
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenes'+'&id_expediente='+id_expediente+'&configdb='+configdb+'&workspace='+workspace; 
		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){    
				   
				   script += msg;
				   
			   },
				error: function(x,err,msj){alert(msj) }
			  });
		

		$('.slimScrollDiv').attr('style','position: relative; overflow-x:none; overflow-y:auto;width: auto; height: 100%;');
		
		$('.slimScrollDiv').html(script); //sb-right

		$('.sb-left').fadeOut('fast');

		$('.sb-left').removeClass('sb-active');

		$('.sb-right').fadeIn('fast');

		$('.sb-right').addClass('sb-active');

		 $("img.lazy").lazyload({
	            effect: "fadeIn",
	            threshold: 100
	        });
	
   }
 function ejecutarluego(id_expediente){ 

	 var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
	 
	 var ruta = '{{ $ruta }}';

	 var buscar = '{{ $buscar }}'; 

	 buscar = buscar.replace(/%/g, '_..._');

	 var idusuario = '{{ $idusuario }}';

	    
	 $('#addimg').hide();
	 
	 window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+buscar+'/visor';
	 
 }

 function ejecutarluegocierre(){ 

	 $('#addimg').hide();

	 $('#botones').fadeIn('slow'); 

   	 $('#deimagenes').fadeIn('slow'); 
	 
 }
 
   function agregarleimagenes(id_tipodoc,id_expediente){

	   var configdb = '{{ $ruta }}';

	   var ruta = '{{ $ruta }}';

	   var buscar = '{{ $buscar }}'; 

	   var idusuario = '{{ $idusuario }}';

	   var ntipdoc = $('#agregaimg_'+id_tipodoc).text();

	   var workspace = '{{ $workspace }}'; 
	   
		//se busca el id del docuemnto al que corresponda ese tipodocumental y expediente
	   var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameiddocumento'+'&id_expediente='+id_expediente+'&id_tipodoc='+id_tipodoc+'&configdb='+configdb+'&workspace='+workspace; 
		$.ajax({
		   type: "GET",
		   async:false, 
		   url: enlacerecep,
		   success: function(msg){   

		   		$('#id_tipodoc').val(id_tipodoc);	

		   		$('#id_documento').val(msg);

		   		$('#id_expediente').val(id_expediente);
		   		
		   		$('#paddimg').attr('src',ruta+"/treepowerfile2/arbol_agregaimg.php?id_tipodoc="+id_tipodoc+"&id_documento="+msg+"&id_expediente="+id_expediente+"&ruta="+ruta+"&id_usuario="+idusuario+"&buscar="+buscar+"&ntipdoc="+ntipdoc);

		   		//$('#modalgral').modal('show');    
		   		
		   		$('.timeline-box').fadeOut('slow');

		   		$('.popover').fadeOut('slow');

		   		$('#addimg').fadeIn('slow');
		   		   
			   
		   },
			error: function(x,err,msj){alert(msj) }
		  });
	   }

   function editarindices(id_documento,id_tipodoc,id_folder,id_tabla,id_expediente){  
	   var configdb = '<?php echo $ruta;?>'; 
	   var ruta = '<?php echo $ruta;?>';   

	   var workspace = '<?php echo $workspace;?>';     
	   
	    $('#id_documentoind').val(id_documento); 
		$('#id_tipodocind').val(id_tipodoc); 
		
		$('#id_folderind').val(id_folder);
		$('#id_tablaind').val(id_tabla);
		$('#id_expedienteind').val(id_expediente);
		
   		//se buscan los indices que tenga registrados la carpeta seleccionada
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameindicesitems'+'&id_carpeta='+id_folder+'&configdb='+configdb+'&idtpdoc='+id_tipodoc+'&tablaid='+id_tabla+'&expedid='+id_expediente+'&id_documento='+id_documento+'&workspace='+workspace;        
		

		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){        
				   $('#indicesitemsind').html(msg);   
				   
				   $(function() { "use strict";
				        $('.bootstrap-datepicker').bsdatepicker({
				            format: 'dd-mm-yyyy'
				        });
				    });


				   
			   },
				error: function(x,err,msj){alert(msj) }
			  });
		  
		$('#modaldocumentosind').modal('show');   
   }

   function cierraizqlado(){
		var izqstyle =  $('#sliderizq').attr('style');		
		$('#sliderizq').removeClass('sb-active');	
		$('#sliderizq').fadeOut('slow');
		$('#sliderizq').attr('style','margin-left: -350px;');
		$('.sb-left').length(0);
		
		leftActive = false;
   } 

   function cierraderlado(){
		var derstyle =  $('#lderecho').attr('style');		
		$('#lderecho').removeClass('sb-active');	
		$('#lderecho').fadeOut('slow');
		$('#lderecho').attr('style','margin-right: -350px;'); 
		$('#tbimagenescen').css('width','100%');
		//$('.sb-right').length(0);
		$('#num_imgcen').attr('style','position:relative;float:right;font-size:2em;padding-right:50%');
		rightActive = false;
		
		
  } 

   function avanzarimg(direccion){  

	   	var ruta = '{{ $ruta }}';

		var configdb = '{{ $ruta }}';
	
		var posi_actual = $('#imagen_visual').attr('data-imgact');  

		var bodegas = $('#imagen_visual').attr('data-bod');

		var imagenes = $('#imagen_visual').attr('data-img');   

		var extenciones = $('#imagen_visual').attr('data-ext');

		var iddocumento = $('#imagen_visual').attr('data-d'); 

		var numimgs =  $('#imagen_visual').attr('data-numimg');  

		var expe =  $('#imagen_visual').attr('data-exp'); 

		var orde = $('#imagen_visual').attr('data-orden');   
 
		//se busca la imagen a mostrar
		
		var vbodegas = bodegas.split('_,_');

		var vimagenes = imagenes.split('_,_'); 

		var vextenciones = extenciones.split('_,_');

		var vorde = orde.split('_,_');  

		var workspace = '{{ $workspace }}';

		if (direccion == 1)
			{
				if (posi_actual < (numimgs -1))
					{
						
						posi_actual = parseInt(posi_actual) + 1;
		
						bodegas = vbodegas[posi_actual];
		
						imagenes = vimagenes[posi_actual];
		
						extenciones = vextenciones[posi_actual];

						orde = vorde[posi_actual];
		
						$('#imagen_visual').attr('data-imgact',posi_actual);  
						
					}
				else
					{
						posi_actual = 0;
			
						bodegas = vbodegas[posi_actual];
			
						imagenes = vimagenes[posi_actual];
			
						extenciones = vextenciones[posi_actual];

						orde = vorde[posi_actual];
			
						$('#imagen_visual').attr('data-imgact',posi_actual); 
					}
			}
		else
			{
			if (direccion == 2)
				{   
					if (posi_actual > 0)
						{
							
							posi_actual = parseInt(posi_actual) - 1;
			
							bodegas = vbodegas[posi_actual];
			
							imagenes = vimagenes[posi_actual];
			
							extenciones = vextenciones[posi_actual];

							orde = vorde[posi_actual];
			
							$('#imagen_visual').attr('data-imgact',posi_actual);  
							
						}
					else
						{
							
							posi_actual = (numimgs -1);
				
							bodegas = vbodegas[posi_actual];
				
							imagenes = vimagenes[posi_actual];
				
							extenciones = vextenciones[posi_actual];

							orde = vorde[posi_actual];
				
							$('#imagen_visual').attr('data-imgact',posi_actual); 
						}
				}
			}

		// se colopca el orden de la imagen
				
		$('#num_imgcen').html(orde);
		
		//se manda a trabajar la imagen

		$('#fondomodal').show();
		
		var script = '';
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameimagenescentsigatras'+'&id_documento='+iddocumento+'&configdb='+configdb;
		enlacerecep += '&bodegas='+bodegas+'&img='+imagenes+'&exte='+extenciones+'&expe='+expe+'&posiimg='+posi_actual+'&dir='+direccion+'&orde='+orde+'&workspace='+workspace;     
		 
		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){    
				   
				   $("#imagen_visual").html(msg); 
				   
				   $('#fondomodal').hide();
				   
			   },
				error: function(x,err,msj){alert(msj) }
			  });
		
	}


   function quedescarga(){
		  var primeroimg = 0;
		  
		  var ultimoimg = 0;

		  var ctlimg = 0;
		  	
		  $(".tiraimg").each(function(){
			  	ctlimg = ctlimg + 1
			  	
				var id = $(this).attr('id');

			  	
			  	
				if (ctlimg == 1)
					{
						primeroimg = $('#'+id).attr('data-num');
					} 
				
				ultimoimg = $('#'+id).attr('data-num');		 			
			});	

		  $('#desdeimg').val(primeroimg);

		  $('#hastaimg').val(ultimoimg);
		  
		  $('#modaldescarga').modal('show');   
		
	  }
	  
	  $( "#descargardoc" ).click(function() { 

			$('#modaldescarga').modal('hide');
			
			$('#fondomodal').show();

			var idusuario = '{{ $idusuario }}'; 
			
			var ruta = 	'{{ $ruta }}';

			var permiorden = '{{ $permiorden }}';

		    var workspace = '{{ $workspace }}';

			var desdeimg =  $('#desdeimg').val();

			var hastaimg = $('#hastaimg').val();

			
			//se recorren las imagenes y solio se toman las seleccionadas dentro del rango
			
			var td1 = '';
			var td2 = '';
			var d = 0;
			if (desdeimg == hastaimg)
				{
						$(".tiraimg").each(function(){
							
							var id = $(this).attr('id'); 
			
							var num = $('#'+id).attr('data-num');
			
							if (num == desdeimg)
								{
									var valord1 = $('#'+id).attr('data-1');
									var valord2 = $('#'+id).attr('data-2');  
									if (d == 0)
										{
											d = $('#'+id).attr('data-d'); 
										}
									td1 += valord1+'_;_';
									td2 += valord2+'_;_';

									return false;
								}						
						});
				}			
			else
				{
					if (desdeimg < hastaimg)
						{
							$(".tiraimg").each(function(){
								
								var id = $(this).attr('id'); 
				
								var num = $('#'+id).attr('data-num'); 
				
								if (num >= desdeimg && num <= hastaimg)
									{
							
										var valord1 = $('#'+id).attr('data-1');
										var valord2 = $('#'+id).attr('data-2');  
										if (d == 0)
											{
												d = $('#'+id).attr('data-d'); 
											}
										td1 += valord1+'_;_';
										td2 += valord2+'_;_';
									}						
							});
						}
					else
						{
							if (hastaimg  < desdeimg)
								{
									$(".tiraimg").each(function(){
										
										var id = $(this).attr('id'); 
						
										var num = $('#'+id).attr('data-num');
						
										if (num >= hastaimg && num <= desdeimg)
											{
									
												var valord1 = $('#'+id).attr('data-1');
												var valord2 = $('#'+id).attr('data-2');  
												if (d == 0)
													{
														d = $('#'+id).attr('data-d'); 
													}
												td1 += valord1+'_;_';
												td2 += valord2+'_;_';
											}						
									});
								}
						}	
				}
			
			var tabla = ''; 
			var script = '';
			var laimg = '';
			var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=descargartodo'+'&d1='+td1+'&d2='+td2+'&iddoc='+d+'&idusuario='+idusuario+'&workspace='+workspace; 
			$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){  
				   
				   laimg = ruta+"/img/descargas/"+workspace+"/"+idusuario+"/Powerfiledoc_"+d+"_.pdf" ; 
				   				   
			   },
				error: function(x,err,msj){alert(msj) }
			  });

			if (permiorden == 1)
				{
					script +='<iframe id="print-iframe" name="print-iframe" src="/ViewerJS/./#'+laimg+'" height="1000" width="80%"></iframe>';
				}
			else
				{
					script +='<iframe id="print-iframe" name="print-iframe" src="/ViewerJS/./#'+laimg+'" height="1000" width="80%"></iframe>';
				}	
			
			//se oculta el boton de descarga
			
			//$("#tddescarga").hide();
			

			if ($("#deimagenes").is(":visible") == true) 
				{ 
					//se montan las imagenes
					$("#deimagenes").html(script);
				}
			else
				{
					//se cargan las imagenes y se muestra el div de imagenes y se oculta el de los expedientes
					var options = {};
					$("#deimagenes").html(script);						
					$(".timeline-box").fadeOut('slow');
					$("#deimagenes").fadeIn('slow');	
					$("#botones" ).show();				
				}
			$('#fondomodal').hide();

			

		});

	  function agregadocumento(){

		  var configdb = '<?php echo $configdb;?>'; 
		  var titdoc = '{{ trans('principal.titvvisor') }}'; 
		  var idtpdoc = $('#bloquebusqueda').attr('data-id_tpdocumental');
		  var idnode = $('#bloquebusqueda').attr('data-idfolder');
		  var tablaid = $('#bloquebusqueda').attr('data-idtabla');
		  var expedid = $('#imagen_visual').attr('data-exp');  
		  var ruta = '<?php echo $ruta;?>'; 	
		  var workspace = '<?php echo $workspace;?>'; 
		  

		  $('#id_tipodoc').val(idtpdoc);

		  $('#id_folder').val(idnode);

		  $('#id_tabla').val(tablaid);

		  $('#id_expediente').val(expedid);	      
		  	
		  //se buscan los indices que tenga registrados la carpeta seleccionada
		  
		  //var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameindicesitems'+'&id_carpeta='+idnode+'&configdb='+configdb+'&idtpdoc='+idtpdoc+'&tablaid='+tablaid+'&expedid='+expedid; 
		  	
		  var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=dameindicesitems'+'&id_carpeta='+idnode+'&configdb='+configdb+'&idtpdoc='+idtpdoc+'&tablaid='+tablaid+'&expedid='+expedid+'&workspace='+workspace;       
			$.ajax({
				   type: "GET",
				   async:false, 
				   url: enlacerecep,
				   success: function(msg){         
					   $('#indicesitems').html(msg);  
					   
					   $(function() { "use strict";
					        $('.bootstrap-datepicker').bsdatepicker({
					            format: 'dd-mm-yyyy'
					        });
					    });


					   
				   },
					error: function(x,err,msj){ }
				  })
		   	 
			$('#modaldocumentos').modal('show');   
			
		}
	  $( "#guardardoc" ).click(function() { 

			var ruta = '<?php echo $ruta;?>';  
			var tablaid = $('#bloquebusqueda').attr('data-idtabla');
			var expedid = $('#imagen_visual').attr('data-exp');   
			var id_usuario = '<?php echo $idusuario;?>';  
			$('#modaldocumentos').modal('hide');	
			$('#formdocum').submit();

			var uo = 0;
			 $("#indicesitems input").each(function (index) 
	   			 {
	   			 	if (uo == 0)
	   			 		{
				 			var childEl = $(this).val();
	   			 		}
	   			}) 	
			 
		});
		
      
	$('div.alert').delay(3000).slideUp(300);


	function visor_dopc(iddocs){

		var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';

		var buscar = $('#buscar').val();   

		if (buscar == '')
			{
			buscar = '_;_';
			}
		buscar = buscar.replace(/%/g, '_..._');
		
		var id_documento = iddocs;

		window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+id_documento+'/'+buscar+'/visor_listado';
		
		
	}

	function marcame(idu){  
		var iddeuser = $('#'+idu).attr('data-idusuariosel'); 
		if ($('#im_'+iddeuser).hasClass('escogido'))
			{
				var nid_eenviara = '';
				$('#im_'+iddeuser).removeClass('escogido');
				var id_eenviara = $('#id_eenviara').val(); 	
				var id_eenviara2 = id_eenviara.split('_;_');
				for (i = 0; i < id_eenviara2.length; i++) {   
					if (parseInt(id_eenviara2[i]) != parseInt(iddeuser))
						{
							if (parseInt(id_eenviara2[i])> 0)
								{
									nid_eenviara += id_eenviara2[i]+'_;_';
								}	
						}
				}
				$('#id_eenviara').val(nid_eenviara); 	
				 
			}
		else
			{
				$('#im_'+iddeuser).addClass('escogido');
				var id_eenviara = $('#id_eenviara').val(); 	
				id_eenviara += iddeuser+'_;_';
				$('#id_eenviara').val(id_eenviara); 	
			}
		
		
	}

	function verzip(id){
		var archivodelzip = $('#'+id).attr('data-arzip');  
		var archivopadre = $('#'+id).attr('data-archivopadre'); 
		
		var configdb = '<?php echo $configdb;?>'; 
		var ruta = '<?php echo $ruta;?>'; 
		var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
		var destino = '../img/apiimg/'+espaciotrabajo+'/';
		///////////// los valores ///////////////////////
		
		var bod = $('#'+id).attr('data-bod');   
		var ordenimg = $('#'+id).attr('data-ordenimg');     
		var d = $('#'+id).attr('data-d');
		var uno = $('#'+id).attr('data-1');
		var dos = $('#'+id).attr('data-2');
		var num = $('#'+id).attr('data-num');  
		var exp = $('#'+id).attr('data-exp'); 

		var workspace = '<?php echo $workspace;?>';  
		
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=extraezip'+'&destino='+destino+'&configdb='+configdb+'&archivodelzip='+archivodelzip+'&archivopadre='+archivopadre+'&workspace='+espaciotrabajo+'&bod='+bod+'&ordenimg='+ordenimg+'&d='+d+'&uno='+uno+'&dos='+dos+'&num='+num+'&exp='+exp+'&workspace='+workspace;     

		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){    // alert(msg);
				   $('#imagen_visual').html(msg); 
				   $('#num_imgcen').html(num);
				   $('#imagen_visual').attr('data-imgact',num); 

				   $(".timeline-box").fadeOut('slow');
				   $("#deimagenes").fadeIn('slow');
				   $("#botones").show();		
				   $(".visis").show(); 
			   },
				error: function(x,err,msj){ }
			  });	
		
	}

	/*(function() {
	        $("img.lazy").lazyload({
	            effect: "fadeIn",
	            threshold: 100
	        });
	    });*/

</script>

@endsection