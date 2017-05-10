<?php
	@session_start();
	$tablaid = $_REQUEST['tablaid'];
	$ruta = $_REQUEST['ruta']; 
	$tiposdocumentales = $_REQUEST['tiposdocumentales'];
	$tiposdocumentales = explode("_;_",@$tiposdocumentales);
	$configdb = $ruta;
	$valor = $_SESSION['lenguaje'];  //echo $valor;
	require('traduccion_arbol.php');
	$traduce = new Traduccion_arbol();
	
	$espaciotrabajo = $_SESSION['espaciotrabajo']; //echo $espaciotrabajo;
	$workspace =   $_SESSION['espaciotrabajo'];
	
		
?>
<!DOCTYPE html>
<html>
	<head>
		<html lang = 'esp'>
	
		<meta charset='utf-8'/>
		
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
				  text-shadow: 5px 5px 5px #aaa;
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
				
				
		</style>
	<head>	
	<body id="elcuerpotree" style="background-color:#ffffff !important;font-size:13px !important">
	
	
	         
		<!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="titulodi" lass="modal-title"></h4> 
			        </div>
			        <div class="modal-body">
			        
				          <div class="form-group">
				          	<input id="id_carpeta" type="hidden" name="id_carpeta"> 
		                    <label class="col-sm-3 control-label"></label>
		                    <div class="col-sm-6" style="width:100% !important;">
		                        <select id="id_tipodoc" multiple class="multi-select" name="id_tipodoc">
		                        	<?php
		                        		$tipocrudo = '';
		                        		for ($i = 0; $i < count($tiposdocumentales); $i++) {
		                        			$datosdoc = explode("_,_",$tiposdocumentales[$i]);
		                        			if (@$datosdoc[0] > 0)
		                        				{
		                           					$tipocrudo .= '<option value="'.@$datosdoc[0].'">'.@$datosdoc[1].'</option>'; 
		                        				}	
		                        		}?>
		                        </select>
	                    	</div>
	                      </div>
		      </div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		      
		      <div class="form-group centrartexto">
					<button id="guardarti" type="button" class="btn btn-primary" ><?php echo $traduce->traduce('cnodeguardar');?></button>  
					<button id="cancelarti" type="button" class="btn btn-danger btn-close" data-dismiss="modal"><?php echo $traduce->traduce('cnodecancela');?></button>
			 </div>
		    </div>
		  </div>
		</div>
	
	<!-- para los indices de los tipos documentales-->
		<!-- Modal -->
		  <div class="modal fade" id="modalindice" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="tituloindice" lass="modal-title"></h4> 
			        </div>
			        <div class="modal-body">
			        
				          <div class="form-group">
				          	<input id="id_carpetaindice" type="hidden" name="id_carpetaindice"> 
				          	<input id="id_tipodocindice" type="hidden" name="id_tipodocindice"> 
				          	
		                    <label class="col-sm-3 control-label"></label>
		                    <div class="col-sm-6" style="width:100% !important;">
		                        <select id="id_tipodoc_indice" multiple class="multi-select" name="id_tipodoc_indice">
		                        	
		                        </select>
	                    	</div>
	                      </div>
		      </div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		      
		      <div class="form-group centrartexto">
					<button id="guardarindice" type="button" class="btn btn-primary" ><?php echo $traduce->traduce('cnodeguardar');?></button>  
					<button id="cancelarinduice" type="button" class="btn btn-danger btn-close" data-dismiss="modal"><?php echo $traduce->traduce('cnodecancela');?></button>
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
						<td width="25%" style="padding:0 15px 0 15px;font-size:1.3em"><?php echo $traduce->traduce('ntpdoc');?></td>
						<td width="25%" style="padding:0 15px 0 15px;font-size:1.3em"><?php echo $traduce->traduce('nindice');?></td>
					</tr>
				</table>
				
				<div id="tree-container" class="divarbol"></div>
				<div id="data">
					<div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
					<div class="content folder" style="display:none;"></div>
					<div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
					<div class="content default" style="text-align:center;"></div>
				</div>
				<div id="col-tpdoc" class="divtpdoc">documentales</div>
				<div id="col-indices" class="divindice">indices</div>
			</div>			
			
		</div>
	</body>
	
<script type="text/javascript">
		var indicescrudos = '';
		var nodeact = 0;
		var nodeactindice = 0;
		$(document).ready(function(){ 
		    
			//e cargan los indices existentes de la tabla sgd_indices
			var enlacerecep = 'cargalo.php?otraoperation=dameindicesall'+'&configdb='+configdb;      
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
 
		});		
		
		$( "#searchText" ).keyup(function() {
		   var text = $(this).val();
		   search(text)
		      
		});
		
		function search(text){ 
		    $('#tree-container').jstree(true).search(text);
		}

		$( "#guardarti" ).click(function() {

			 //se capturan los datos id_carpeta id_tipodoc
			 var configdb = '<?php echo $configdb;?>'; 
			 var id_carpeta = $('#id_carpeta').val();
			 var id_tipodoc = $('#id_tipodoc').val(); 
			 var tablaid = '<?php echo $tablaid;?>'; 

			 var workspace = '<?php echo $workspace;?>'; 
			 
			 if (id_tipodoc != '' && id_carpeta > 0)
			 	{
		 
					var enlacerecep = 'cargalo.php?operation=guardatipodoc'+'&id_carpeta='+id_carpeta+'&id_tipodoc='+id_tipodoc+'&configdb='+configdb+'&tablaid='+tablaid;   //alert(enlacerecep);
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
			//se busca el valor para el contexto segun el idioma
			var cnnode = '<?php echo $traduce->traduce('cnnode');?>'; 
			var cenode = '<?php echo $traduce->traduce('cenode');?>'; 
			var ceditnode = '<?php echo $traduce->traduce('ceditnode');?>'; 
			var ntpdoc = '<?php echo $traduce->traduce('ntpdoc');?>';  
		    var ctpdocnode = '<?php echo $traduce->traduce('ctpdocnode');?>';
			var cnodebuscar = '<?php echo $traduce->traduce('cnodebuscar');?>';
		    //alert('cargalo.php?operation=get_node&tablaid='+tablaid+'&configdb='+configdb);
		    $('#tree-container').jstree({
					//'plugins': ["wholerow", "checkbox"],
					
					contextmenu: {         
					    "items": function($node) {
					        var tree = $("#tree-container").jstree(true);   
					        return {
					           Create: {
					                separator_before: false,
					                separator_after: false,
					                label: cnnode,
					                action: function (obj) { 
					                    $node = $("#tree-container").jstree('create_node', $node);
					                    $("#tree-container").jstree('edit', $node);
					                }
					            },
					            Rename: {
					                separator_before: false,
					                separator_after: false,
					                label: ceditnode,
					                action: function (obj) { 
					                	$("#tree-container").jstree('edit', $node);
					                }
					            },                         
					            Remove: {
					                separator_before: false,
					                separator_after: true,
					                label: cenode,
					                action: function (obj) { 
					                	$("#tree-container").jstree('delete_node', $node);
					                }
					            },
					            Tipodoc: {
					                separator_before: false,
					                separator_after: false,
					                label: ntpdoc,
					                action: function (obj) { 
					                	data = $node.id;
					                	$('#id_carpeta').val(data);
					                	nombre = $node.text; 
					                	$('#titulodi').html(ctpdocnode+' '+nombre);
					                	$('#id_tipodoc option').remove();
					                	var configdb = '<?php echo $configdb;?>'; 
					                	var tipocrudo = '<?php echo $tipocrudo;?>'; 
					       			    $("#id_tipodoc").html(tipocrudo);
					       			    $('#id_tipodoc').multiSelect('refresh');	
					                	//se buscan los tipos documentales que tenga registrados la carpeta seleccionada
										var enlacerecep = 'cargalo.php?otraoperation=damedocumentales'+'&id_carpeta='+data+'&configdb='+configdb;      
										$.ajax({
											   type: "GET",
											   async:false, 
											   url: enlacerecep,
											   success: function(msg){   
												    var vectordatos = msg.split('_;_'); 
												   $('#id_tipodoc option').each(function (){
													    var option_val = this.value;   
													    if(jQuery.inArray(option_val, vectordatos) != -1)
															{	
													    	 	$("#id_tipodoc option[value=" + this.value + "]").attr("selected", 1);
															}    
													});							
											   },
												error: function(x,err,msj){alert(msj) }
											  });
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
									        	});
									       $(".ms-container").append('<i ><img class="img-circle" width="25" src="<?php echo $ruta;?>/img/17858-200.png" alt="" style="position:relative;left: 3%;margin-top: 20% !important;"></i>');
									    });

										  
					                    $('#myModal').modal('show');
					                    
					                }
					            },      
					           /* move: {
					                separator_before: false,
					                separator_after: false,
					                label: "Mover",
					                action: function (obj) { 
					                	$("#tree-container").jstree('copy_node', $node);
					                }
					            },
					            pegar: {
					                separator_before: false,
					                separator_after: false,
					                label: "Pegar",
					                action: function (obj) { 
					                	$("#tree-container").jstree('move_node', $node);
					                }
					            },*/
					        };
					    }
					},  //contextmenu
		
						
						'core' : {
							'data' : {
									'url' : 'cargalo.php?operation=get_node&tablaid='+tablaid+'&configdb='+configdb,
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
						'plugins' : ['state','dnd','contextmenu','wholerow','search']
					})
					.on('create_node.jstree', function (e, data) { 
						
						  $.get('cargalo.php?operation=create_node&tablaid='+tablaid+'&configdb='+configdb, { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text})
							.done(function (d) { //alert(d.id);
							  data.instance.set_id(data.node, d.id);
							})
							.fail(function () {
							  data.instance.refresh();
							});
						}) 
					.on('rename_node.jstree', function (e, data) { 
						  $.get('cargalo.php?operation=rename_node'+'&configdb='+configdb, { 'id' : data.node.id, 'text' : data.text  })
						  .done(function (d) {   
							  data.instance.refresh();
							})
							.fail(function () {
							  data.instance.refresh();
							});
						})	
					.on('delete_node.jstree', function (e, data) {  
						  $.get('cargalo.php?operation=delete_node'+'&configdb='+configdb, { 'id' : data.node.id })
							.fail(function () {
							  data.instance.refresh();
							});
						})
					/*.on('move_node.jstree', function (e, data) {
							$.get('cargalo.php?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent, 'position' : data.position })
								.fail(function () {
									data.instance.refresh();
								});
						})
					.on('copy_node.jstree', function (e, data) { 
							$.get('cargalo.php?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent, 'position' : data.position })
								.always(function () {
									data.instance.refresh();
								});
						})	*/
						;		
	
		    /*$( "#elcuerpotree" ).click(function() {

		    	$(".jstree-node").each(function(){  ///jstree-node
		       		  var idnode = $(this).attr('id'); 
		       		  $('#'+idnode+'_anchor').attr('onclick','verdocumental('+idnode+')');	
		    		});	

		    });	*/

		    
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
				//se buscan los datoas de los tipos documentales				
					 if (nodeact != idnode)
					 	{
						 	nodeact = idnode;
						 	var enlacerecep = 'cargalo.php?otraoperation=damedocumentalestxt'+'&id_carpeta='+idnode+'&configdb='+configdb;      
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
		//se buscan los datoas de los tipos documentales		
		//alert(nodeactindice+' '+idnodein); 		
		if (nodeactindice != idtpdoc)
	 		{
				nodeactindice = idtpdoc;  
				var enlacerecep = 'cargalo.php?otraoperation=dameindicestxt'+'&id_carpeta='+idnodein+'&configdb='+configdb+'&idtpdoc='+idtpdoc;      
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

	$( "#guardarindice" ).click(function() {

		 //se capturan los datos 
		 var configdb = '<?php echo $configdb;?>'; 
		 var id_carpeta = $('#id_carpetaindice').val();
		 var id_tipodoc = $('#id_tipodocindice').val(); 
		 var id_indices = $('#id_tipodoc_indice').val();

		 if (id_indices != '' && id_carpeta > 0 && id_tipodoc > 0)
		 	{
	 
				var enlacerecep = 'cargalo.php?operation=guardatipodocindice'+'&id_carpeta='+id_carpeta+'&id_tipodoc='+id_tipodoc+'&configdb='+configdb+'&id_indices='+id_indices;  // alert(enlacerecep);    
				$.ajax({
					   type: "GET",
					   async:false, 
					   url: enlacerecep,
					   success: function(msg){  
						   //se verifica si el div de indice esta visible, de ser asi se  cargan los indices de ese tipo documental
						   if ($("#col-indices").css('display') != 'none' ) 
			 					{ 
								   	var enlacerecep = 'cargalo.php?otraoperation=dameindicestxt'+'&id_carpeta='+id_carpeta+'&configdb='+configdb+'&idtpdoc='+id_tipodoc;      
									$.ajax({
										   type: "GET",
										   async:false, 
										   url: enlacerecep,
										   success: function(msg){           
											   $('#col-indices').html(msg);
										   },
											error: function(x,err,msj){alert(msj) }
										  });
			 					}
					   },
						error: function(x,err,msj){ }
					  });					
			}
		 $('#modalindice').modal('hide');	
		 
		});

	
	function cargaindices(idtpdoc,idnode){

		var cnodebuscar = '<?php echo $traduce->traduce('cnodebuscar');?>';
		var cnodeindn = '<?php echo $traduce->traduce('cnodeindice');?>'; 
		
		$('#id_carpetaindice').val(idnode);
		$('#id_tipodocindice').val(idtpdoc);

		$('#tituloindice').html(cnodeindn+' '+$('#tpdoc_'+idtpdoc).text());

		$("#id_tipodoc_indice").html(indicescrudos);
		$('#id_tipodoc_indice').multiSelect('refresh');	
    	//se buscan los indices que tenga registrados la carpeta seleccionada
		var enlacerecep = 'cargalo.php?otraoperation=dameindices'+'&id_carpeta='+idnode+'&configdb='+configdb+'&idtpdoc='+idtpdoc;      
		$.ajax({
			   type: "GET",
			   async:false, 
			   url: enlacerecep,
			   success: function(msg){   
				    var vectordatosind = msg.split('_;_'); 
				   $('#id_tipodoc_indice option').each(function (){
					    var option_val = this.value;   
					    if(jQuery.inArray(option_val, vectordatosind) != -1)
							{	
					    	 	$("#id_tipodoc_indice option[value=" + this.value + "]").attr("selected", 1);
							}    
					});							
			   },
				error: function(x,err,msj){alert(msj) }
			  });
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
	        	});
	       //$(".ms-container").append('<i ><img class="img-circle" width="25" src="<?php echo $ruta;?>/img/17858-200.png" alt="" style="position:relative;left: 3%;margin-top: 20% !important;"></i>');
	    });
		$('#modalindice').modal('show');   
	}
	 var repeticion =  window.setInterval("armador()",3000);
</script>
</html>