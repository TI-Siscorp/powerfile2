@extends('admin.template.main')

@section('titulo')
	Editar Tipo de Item
@endsection

@section('tituloPagina')
	<h3>Editar Tipo de Item: {{ $tipoindices->nombre }}</h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
<div class="panel">
	<div class="panel-body">

		{!! Form::model($tipoindices, ['method' => 'PATCH','route' => ['tiposindices.update', $tipoindices->id_tipo],'class'=>'form-horizontal bordered-row']) !!}
		<div class="form-group">
		{!! Form::label('nombre','Nombre',['class'=>'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
		{!! Form::text('nombre',$tipoindices->nombre,['class'=>'form-control']) !!}
		</div>
		</div>
		
		<div class="form-group">
		{!! Form::label('id_estado','Estado',['class'=>'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
		{{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
		</div>
		</div>
		
		<div class="form-group centrartexto" >
		{!! Form::submit('Guardar',['class'=>'btn btn-primary'])!!}
		{{ link_to_route('tiposindices.index', 'Cancelar', '', array('class'=>'btn btn-danger btn-close')) }}
		</div>
		
		
		
		{!! Form::close() !!}
	</div>

</div>
<script type="text/javascript">
	//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
	var id_estadoreg = {{ $tipoindices->id_estado }};
	$("#id_estado option").each(function(){
		if ($(this).val() == id_estadoreg )
			{
				$(this).prop('selected', true);
			}
	});
</script>


	@endsection