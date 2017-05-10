@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.tivexp') }}/{{ trans('principal.msgdocume') }}
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.tivexp') }}/{{ trans('principal.msgdocume') }}</h3>
@endsection

@section('contenido')

@inject('permisos','App\helpers\Util')


<?php
	@session_start();
	
	$configdb = $permisos->verurl();
	
	$ruta= $permisos->verurl();
	
	$workspace = $_SESSION['espaciotrabajo'];
	
	$iusuario = Session::get('id_usuario');   
	
	
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
	
	
	
	
    $ctldioc = 0;
    if ($i['buscar'] == '_;_')
	    {
	    	$abuscar = '';	
	    }
	else 
		{
			$abuscar = $i['buscar'];			
		}
		

		
		
		//dd($expedientes);
?>
<meta charset="UTF-8" />
<!-- Chosen -->

<script type="text/javascript" src="{{{ asset('assets/widgets/chosen/chosen.js')}}}"></script>
<script type="text/javascript" src="{{{ asset('assets/widgets/chosen/chosen-demo.js')}}}"></script>

<script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/spinner/spinner.js') }}"></script>



<style>
	.odd {
		background-color:#ffffff !important;
	}
	
	.even{
		background-color:#ffffff !important;
	}
	
	input.default{
		width: 100%!important;
	}
	
	/* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}
        .spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}
        .spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}
        .spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}
        @-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
   
</style>
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
<div class="panel">
	<div class="panel-body">
	
	
										
		<div class="input-group mrg25B mrg10T input-group-lg" style="width: 50% !important;">
           	<input id="buscar" name="buscar" type="text" placeholder="{{ trans('principal.buscarque') }}" class="form-control" value="{{ $abuscar }}">
            <div class="input-group-btn">
               <button id="buscavisor" type="button" class="btn btn-default" tabindex="-1" >
                  <i class="glyph-icon icon-search sombraicono icoverd" ></i>
               </button>
            </div>       
            <a class="actible" href="javascript:;" id="buscaravanzada">&nbsp;&nbsp;Busqueda avanzada</a>    
        </div>
	
		
		@if ($message = Session::get('mensaje'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				
				{!! $message !!}
					
				{!! Session::forget('mensaje') !!}
			</div>
		@endif
	
	
		<div class="example-box-wrapper">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-expediente">
				<thead>
					<tr>
					<th width="5%" >&nbsp;</th>
					<th class="centrartexto">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				@foreach($expedientes as $expediente)
					<?php
					
					$iddoc = $expediente->id_documento;  
					
					//se verifica que tenga permiso para ver datos de la dependencia y tabla de los documentos filtrados
					
					$usuariosdepermisos = $expediente->usuarios; 
					
					$usuariosdepermisos = explode(",",$usuariosdepermisos);
					
					if (in_array($iusuario, $usuariosdepermisos))
						{
							$permiso_documentos = true;
						}
					else
						{
							$permiso_documentos = false;
						}
					
					if ($permiso_documentos == true)
						{	
					
							$ctldioc = $iddoc;
							
							$nombresindi = $expediente->id_indices;
							
							$nombresindi = explode(',',$nombresindi);  
							
							$valoresindi = $expediente->search;
							
							$valoresindi = explode(',',$valoresindi);  
							
							$nfolder = $expediente->id_node;
							
							
							$ntpdoc = $expediente->id_tipodocumental;
					
							echo '<tr>';
									//se arma la lineas de indices
							$script = '';
							
							$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';
									
												
							for ($i = 0; $i < count($nombresindi); $i++)
								{
									//if ($valoresindi[$i])
									$script .= '<span class="indicesub"><strong>'.@$nombresindi[$i].': </strong></span>'.@$valoresindi[$i].', ';
									
									$scriptventana .= '<span class="indicesub"><strong>'.@$nombresindi[$i].': </strong></span>'.utf8_decode(@$valoresindi[$i]).'<br>';
								}
							$script = trim($script,','); 
									
							?>
									
										<td class="centrartexto">
											<a href="#" class="btn btn-default btn-md popover-button-default" data-content="{{ $scriptventana }}" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">
						                       <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>
						                     </a>
										</td> 
										<td >
										<a href="javascript:;"  id="docexpediente_{{ $expediente->id_documento }}" class="actible" onclick="vervisor(this.id)">{{ $expediente->nombre }}&nbsp;-&nbsp;{{ $nfolder }}&nbsp;-&nbsp;{{ $ntpdoc }})</a>
										<!-- el enlace para compartir visor -->
										<?php
										//$scriptuser = '';
										?>
										
												
								         <br>
										<!-- LOS INDICES Y SUS VALORES-->
										<span><?php echo  $script;?></span>    
										
						                
										<br>
										<span><a href="javascript:;"  id="eldocumento_{{ $expediente->id_documento }}" class="actible" onclick="vervisor(this.id)">{{ trans('principal.titirdoc') }}</span>  <!-- visor-->
										</td>
									 <?php
									
							
							
							echo '</tr>';
						}
					
					?>
				@endforeach
			
					</tbody>
			</table>
	
		</div>
	</div>
</div>
<script type="text/javascript" src="{{{ asset('assets/widgets/datatable/datatable.js') }}} "></script>
<script type="text/javascript" src="{{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}}  "></script>
<script type="text/javascript" src="{{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}}  "></script>

<script type="text/javascript">

	$(function() { "use strict";
		$(".spinner-input").spinner();
	});
	$(document).ready(function() {

		$('#bppal').attr('data-visor','visor_lista');

		$('#bppal').attr('data-controller','expedientes'); 
		
		$('#datatable-expediente').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0]}]});
	
	});

	
	function devuelve(buscar){  
		if (buscar == '')
			{
				buscar = '_;_';
			}
		var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
		
		window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+buscar+'/visor_lista';	
	}
	 
	/*$(".visor").click(function() {

		/*var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
		
		/*var buscar = $('#buscar').val();  

		var puedever = '{{ $sevearch }}';   
		
		if (buscar == '')
			{
			buscar = '_;_';
			}
		buscar = buscar.replace(/%/g, '_..._');
		
		var id_documento = $(this).attr('id').split('_');	
	

		if (puedever == '1')
			{	
				window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+id_documento[1]+'/'+buscar+'/visor_listado';
			}
		else
			{
				if (puedever == '0')
					{	
						alert('Unable to connect to ftp');
					}	
			}	
		
	});	*/

	function vervisor(id){  
		
		var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
		
		var buscar = $('#buscar').val();  

		var puedever = '{{ $sevearch }}';   
		
		if (buscar == '')
			{
			buscar = '_;_';
			}
		buscar = buscar.replace(/%/g, '_..._');

		buscar = buscar.replace('/', '_..._');

		buscar = $.trim(buscar);
		
		var id_documento = id.split('_');	
	
		
		
		if (puedever == '1')
			{	
				window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+id_documento[1]+'/'+buscar+'/visor_listado';
			}
		else
			{
				if (puedever == '0')
					{	
						alert('Unable to connect to ftp');
					}	
			}	
	}

	$('#buscaravanzada').bind('click', function () {

		var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';

		var buscar = $('#buscar').val();
		if (buscar == '')
			{
				buscar = '_;_';
			}
		
		window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+buscar+'/0/visor_arbol';	
			
	});
	
	

	$('#buscavisor').bind('click', function () {

		var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
		
		var ejecutar = $.trim($('#buscar').val());

		if (ejecutar.length >=3)
			{
				if (ejecutar == ''){ejecutar='_;_';}
				ejecutar = ejecutar.replace(/%/g, '_..._');
				ejecutar = ejecutar.replace('/', '_...._');
		
				
				if ($('#vermodog').prop('checked') == true)
					{
						window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+ejecutar+'/visor';	
					}
				else
					{
						window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+ejecutar+'/visor_lista';	
					}	 
			}		
	});

	$('#buscar').keyup(function(e) {
		if(e.which == 13) 
			{ 
				
				var ejecutar = $.trim($('#buscar').val());
				
				if (ejecutar.length >=3)
					{
						var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
						
						if (ejecutar == ''){ejecutar='_;_';}
						ejecutar = ejecutar.replace(/%/g, '_..._');
						ejecutar = ejecutar.replace('/', '_...._');
						
						if ($('#vermodog').prop('checked') == true)
							{
								window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+ejecutar+'/visor';	
							}
						else
							{
								window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+ejecutar+'/visor_lista';	
							}	 
					}	
			}
		
				
	});

	
	
	
	$('div.alert').delay(3000).slideUp(300);
</script>


@endsection


