<?php
@session_start();
$tablaid = $_REQUEST['id_tabla']; //$_REQUEST['dependenciaid'];
$dependenciaid = $_REQUEST['dependenciaid'];
$valor = $_SESSION['lenguaje'];
$ruta = $_REQUEST['ruta'];   
$configdb = $ruta;
require('traduccion_arbol.php');
$traduce = new Traduccion_arbol();


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		  <script type="text/javascript" charset="utf8" src="<?php echo $ruta;?>/js/jquery/jquery-1.8.2.min.js"></script>
	
		  <link rel="stylesheet" href="<?php echo $ruta;?>/assets/bootstrap/css/bootstrap.css">
		  
		  <script src="<?php echo $ruta;?>/js/bootstrap.min.js"></script>
		  		  
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/widgets/multi-select/multiselect.css">
	
		  <link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.css">
		  
		  <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/multi-select/multiselect.js"></script>
		  <script type="text/javascript" src="<?php echo $ruta;?>/js/quicksearch/jquery.quicksearch.js"></script>
	
		  <script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.js"></script>
		
		
		<link rel="stylesheet" href="dist/themes/default/style.css" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/icons/fontawesome/fontawesome.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/icons/linecons/linecons.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/css/estilo_powerfile.css">
		
		
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
				    width:50% ;
				    display:none;
				}
				.divgrupuser{
					position:relative;
				   	margin-top:1%;
				    float:left;
				    width:50% ;
				    display:none;
				}
				.icon-exchange{
					 display:none;
				}
				
				
				td { text-align: center; }
				
				
		</style>
	<head>	
	<body id="elcuerpotree" style="background-color:#ffffff !important;font-size:13px !important">
	
		<div id="container" role="main">
		    <div class="col-sm-3" >
		    	<input type="text" class="form-control input-sm" placeholder="<?php echo $traduce->traduce('cnodebuscar');?>" id="searchText" name="searchText"/>
		    </div>

			<div style="width: 100%;margin-top:2.5%">  
				<table width="100%" border="1">
					<tr style="background-color: #0365AF;color:#ffffff">
						<td width="50%" style="padding:0 15px 0 15px;font-size:1.3em"><?php echo $traduce->traduce('nestruct');?> </td>
						<td width="50%" style="padding:0 15px 0 15px;font-size:1.3em"><?php echo $traduce->traduce('inputusu');?> </td>
					</tr>
				</table>
				
				
				<div id="tree-container" class="divarbol"></div>
				<div id="data">
					<div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
					<div class="content folder" style="display:none;"></div>
					<div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
					<div class="content default" style="text-align:center;"></div>
				</div>
				
				<div id="grupos-user" class="divgrupuser">
				
					<div class="form-group">
	                    <!--label for="usuarios_grupo" class="col-sm-3 control-label"><?php echo $traduce->traduce('inputusu');?></label-->
	                    <div class="col-sm-6" style="width:100% !important;">
	                    	<select class="multi-select" multiple="multiple" name="usuarios_grupo[]" id="usuarios_grupo" >
	                    	
	                    	</select>
	                    	<script type="text/javascript">
		                    	 var configdb = '<?php echo $configdb;?>';    

								 var id_tabla = '<?php echo $tablaid;?>';
		                    	 
		                    	//cargamos los usuarios registrados
		        				var enlacerecep = 'cargalo_permisos.php?otraoperation=damusuarios'+'&configdb='+configdb+'&id_tabla='+id_tabla;     
		        				$.ajax({
		        					   type: "GET",
		        					   async:false, 
		        					   url: enlacerecep,
		        					   success: function(msg){   
		        					   		$('#usuarios_grupo').html(msg);  
		        					   },
		        						error: function(x,err,msj){ }
		        				});
	                    	</script>
	                    </div>
	            	</div>
	            	<br><br><br>&nbsp;
	            	<div class="form-group centrartexto">
							<button id="guardarti" type="button" class="btn btn-primary" ><?php echo $traduce->traduce('cnodeguardar');?></button>  
							<button id="cancelarti" type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $traduce->traduce('cnodecancela');?></button>
					 </div>
				
				</div>
				
			</div>			
			
		</div>
	</body>
	
<script type="text/javascript">
		var indicescrudos = '';
		var nodeact = 0;
		var nodeactindice = 0;
		var cnodebuscar = '<?php echo $traduce->traduce('cnodebuscar');?>';
		$(document).ready(function(){ 
		    
			
			//se blanquea el fondo del arbol
		    $(function(){
		        $('body').css('background-color', '#ffffff !important');
		    });

		    /*$( "#elcuerpotree" ).click(function() {  	
		    	var dependenciaid = '<?php echo $dependenciaid;?>';	
			    $(".jstree-node").each(function(){  
		       		  var idnode = $(this).attr('id'); 
		       		 $('#'+idnode+'_anchor').attr('onclick','grabarpermiso('+idnode+','+dependenciaid+')');	
		    		});	
		    });	*/
 
		});		
		
		$( "#searchText" ).keyup(function() {
		   var text = $(this).val();
		   search(text)
		      
		});
		
		function search(text){ 
		    $('#tree-container').jstree(true).search(text);
		}

	

			$(function() { "use strict";
	        $(".multi-select").multiSelect({
	        	  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='"+cnodebuscar+"'>",
	        	  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='"+cnodebuscar+"'>",
	        	  afterInit: function(ms){
	        	    var that = this,
	        	        $selectableSearch = that.$selectableUl.prev(),
	        	        $selectionSearch = that.$selectionUl.prev(),
	        	        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
	        	        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
	
	        	    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
	        	    .on('keydown', function(e){
	        	      if (e.which === 40){
	        	        that.$selectableUl.focus();
	        	        return false;
	        	      }
	        	    });
	
	        	    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
	        	    .on('keydown', function(e){
	        	      if (e.which == 40){
	        	        that.$selectionUl.focus();
	        	        return false;
	        	      }
	        	    });
	        	  },
	        	  afterSelect: function(){
	        	    this.qs1.cache();
	        	    this.qs2.cache();
	        	  },
	        	  afterDeselect: function(){
	        	    this.qs1.cache();
	        	    this.qs2.cache();
	        	  }
	        	});
	        $(".ms-container").append('<i ><img class="img-circle" width="25" src="<?php echo $ruta;?>/img/17858-200.png" alt="" style="position:relative;left: 3%;margin-top: 20% !important;"></i>');
	    });

			//fill data to tree  with AJAX call
		    var tablaid = '<?php echo $tablaid;?>';
		    var configdb = '<?php echo $configdb;?>';    
		    var ruta = '<?php echo $ruta;?>'; 
		    $('#tree-container').jstree({
					//'plugins': ["wholerow", "checkbox"],
					
					contextmenu: {         
					    "items": function($node) {
					        var tree = $("#tree-container").jstree(true);   
					        return {
					           Create: {
					                separator_before: false,
					                separator_after: false,
					                label: "Crear Nuevo",
					                action: function (obj) { 
					                    $node = $("#tree-container").jstree('create_node', $node);
					                    $("#tree-container").jstree('edit', $node);
					                }
					            },
					            Rename: {
					                separator_before: false,
					                separator_after: false,
					                label: "Editar",
					                action: function (obj) { 
					                	$("#tree-container").jstree('edit', $node);
					                }
					            },                         
					            Remove: {
					                separator_before: false,
					                separator_after: true,
					                label: "Elmiminar",
					                action: function (obj) { 
					                	$("#tree-container").jstree('delete_node', $node);
					                }
					            },
					        };
					    }
					},  //contextmenu
					"checkbox" : {
					      "keep_selected_style" : false
					    },
						
						'core' : {
							'data' : {
									'url' : 'cargalo_permisos.php?operation=get_node&tablaid='+tablaid+'&configdb='+configdb,
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
						'plugins' : ['state','wholerow','search','checkbox']
					});		
	
		    
	    function armador() { //le coloca el disparador a los nodos 
			//limpiamos los check del arbol
			$('.jstree-anchor').removeClass('jstree-clicked');

			var tablaid = '<?php echo $tablaid;?>';
	    	var dependenciaid = '<?php echo $dependenciaid;?>';
			var vidfolders = '';
			//se cre un arreglo con los id q estan en la tabla de dependencias x folder
			var enlacerecep = 'cargalo_permisos.php?otraoperation=damefolders'+'&iddependencia='+dependenciaid+'&configdb='+configdb+'&tablaid='+tablaid;   
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){  
					   		vidfolders = msg;
					   },
						error: function(x,err,msj){ }
					  });
			var veidfolders = vidfolders.split(',');
			   
	    	
		    	$(".jstree-node").each(function(){  
		       		  var idnode = $(this).attr('id'); 
					  if (jQuery.inArray( idnode, veidfolders ) > -1)
					  	{
						 	 $('#'+idnode+'_anchor').addClass('jstree-clicked');
					  	}
		       		  //$('#'+idnode+'_anchor').attr('onclick','grabarpermiso('+idnode+','+dependenciaid+')');	
		    		});	
				//se recorre de nuevo para verificar que tengan el atributo
				$(".jstree-node").each(function(){  ///jstree-node
		       		  var idnode = $(this).attr('id'); 
		       		  if ($('#'+idnode+'_anchor').attr('onclick') != '' )
		       		  	{
		       				window.clearInterval(repeticion);
		       				$('.jstree-icon').addClass('sombraicono');
		       				$('#tree-container').fadeIn('slow');
		       				$('#grupos-user').fadeIn('slow');
		       				$('#tituloarbol').fadeIn('slow');
		       		  	}  	
		       		 
		    		});
	    	}
    function grabarpermiso(idfolder,iddependencia){  
		//se verifica si esta o no chuleado
		var tablaid = '<?php echo $tablaid;?>';

		var usuarios_grupo = $('#usuarios_grupo').val();  

		if (usuarios_grupo != null) 
			{
		
				var totalu = usuarios_grupo.length;
		
				var tirauser = '';
				 
				for (var i = 0; i < totalu; i++) {
					tirauser += usuarios_grupo[i]+'_;_';
				}
		 
		
		
					if ($('#'+idfolder+'_anchor').hasClass( "jstree-clicked" ))
						{   //se borra
							//se buscan los hijos de este nodo
							 var children = $('#'+idfolder).find("li");
				
							  var idchildren = '';
							    for (var i = 0; i < children.length; i++) {
							    	idchildren += children[i].id+',';
							    };
							////
							//se buscan los padres de este nodo
							var idparents = '';
								 $('#'+idfolder).parents("li").each(function () {
									 idparents +=$(this).attr("id")+',';
								});
							///
						
							var enlacerecep = 'cargalo_permisos.php?operation=borradepenfolder'+'&id_carpeta='+idfolder+'&iddependencia='+iddependencia+'&configdb='+configdb+'&tablaid='+tablaid+'&idchildren='+idchildren+'&idparents='+idparents+'&usuarios_grupo='+tirauser;  
							$.ajax({
								   type: "GET",
								   async:false, 
								   url: enlacerecep,
								   success: function(msg){  
									   
								   },
									error: function(x,err,msj){ }
								  });
						}
					else
						{	//se graba el permiso
			
							//se buscan los hijos de este nodo
							 var children = $('#'+idfolder).find("li");
			
							  var idchildren = '';
							    for (var i = 0; i < children.length; i++) {
							    	idchildren += children[i].id+',';
							    };
							////
							//se buscan los padres de este nodo
							var idparents = '';
								 $('#'+idfolder).parents("li").each(function () {
									 idparents +=$(this).attr("id")+',';
								});
							///
							var enlacerecep = 'cargalo_permisos.php?operation=guardadepenfolder'+'&id_carpeta='+idfolder+'&iddependencia='+iddependencia+'&configdb='+configdb+'&tablaid='+tablaid+'&idchildren='+idchildren+'&idparents='+idparents+'&usuarios_grupo='+tirauser;  
							$.ajax({
								   type: "GET",
								   async:false, 
								   url: enlacerecep,
								   success: function(msg){  
									   
								   },
									error: function(x,err,msj){ }
								  });
						}
			}	
		else
			{			
				alert('debe seleccionar al menos un usuario');
			}		
    }		


    
	 var repeticion =  window.setInterval("armador()",3000);

	 /* Multiselect inputs */

	    $(function() { "use strict";
	        $(".multi-select").multiSelect({
	        	  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='"+cnodebuscar+"'>",
	        	  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='"+cnodebuscar+"'>",
	        	  afterInit: function(ms){
	        	    var that = this,
	        	        $selectableSearch = that.$selectableUl.prev(),
	        	        $selectionSearch = that.$selectionUl.prev(),
	        	        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
	        	        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

	        	    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
	        	    .on('keydown', function(e){
	        	      if (e.which === 40){
	        	        that.$selectableUl.focus();
	        	        return false;
	        	      }
	        	    });

	        	    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
	        	    .on('keydown', function(e){
	        	      if (e.which == 40){
	        	        that.$selectionUl.focus();
	        	        return false;
	        	      }
	        	    });
	        	  },
	        	  afterSelect: function(){
	        	    this.qs1.cache();
	        	    this.qs2.cache();
	        	  },
	        	  afterDeselect: function(){
	        	    this.qs1.cache();
	        	    this.qs2.cache();
	        	  }
	        	}

	                );
	        $(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
	    });

	    $( "#guardarti" ).click(function() {

			 //se capturan los datos 
			 var configdb = '<?php echo $configdb;?>'; 
			 
			 var id_tabla = '<?php echo $tablaid;?>';

			 var ruta = '<?php echo $ruta;?>';
			 
			 var idfolder = '';   
			 
			 var iddependencia = '<?php echo $dependenciaid;?>';   
			 
			 var usuarios_grupo = $('#usuarios_grupo').val();   

			 var ctluser = 0;

			 var exitopermi = '<?php echo $traduce->traduce('exitopermi');?>'; 

			 var limpiapermi = '<?php echo $traduce->traduce('limpiapermi');?>';  
			 
			 if (usuarios_grupo != null)
			 	{	
					 var totalu = usuarios_grupo.length;
		
					 var tirauser = '';
		
					 
						 
					 for (var i = 0; i < totalu; i++) {
						tirauser += usuarios_grupo[i]+'_;_';
						ctluser = 1;
					 }
			 	}
			 else
			 	{		 
				 	ctluser = 0;
			 	}
			 
			 $(".jstree-node").each(function(){  
	       		  var idnode = $(this).attr('id'); 
			      if ($('#'+idnode+'_anchor').hasClass('jstree-clicked')) //esta seleccionado se agrega a los id de folder a permisar
			      	{
			    	  	idfolder += idnode+'_;_';
			      	}				      	
			});

			 $(".jstree-undetermined").each(function(){ 

				 $(this).parents("a").each(function () {
					var miid = $(this).attr("id");
					miid = miid.split('_');
					
					idfolder += miid[0]+'_;_';
				});		      	
			});	
			 

				
		if (idfolder != '' && ctluser == 1)
			{
				//se registran los datos de los folders a permisar para esa dependencia y usuarios
				var enlacerecep = 'cargalo_permisos.php?otraoperation=guardadepenfolderlote'+'&id_carpeta='+idfolder+'&iddependencia='+iddependencia+'&configdb='+configdb+'&tablaid='+id_tabla+'&usuarios_grupo='+tirauser;  
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){ 

						  		var script ='<div class="alert alert-success permisoexito">';
						  		
						  		script +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
									
						  		script += exitopermi;
									
						  		script += '</div>';

						  		window.parent.abrirmensaje(script);
						   
					   },
						error: function(x,err,msj){ }
				});
			}
		else
			{
				//se evalua que no tenga nada y se manda a limpiar los permisos de esa dependencia (todos)
				var enlacerecep = 'cargalo_permisos.php?otraoperation=borradepenfolderlote'+'&iddependencia='+iddependencia+'&configdb='+configdb+'&tablaid='+id_tabla;
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){ 
	
						  		 
								var script ='<div class="alert alert-success permisoexito">';
						  		
						  		script +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
									
						  		script += limpiapermi;
									
						  		script += '</div>';

						  		window.parent.abrirmensaje(script);
						  		var url = ruta+'/treepowerfile2/arbol_permisos.php?dependenciaid='+iddependencia+'&id_tabla='+id_tabla+'&ruta='+ruta;
							    window.parent.ejecutarcierrepermisos(url);
						   
					   },
						error: function(x,err,msj){ }
				});
			}

	    });
		
	    $( "#cancelarti" ).click(function() {

			 //se capturan los datos id_carpeta id_tipodoc
			 var configdb = '<?php echo $configdb;?>'; 
			 var id_tabla = '<?php echo $tablaid;?>';

			 var ruta = '<?php echo $ruta;?>';
			 var dependenciaid = '<?php echo $dependenciaid;?>'; 
		     var url = ruta+'/treepowerfile2/arbol_permisos.php?dependenciaid='+dependenciaid+'&id_tabla='+id_tabla+'&ruta='+ruta;
		     window.parent.ejecutarcierrepermisos(url);
		});


	    
</script>
</html>