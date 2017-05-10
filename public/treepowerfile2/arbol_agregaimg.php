<?php
	@session_start();
	$id_tipodoc = $_REQUEST['id_tipodoc'];
	$ruta = $_REQUEST['ruta'];
	$id_documento = $_REQUEST['id_documento'];
	$id_expediente = $_REQUEST['id_expediente'];
	$id_usuario = $_REQUEST['id_usuario'];
	@$vi = @$_REQUEST['vi'];
	$buscar = $_REQUEST['buscar'];
	$configdb = $ruta;
	@$ntipdoc = @$_REQUEST['ntipdoc']; 
	$valor = $_SESSION['lenguaje'];  
	require('traduccion_arbol.php');
	$traduce = new Traduccion_arbol();
	
	$workspace = $_SESSION['espaciotrabajo'];
	
	if ($ntipdoc == '')
		{
			header ("Location: ".$ruta);
		}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		  <script type="text/javascript" charset="utf8" src="<?php echo $ruta;?>/js/jquery/jquery-1.8.2.min.js"></script>
	
		  <link rel="stylesheet" href="<?php echo $ruta;?>/assets/bootstrap/css/bootstrap.css">
		  
		  <script src="<?php echo $ruta;?>/js/bootstrap.min.js"></script>
		  		  		 
	
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.css">		  
		
	
		  <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.js"></script>
		
		
		  <link rel="stylesheet" href="dist/themes/default/style.css" />
		
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/icons/fontawesome/fontawesome.css">
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/icons/linecons/linecons.css">
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/css/estilo_powerfile.css">
		
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/css/fileinput/fileinput.css">
		  
		  <script src="<?php echo $ruta;?>/js/fileinput/fileinput.js"></script>
		  
		  <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/datepicker/datepicker.js"></script>
		
		  <script src="dist/jstree.js"></script>
		
		
		
		<style>
				html, body { background-color:#ffffff!important;font-size:10px; font-family:Verdana; margin:0; padding:0; }
				#container { min-width:320px; margin:0px auto 0 auto; background:white; border-radius:0px; padding:0px; overflow:hidden; }
				#tree { float:left; min-width:319px; border-right:1px solid silver; overflow:auto; padding:0px 0; }
				#data { margin-left:320px; }
				#data textarea { margin:0; padding:0; height:100%; width:100%; border:0; background:white; display:block; line-height:18px; }
				#data, #code { font: normal normal normal 12px/18px 'Consolas', monospace !important; }
				
				#col-tpdoc ul {
				  list-style: none;
				  padding: 0;
				}
				#col-indices ul {
				  list-style: none;
				  padding: 0
				}
				#col-tpdoc li {
				  padding-left: 1.3em;
				  padding-top:0.5em;
				  padding-bottom:0.5em;
				}
				#col-indices li {
				  padding-left: 1.3em;
				  padding-top:0.5em;
				  padding-bottom:0.5em;
				}
				
				#col-tpdoc li:hover {
					  background: #B0E6FF;
					}
				#col-indices li:hover {
					  background: #B0E6FF;
					}
				#col-tpdoc li:before {
				  content: "\f04d"; /* FontAwesome Unicode f100 &#xf00c;*/ 
				  font-family: FontAwesome;
				  display: inline-block;
				  font-size:1.5em;
				 /* color:#00B0A1;*/
				  margin-left: 1.3em; /* same as padding-left set on li */
				  width: 1.3em; /* same as padding-left set on li */
				}
				
				#col-indices li:before {
				  content: "\f100"; /* FontAwesome Unicode  &#xf00c; &#xf100;*/ 
				  font-family: FontAwesome;
				  display: inline-block;
				  font-size:1.5em;
				  color:#00B0A1;
				  margin-left: 1.3em; /* same as padding-left set on li */
				  width: 1.3em; /* same as padding-left set on li */
				}
				
				.divarbol {
				    position:relative;
				   	margin-top:1%;
				    float:left;
				    width:100% ;
				    display:none;
				}
				.divtpdoc {
					position:relative;
					margin-top:1%;
					float:left;
					width:0%;
					padding-right:5%;
					display:none;
				}
				.divindice {
					position:relative;
					margin-top:1%;
					float:left;
					width:0%;
					display:none;
				}
				
				td { text-align: center; }
				
				.bsdatepicker{z-index:99999;}
				
				.fileinput-upload-button{
					display:none !important;
				}
		</style>
	<head>	
	<body id="elcuerpotree" style="background-color:#ffffff !important;font-size:13px !important">
		<!-- Modal -->
		  <div class="modal fade" id="modalimagenes" role="dialog" style="z-index:9999999 !important;"> 
		    <div class="modal-dialog" style="width: 70%;overflow-y:auto;overflow-x:none;max-heigth:10%;z-index:99999999 !important;">
		    
		    
		      <!-- Modal content-->
		      <div class="modal-content" style="z-index:99999999 !important;">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
			          <h4 id="titulodocumentep" lass="modal-title"><?php echo $traduce->traduce('titvagrimg');?> <?php echo $ntipdoc;?></h4>  
			        </div>
			        <div class="modal-body">
			        
			        <form id="formimagen" method="POST" action="cargalo_documentos.php" accept-charset="UTF-8" class="form-horizontal bpad15L pad15R bordered-row" enctype="multipart/form-data">
			        
			            <input id="otraoperation" type="hidden" name="otraoperation" value="grabarimagen"> 
			            <input id="id_usuario" type="hidden" name="id_usuario" value="<?php echo $id_usuario;?>">
			            <input id="configdb" type="hidden" name="configdb" value="<?php echo $ruta;?>">
			            <input id="vi" type="hidden" name="vi" value="<?php echo $vi;?>">
			   
			   			<input id="workspace" type="hidden" name="workspace" value="<?php echo $workspace;?>">
			   
			           	<input id="id_tipodoc" type="hidden" name="id_tipodoc" value="<?php echo $id_tipodoc;?>">    <!-- contiene el id del tipo documental-->		         
			        	<input id="id_documento" type="hidden" name="id_documento" value="<?php echo $id_documento;?>">  <!-- contiene el id de la carpeta contenedora-->
			        	<input id="id_expediente" type="hidden" name="id_expediente" value="<?php echo $id_expediente;?>">  <!-- contiene el id del expediente-->
			        	
			        	
			        	
		                <input id="documentosimg" class="file" type="file" name="documentosimg[]" multiple data-min-file-count="1">  
		                <br>
				               
 				   </form>
			        	
		      		</div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		      
		      <div class="form-group centrartexto">
					<button id="guardarimg" type="button" class="btn btn-primary" ><?php echo $traduce->traduce('cnodeguardar');?></button>  
					<button id="cancelardoc" type="button" class="btn btn-danger btn-close" data-dismiss="modal"  ><?php echo $traduce->traduce('cnodecancela');?></button>
			 </div>
		    </div>
		  </div>
		</div>
	
	</body>
	
<script type="text/javascript">


	$('#modalimagenes').modal('show');   

	$( "#guardarimg" ).click(function() {  
	
		var ruta = 	'<?php echo $ruta;?>';  
	
	    var idusuario = '<?php echo $id_usuario;?>';   
	    
	    var buscar = '<?php echo $buscar;?>';  

	    var vi = '<?php echo $vi;?>';  

	    var id_expediente = '<?php echo $id_expediente;?>'; 
	    		
		$('#formimagen').submit();
	          
		
	});

	$( "#cancelardoc" ).click(function() { 

		window.parent.ejecutarluegocierre();
		
	});

	
</script>
</html>