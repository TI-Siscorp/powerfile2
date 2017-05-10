@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.nexp') }} 
@endsection

@section('tituloPagina')
<h3>{{ trans('principal.nexp') }} </h3>
@endsection

<?php
	
	$espaciotrabajo = $_SESSION['espaciotrabajo'];
?>
@section('contenido')
	<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
	<div class="panel">
		<div class="panel-body">
	
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
					
				{!! Form::open(['route'=>'expedientes.store','method'=>'POST','class'=>'form-horizontal bordered-row']) !!}
					
					<div class="form-group">
						{!! Form::label('nombre',trans('principal.titnomayu'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('nombre',null,['class'=>'form-control']) !!}
						</div>
					</div>
						
					<div class="form-group">
						{!! Form::label('id_tabla',trans('principal.tablnmayu'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{{Form::select('id_tabla', $tablas  ,null,['class'=>'form-control'])}}
						</div>
					</div>
			
			
					{{ Form::hidden('id_central', '1', array('id' => 'id_central')) }}
					

					{{ Form::hidden('spider', '1', array('id' => 'spider')) }}
					
					{{ Form::hidden('id_estado', '1', array('id' => 'id_estado')) }}
                		
					
			
					<div class="form-group centrartexto">
						{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!} 
						<a href="{{ url($espaciotrabajo.'/principal') }}" class="btn btn-danger btn-close">{{ trans('principal.btnca') }}</a>
					</div>
					
				{!! Form::close() !!}
					
		
					
					
	</div>
</div>
<script>
$(document).ready(function() {
	$('#bppal').attr('data-visor','');

	$('#bppal').attr('data-controller','expedientes'); 
});
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection

