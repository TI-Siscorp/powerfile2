<?php
	@session_start();
	$tablaid = $_REQUEST['tablaid'];
	$ruta = $_REQUEST['ruta'];   
	$expedid = $_REQUEST['expedid'];  
	$id_usuario = $_REQUEST['id_usuario'];  
	$configdb = $ruta; 
	$valor = $_SESSION['lenguaje'];  
	require('traduccion_arbol.php');
	$traduce = new Traduccion_arbol();
	if ($id_usuario == '')
		{	
			header ("Location: ".$ruta);
		}	
		$workspace = $_SESSION['espaciotrabajo'];  
		
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
				
				.bsdatepicker{z-index:99999999 !important;}
				
				.fileinput-upload-button{
					display:none !important;
				}
		</style>
	<head>	
	<body id="elcuerpotree" style="background-color:#ffffff !important;font-size:13px !important">
	
	<!-- Modal -->
		  <div class="modal fade" id="modaldocumentos" role="dialog" style="z-index:99999 !important">
		    <div class="modal-dialog" style="width: 70%;overflow-y:auto;overflow-x:none;max-heigth:10%;z-index:999999 !important">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="titulodocumentep" lass="modal-title"></h4> 
			        </div>
			        <div class="modal-body">
			        
			        <form id="formdocum" method="POST" action="cargalo_documentos.php" accept-charset="UTF-8" class="form-horizontal bpad15L pad15R bordered-row" enctype="multipart/form-data">
			        
			        
			        	<div class="col-md-4" style="width: 90% !important">
				        	<div class="content-box mrg15B" style="position:relative;left:5%">
							        <h3 class="content-box-header clearfix">
							            <?php echo $traduce->traduce('titinotificaa');?>						            
							        </h3>
							        <!-- lista de usuarios -->
							        
							        <div id="enviara" class="content-box-wrapper text-center clearfix">
							        
							            
							            
							        </div>
							</div>
							
						</div>	
			        
			            <input id="otraoperation" type="hidden" name="otraoperation" value="grabardocumento">
			            
			            <input id="configdb" type="hidden" name="configdb" value="<?php echo $configdb;?>">
			            <input id="tablaid" type="hidden" name="tablaid" value="<?php echo $tablaid;?>">
			            <input id="id_usuario" type="hidden" name="id_usuario" value="<?php echo $id_usuario;?>">
			            <input id="workspace" type="hidden" name="workspace" value="<?php echo $workspace;?>">
			            
			   
			           	<input id="id_tipodoc" type="hidden" name="id_tipodoc">    <!-- contiene el id del tipo documental-->		        
			        	<input id="id_folder" type="hidden" name="id_folder">  <!-- contiene el id de la carpeta contenedora-->
			        	<input id="id_tabla" type="hidden" name="id_tabla">  <!-- contiene el id de la tabla-->
			        	<input id="id_expediente" type="hidden" name="id_expediente">  <!-- contiene el id del expediente-->
			        	
			        	<input id="id_eenviara" type="hidden" name="id_eenviara">  <!-- contiene el id de los usuarios a los que les será notificado la creación del documento-->
			        	
			        	
			        	<!-- los indices-->
			        	<div id="indicesitems" style="padding-top:10% !important"></div> 
			        	
		                <input id="documentosimg" class="file" type="file" name="documentosimg[]" multiple data-min-file-count="1">   
		                <br>
				               
 				   </form>
			        	
		      		</div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		      
		      <div class="form-group centrartexto">
					<button id="guardardoc" type="button" class="btn btn-primary" ><?php echo $traduce->traduce('cnodeguardar');?></button>  
					<button id="cancelardoc" type="button" class="btn btn-danger btn-close" data-dismiss="modal"><?php echo $traduce->traduce('cnodecancela');?></button>
			 </div>
		    </div>
		  </div>
		</div>
	
		<div id="container" role="main">
		    <div class="col-sm-3" >
		    	<input type="text" class="form-control input-sm" placeholder="<?php echo $traduce->traduce('cnodebuscar');?>" id="searchText" name="searchText"/>
		    </div>

			<div style="width: 100%;margin-top:2.5%">  
				<table width="100%" border="1">
					<tr style="background-color: #0365AF;color:#ffffff">
						<td width="50%" style="padding:0 15px 0 15px;font-size:1.3em"><?php echo $traduce->traduce('nestruct');?></td>
						<td width="50%" style="padding:0 15px 0 15px;font-size:1.3em"><?php echo $traduce->traduce('ntpdoc');?></td>
					</tr>
				</table>
				
				<div id="tree-container" class="divarbol"></div>
				<div id="data">
					<div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
					<div class="content folder" style="display:none;"></div>
					<div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
					<div class="content default" style="text-align:center;"></div>
				</div>
				<div id="col-tpdoc" class="divtpdoc"><?php echo $traduce->traduce('cnodedoc');?></div>
			</div>			
			
		</div>
	</body>
	
<script type="text/javascript">
		var indicescrudos = '';
		var nodeact = 0;
		var nodeactindice = 0;
		var workspace =  '<?php echo $workspace;?>';
		$(document).ready(function(){ 
		    //e cargan los indices existentes de la tabla sgd_indices
			var enlacerecep = 'cargalo_documentos.php?otraoperation=dameindicesall'+'&configdb='+configdb+'&workspace='+workspace;      
			$.ajax({
				   type: "GET",
				   async:false, 
				   url: enlacerecep,
				   success: function(msg){       
				   	   indicescrudos = msg;
					   $('#id_tipodoc_indice').html(msg);
				   },
					error: function(x,err,msj){alert(msj) }
				  });	
			//se blanquea el fondo del arbol
		    $(function(){
		        $('body').css('background-color', '#ffffff !important');
		    });

		    $( "#elcuerpotree" ).click(function() {  	
			    $(".jstree-node").each(function(){  
		       		  var idnode = $(this).attr('id'); 
		       		  $('#'+idnode+'_anchor').attr('onclick','verdocumental('+idnode+')');	
		    		});	
		    });	


		    var id_usuario = '<?php echo $id_usuario;?>';  
			//llenamos los usuarios que esta regiostrados 
			var enlacerecep = 'cargalo_documentos.php?otraoperation=dameusuariosreg'+'&configdb='+configdb+'&id_usuario='+id_usuario+'&workspace='+workspace;       
			$.ajax({
				   type: "GET",
				   async:false, 
				   url: enlacerecep,
				   success: function(msg){     // alert(msg);
					   $('#enviara').html(msg);
				   },
					error: function(x,err,msj){alert(msj) }
				  });
		    
		    
 
		});		
		
		$( "#searchText" ).keyup(function() {
		   var text = $(this).val();
		   search(text)
		      
		});
		
		function search(text){ 
		    $('#tree-container').jstree(true).search(text);
		}

		$( "#guardardoc" ).click(function() { 

			var ruta = '<?php echo $ruta;?>';  
			var tablaid = '<?php echo $tablaid;?>';  
			var expedid = '<?php echo $expedid;?>';  
			var id_usuario = '<?php echo $id_usuario;?>';  
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
		$( "#guardarti" ).click(function() {

			 //se capturan los datos id_carpeta id_tipodoc
			 var configdb = '<?php echo $configdb;?>'; 
			 var id_carpeta = $('#id_carpeta').val();
			 var id_tipodoc = $('#id_tipodoc').val();  
			 var workspace ='<?php echo $workspace;?>';
			 if (id_tipodoc != '' && id_carpeta > 0)
			 	{
		 
					var enlacerecep = 'cargalo_documentos.php?operation=guardatipodoc'+'&id_carpeta='+id_carpeta+'&id_tipodoc='+id_tipodoc+'&configdb='+configdb+'&workspace='+workspace;  
					$.ajax({
						   type: "GET",
						   async:false, 
						   url: enlacerecep,
						   success: function(msg){  
								//se verifica si el div de tipodoc esta visible
								if ($("#col-tpdoc").css('display') != 'none' ) 
						 			{
										var enlacerecep = 'cargalo.php?otraoperation=damedocumentalestxt'+'&id_carpeta='+id_carpeta+'&configdb='+configdb;      
										$.ajax({
											   type: "GET",
											   async:false, 
											   url: enlacerecep,
											   success: function(msg){       
												   $('#col-tpdoc').html(msg);
											   },
												error: function(x,err,msj){alert(msj) }
											  });
						 			} 
								
						   },
							error: function(x,err,msj){ }
						  });					
				}
			 $('#myModal').modal('hide');	
			 
			});

			

			//fill data to tree  with AJAX call
		    var tablaid = '<?php echo $tablaid;?>';   
		    var configdb = '<?php echo $configdb;?>';    
		    var ruta = '<?php echo $ruta;?>'; 
		    $('#tree-container').jstree({
					'core' : {
							'data' : {
									'url' : 'cargalo_documentos.php?operation=get_node&tablaid='+tablaid+'&configdb='+configdb+'&workspace='+workspace,
									'data' : function (node) {
										return { 'id' : node.id };
									}
								},
							'check_callback' : true,
							'themes' : {
								'responsive' : false
							}
						},
						'force_text' : true,
						'plugins' : ['state','dnd','wholerow','search']
					});	
	    function armador() { //le coloca el disparador a los nodos 

		    	$(".jstree-node").each(function(){  
		       		  var idnode = $(this).attr('id'); 
		       		  $('#'+idnode+'_anchor').attr('onclick','verdocumental('+idnode+')');	
		    		});	
				//se recorre de nuevo para verificar que tengan el atributo
				$(".jstree-node").each(function(){  ///jstree-node
		       		  var idnode = $(this).attr('id'); 
		       		  if ($('#'+idnode+'_anchor').attr('onclick') != '' )
		       		  	{
		       				window.clearInterval(repeticion);
		       				$('.jstree-icon').addClass('sombraicono');
		       				$('#tree-container').fadeIn('slow');
		       				$('#tituloarbol').fadeIn('slow');
		       		  	}  	
		       		 
		    		});
	    	}
		

		    
		function verdocumental(idnode){
				var configdb = '<?php echo $configdb;?>'; 
				var tablaid = '<?php echo $tablaid;?>'; 
				var expedid = '<?php echo $expedid;?>';
				var workspace = '<?php echo $workspace;?>'; 
				 
				//$tablaid $expedid
				//se buscan los datoas de los tipos documentales				
					 if (nodeact != idnode)
					 	{
						 	nodeact = idnode;
						 	var enlacerecep = 'cargalo_documentos.php?otraoperation=damedocumentalestxt'+'&id_carpeta='+idnode+'&configdb='+configdb+'&tablaid='+tablaid+'&expedid='+expedid+'&workspace='+workspace;      
							$.ajax({
								   type: "GET",
								   async:false, 
								   url: enlacerecep,
								   success: function(msg){       
									   $('#col-tpdoc').html(msg);
								   },
									error: function(x,err,msj){alert(msj) }
								  });
							//se verifica si esta o no visible
							if ($("#col-tpdoc").css('display') == 'none' ) 
						 		{  
									$('#tituloarbol').width('40%'); 
						 			$('#tree-container').width('50%');
						 			$('#col-tpdoc').width('25%');						 			
									$("#col-tpdoc").fadeIn('slow');						
						 		}
					 	}
					 else
					 	{	 	
						 	 $('#col-tpdoc').html('');
						 	 nodeact = 0;
							 if ($("#col-tpdoc").css('display') != 'none' ) 
						 		{  
									$("#col-tpdoc").fadeOut('slow');	
									$('#tree-container').width('100%');
									$('#tituloarbol').width('100%'); 
						 			$('#col-tpdoc').width('0%');						
						 		}
					 	} 		
					 $('#col-indices').html('');
					 nodeactindice = 0;
					if ($("#col-indices").css('display') != 'none') 
					 {  
						$("#col-indices").fadeOut('slow');
						$('#col-indices').width('0%');	
					 }				 	 	
		}
	function verindices(idtpdoc,idnodein){ 
		var configdb = '<?php echo $configdb;?>'; 
		var workspace =  '<?php echo $workspace;?>'; 
		//se buscan los datoas de los tipos documentales		
		//alert(nodeactindice+' '+idnodein); 		
		if (nodeactindice != idtpdoc)
	 		{
				nodeactindice = idtpdoc;  
				var enlacerecep = 'cargalo_documentos.php?otraoperation=dameindicestxt'+'&id_carpeta='+idnodein+'&configdb='+configdb+'&idtpdoc='+idtpdoc+'&workspace='+workspace;      
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){           
						   $('#col-indices').html(msg);
					   },
						error: function(x,err,msj){alert(msj) }
					  });	
				//se verifica si esta o no visible
				if ($("#col-indices").css('display') == 'none' ) 
			 		{  
						$("#col-indices").fadeIn('slow');	
						$('#col-indices').width('20%');						
			 		}
	 		}
		else
			{
				 $('#col-indices').html('');
				 nodeactindice = 0;
				if ($("#col-indices").css('display') != 'none') 
				 {  
					$("#col-indices").fadeOut('slow');
					$('#col-indices').width('0%');	
				 }		 		
			}
	}	 

	
	function cargadocumentos(idtpdoc,idnode,tablaid,expedid){
		var configdb = '<?php echo $configdb;?>'; 
		var titdoc = '<?php echo $traduce->traduce('titdoc');?>'; 
		var workspace = '<?php echo $workspace;?>'; 
		
		$('#id_tipodoc').val(idtpdoc); 
		$('#id_folder').val(idnode);
		$('#id_tabla').val(tablaid);
		$('#id_expediente').val(expedid);
		$('#titulodocumentep').html(titdoc+' '+$('#tpdoc_'+idtpdoc).text());

    	//se buscan los indices que tenga registrados la carpeta seleccionada
		var enlacerecep = 'cargalo_documentos.php?otraoperation=dameindicesitems'+'&id_carpeta='+idnode+'&configdb='+configdb+'&idtpdoc='+idtpdoc+'&tablaid='+tablaid+'&expedid='+expedid+'&workspace='+workspace;      
		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){         
				   $('#indicesitems').html(msg);

				   $('.bsdatepicker').css('z-index','99999999');
				   
				   $(function() { "use strict";
				        $('.bootstrap-datepicker').bsdatepicker({
				            format: 'dd-mm-yyyy'
				        });
				    });
			   },
				error: function(x,err,msj){alert(msj) }
			  });
		  
		$('#modaldocumentos').modal('show');   
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
	
	 var repeticion =  window.setInterval("armador()",3000);
</script>
</html>