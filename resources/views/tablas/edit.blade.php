@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titvedittabl') }}  
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.titvedittabl') }}: {{ $tablas->nombre_tabla }}</h3>
@endsection

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
			
		{!! Form::model($tablas, ['method' => 'PATCH','route' => ['tablas.update', $tablas->id_tabla],'class'=>'form-horizontal bordered-row']) !!}
			
			
			
			<div class="form-group">
						{!! Form::label('nombre_tabla',trans('principal.inputnombre'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('nombre_tabla',null,['class'=>'form-control']) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('version',trans('principal.inputversion'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('version',null,['class'=>'form-control']) !!}
						</div>
					</div>
						
						
					<div class="form-group">
	                   {!! Form::label('descripcion',trans('principal.inputdescrip'),['class'=>'col-sm-3 control-label']) !!}
	                    <div class="col-sm-6">
	                        {!! Form::textarea('descripcion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
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
				{{ link_to_route('tablas.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
			</div>
			
			
			
		{!! Form::close() !!}
	</div>

</div>
<script type="text/javascript">
		//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
		var id_estadoreg = {{ $tablas->id_estado }};
		$("#id_estado option").each(function(){
			if ($(this).val() == id_estadoreg )
			{
				$(this).prop('selected', true);
			}
		});
		$(document).ready(function() {

			$('#bppal').attr('data-visor','');
				
			$('#bppal').attr('data-controller','tabla'); 
		});	
	</script>


	@endsection