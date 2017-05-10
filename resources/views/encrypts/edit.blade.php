@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titveditdencry') }} 
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.titveditdencry') }}</h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
<div class="panel">
		<div class="panel-body">
		
		
			{!! Form::model($keyencry, ['method' => 'PATCH','route' => ['key_encrypt.update', $keyencry->id_encrypt],'class'=>'form-horizontal bordered-row']) !!}
			
			
			
					<div class="form-group">
						{!! Form::label('valor_key',trans('principal.inputkeyencry'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('valor_key',null,['class'=>'form-control','maxlength','16']) !!}
						</div>
					</div>				
						
					<div class="form-group">
						{!! Form::label('id_estado',trans('principal.inputestado'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
						{{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
						</div>
					</div>
					
					<div class="form-group centrartexto" >
						{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary'])!!}
						{{ link_to_route('dependencias.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
					</div>
			
			
			
			{!! Form::close() !!}
		</div>

</div>
<script type="text/javascript">

//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
		var id_estadoreg = {{ $keyencry->id_estado }};
		$("#id_estado option").each(function(){
			if ($(this).val() == id_estadoreg )
			{
				$(this).prop('selected', true);
			}
		});
		$(document).ready(function() {
			$('#bppal').attr('data-visor','');

			$('#bppal').attr('data-controller','Key_encrypt'); 
		});
</script>


@endsection