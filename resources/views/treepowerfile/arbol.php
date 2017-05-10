<?php
 //  $tablaid = $_REQUEST['tablaid']; 
  // $tiposdocumentales = $_REQUEST['tiposdocumentales'];  //echo $tiposdocumentales;
   $tiposdocumentales = explode("_;_",$tiposdocumentales);
   echo  $tablaid;
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		
		<style>
				html, body { background-color:#ffffff!important;font-size:10px; font-family:Verdana; margin:0; padding:0; }
				#container { min-width:320px; margin:0px auto 0 auto; background:white; border-radius:0px; padding:0px; overflow:hidden; }
				#tree { float:left; min-width:319px; border-right:1px solid silver; overflow:auto; padding:0px 0; }
				#data { margin-left:320px; }
				#data textarea { margin:0; padding:0; height:100%; width:100%; border:0; background:white; display:block; line-height:18px; }
				#data, #code { font: normal normal normal 12px/18px 'Consolas', monospace !important; }
				
		</style>
	<head>	
	<body style="background-color:#ffffff !important;">
	
	
	         
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
		                           					//echo  '<option value="'.@$datosdoc[0].'">'.@$datosdoc[1].'</option>';
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
					<button id="guardarti" type="button" class="btn btn-primary" >Guardar</button>  
					<button id="cancelarti" type="button" class="btn btn-danger btn-close" data-dismiss="modal">Cancelar</button>
			 </div>
		    </div>
		  </div>
	</div>
	
	
		<div id="container" role="main">
		    <div class="col-sm-3"><input type="text" class="form-control input-sm" placeholder="Buscar..." id="searchText" name="searchText"/></div>
		    
		    
			<div id="tree-container" style=""></div>
			<div id="data">
				<div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
				<div class="content folder" style="display:none;"></div>
				<div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
				<div class="content default" style="text-align:center;"></div>
			</div>
		</div>
	</body>
	
<script type="text/javascript">
		$(document).ready(function(){ 
		    //fill data to tree  with AJAX call
		    var tablaid = '<?php echo $tablaid;?>'
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
					            Tipodoc: {
					                separator_before: false,
					                separator_after: false,
					                label: "Tipos Documentos",
					                action: function (obj) { 
					                	data = $node.id;
					                	$('#id_carpeta').val(data);
					                	nombre = $node.text; 
					                	$('#titulodi').html('Tipos Documentales de  '+nombre);
					                	$('#id_tipodoc option').remove();
					                	var tipocrudo = '<?php echo $tipocrudo;?>'; 
					       			    $("#id_tipodoc").html(tipocrudo);
					       			    $('#id_tipodoc').multiSelect('refresh');	
					                	//se buscan los tipos documentales que tenga registrados la carpeta seleccionada
										var enlacerecep = 'cargalo.php?otraoperation=damedocumentales'+'&id_carpeta='+data;      
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
									        	  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar...'>",
									        	  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar...'>",
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
									       $(".ms-container").append('<i ></i>');
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
									'url' : 'cargalo.php?operation=get_node&tablaid='+tablaid,
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
						
						  $.get('cargalo.php?operation=create_node&tablaid='+tablaid, { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text})
							.done(function (d) {   
							  data.instance.set_id(data.node, d.id);
							})
							.fail(function () {
							  data.instance.refresh();
							});
						}) 
					.on('rename_node.jstree', function (e, data) { 
						  $.get('cargalo.php?operation=rename_node', { 'id' : data.node.id, 'text' : data.text  })
							.fail(function () {
							  data.instance.refresh();
							});
						})	
					.on('delete_node.jstree', function (e, data) {  
						  $.get('cargalo.php?operation=delete_node', { 'id' : data.node.id })
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
		    $(function(){
		        $('body').css('background-color', '#ffffff !important');
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
			 var id_carpeta = $('#id_carpeta').val();
			 var id_tipodoc = $('#id_tipodoc').val(); 
			 if (id_tipodoc != '' && id_carpeta > 0)
			 	{
		 
					var enlacerecep = 'cargalo.php?operation=guardatipodoc'+'&id_carpeta='+id_carpeta+'&id_tipodoc='+id_tipodoc;      
					$.ajax({
						   type: "GET",
						   async:false, 
						   url: enlacerecep,
						   success: function(msg){  
								
						   },
							error: function(x,err,msj){ }
						  });					
				}
			 $('#myModal').modal('hide');	
			 
			});

		$(function() { "use strict";
        $(".multi-select").multiSelect({
        	  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar...'>",
        	  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar...'>",
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
        $(".ms-container").append('<i ></i>');
    });
		

		</script>
</html>
