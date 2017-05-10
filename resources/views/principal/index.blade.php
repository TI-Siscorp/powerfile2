@extends('admin.template.main')

@section('titulo')
 	{{ trans('principal.inicio') }}
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.inicio') }}</h3>
@endsection

@section('contenido')

@inject('permisos','App\helpers\Util')

<?php
		
	$ruta= $permisos->verurl(); //'http://'.$_SERVER['SERVER_NAME'];
	
	$espaciotrabajo = $_SESSION['espaciotrabajo'];
	
	
?>

<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

<script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>

<style>
	.btn span.glyphicon {    			
		opacity: 0;				
	}
	.btn.active span.glyphicon {				
		opacity: 1;				
	}
	input[type=checkbox] {
	  display: none;
	}
</style>
<div class="panel" style="width: 100%">
	<div class="panel-body">

		@if ($message = Session::get('mensaje'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		
				{!! $message !!}
			 
				{!! Session::forget('mensaje') !!}
			</div>
		@endif

		<!--div class="example-box-wrapper">
			<div class="panel"-->
   				<!--div class="panel-body"-->
                	<div class="center-vertical">
						<div class="center-content row">
							<div class="col-md-6 wow bounceInDown center-margin ancho100">
						    	<div class="server-message">
						    		@if ($permisos->conocepermisos('add_exp') == true)
						    			@if ($permisos->siencrypt() == true )
						    			 
						    				<a href="{{ url($espaciotrabajo.'/expedientes/create') }}" class="btn btn-primary" role="button" style="position:relative;float:left;margin-bottom:1%">{{ trans('principal.nexp') }}</a>
						    				<!--a href="{{ route('expedientes.create') }}" class="btn btn-primary" role="button" style="position:relative;float:left;margin-bottom:1%">{{ trans('principal.nexp') }}</a-->
						    			@endif		
						    		@endif	
						    		
						    		@if ($permisos->conocepermisos('view_exp') == true)
						    			@if ($permisos->siencrypt() == true )
						    				<a href="{{ url($espaciotrabajo.'/expedientes') }}" class="btn btn-info" role="button" style="position:relative;float:left;margin-bottom:1%;margin-left:1%;margin-right:2%">{{ trans('principal.vexp') }}</a>
						    			@endif	
						    		@endif	
						    		
						    	
							    		<div id="checkmuro" class="checkbox checkbox-primary" style="width:5%;position:relative;float:left" title="{{ trans('principal.mmuro') }}">
							    			  
		                                     <input type="checkbox" id="vermodog" class="habilitados vision"  value="g"/>
		                                     <label for="vermodog">&nbsp;</label>
											 
	                                	</div>		
							
									<!--iframe id="sami" style="border:1px solid #666CCC" title="PDF in an i-Frame" src="<?php echo $ruta.'/img/descargas/test.pdf';?>" frameborder="1" scrolling="auto" height="1100" width="850" ></iframe-->
									
						            	<div class="input-group mrg25B mrg10T input-group-lg">
						                	<input id="buscar" name="buscar" type="text" placeholder="{{ trans('principal.search')}}" class="form-control" >
						                        <div class="input-group-btn">
						                            <button id="buscavisor" type="button" class="btn btn-default" tabindex="-1" >
						                                <i class="glyph-icon icon-search sombraicono icoverd" ></i>
						                            </button>
						                        </div>
						                </div>
						                    <!--button class="btn btn-lg btn-success">Return to previous page</button--> 
						              								                
						     	</div>
					        </div>
					    </div>
					</div>		
				<!--/div-->
			<!--/div>	 
		</div-->
	</div>
</div>

<script type="text/javascript">
	var esmovil = false;
	$(document).ready(function() {
		$('#bppal').attr('data-visor','');

		$('#bppal').attr('data-controller','principal'); 

		esmovil= is_mobile();   
		
		if (esmovil == true)
			{
				$('#checkmuro').attr('style','width:5%;position:relative;left:40%')
			}

		//se limpia la carpeta de descargas del usuario
		
		var idusuario = '{{ Session::get("id_usuario") }}'; 
				
		var ruta = 	'{{ $ruta }}';
		
		/////// se limpia la carpeta de imagenes del usuario
		$('#fondomodal').show();
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=limpiarlo'+'&idusuario='+idusuario;   
		$.ajax({
		   type: "GET",
		   async:false, 
		   url: enlacerecep,
		   success: function(msg){  

			   $('#fondomodal').hide();	   				   
		   },
			error: function(x,err,msj){alert(msj) }
		  });
		 //////// 

		
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

	
	
</script>
@endsection