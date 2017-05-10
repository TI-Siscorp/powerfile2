@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.permi') }} 
@endsection
@inject('permisos','App\helpers\Util')


@section('tituloPagina')
	<h3>{{ trans('principal.titvpermis') }} : {{ $dependencias->descripcion }}</h3>
@endsection

<?php

	$ruta= $permisos->verurl();

?>

@section('contenido')
	<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}"> 
	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/multi-select/multiselect.css') }}">
		  
			  
    <script type="text/javascript" src="{{ asset('assets/widgets/multi-select/multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('dist/themes/default/style.css') }} " />
	<script type="text/javascript" src="{{ asset('dist/jstree.js') }} "></script>
	
		
		@if ($message = Session::get('mensaje'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				
					{!! $message !!}
				
					{!! Session::forget('mensaje') !!}
				</div>
		@endif
			
			
			
		@if ($message = Session::get('mensajeerror'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		
				{!! $message !!}
		
				{!! Session::forget('mensajeerror') !!}
			</div>
		@endif
		
		<div id="mensajes" class="mensajes" style="display:none"></div>
		
			
	
	<div class="panel"> 
	    <div class="panel-body">
	    
	      <div class="form-group" style="width: 40%">
				{!! Form::label('id_tabla',trans('principal.tabln'),['class'=>'col-sm-3 control-label']) !!}
				<div class="col-sm-6" style="margin-left: 1%">
					{{Form::select('id_tabla', $tablas  ,null,['class'=>'form-control'])}}
				</div>
		 </div>
			<?php
				
			
			echo '<iframe id="apermisos" src=""  height="700" width="100%" style="margin-top:1%;display:none" frameborder="0" ></iframe>';
			
			?>
			
	    </div>
	</div>


	
<script type="text/javascript">	

	$(document).ready(function() {
		$('#bppal').attr('data-visor','');
	
		$('#bppal').attr('data-controller','dependencias'); 
	});
	var id_tabla = 0;
	function armador() { //se busca si solo se esta entrando a la ventana

	id_tabla = $('#id_tabla').val();  

	if (id_tabla > 0)
		{
			window.clearInterval(repeticion);
			var ruta = '{{ $ruta }}' ; 
			var dependenciaid = '{{ $dependenciaid }}';
			var url = ruta+'/treepowerfile2/arbol_permisos.php?dependenciaid='+dependenciaid+'&id_tabla='+id_tabla+'&ruta='+ruta; 
		    $('#apermisos').attr('src', url);
		    $('#apermisos').show();		
		}
}
	
	
	$('#id_tabla').change(function () {
		var ruta = '{{ $ruta }}'
		var dependenciaid = '{{ $dependenciaid }}'
	    var id_tabla = $('#id_tabla').val();
	    var url = ruta+'/treepowerfile2/arbol_permisos.php?dependenciaid='+dependenciaid+'&id_tabla='+id_tabla+'&ruta='+ruta;
	    $('#apermisos').attr('src', url);
	    $('#apermisos').show();
	});

function ejecutarcierrepermisos(url){
	 $('#apermisos').attr('src', url);
     $('#apermisos').show();
}


function abrirmensaje(script){
	
	 $('#mensajes').html(script);

	 $('#mensajes').show();

	 $('div.mensajes').delay(3000).slideUp(300);
	
	
}



 var repeticion =  window.setInterval("armador()",1000);
 
 $('div.alert').delay(3000).slideUp(300);	

	
 
 
</script>	
	
@endsection
