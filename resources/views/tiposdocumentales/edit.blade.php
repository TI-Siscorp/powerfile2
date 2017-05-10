@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titvedittpdoc') }}  
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.titvedittpdoc') }} : {{ $tiposdocumentales->nombre }}</h3>
@endsection
  
@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
<div class="panel">
	<div class="panel-body">
	
		{!! Form::model($tiposdocumentales, ['method' => 'PATCH','route' => ['tiposdocumentales.update', $tiposdocumentales->id_tipodoc],'class'=>'form-horizontal bordered-row']) !!}
			
			<div class="form-group">
					{!! Form::label('nombre',trans('principal.inputnombre'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('nombre',null,['class'=>'form-control']) !!}
					</div>
				</div>
		
				<div class="form-group">
					{!! Form::label('id_estado',trans('principal.inputestado'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
					</div>
				</div>
				
				<div class="form-group">
                      {!! Form::label('color',trans('principal.inputcolor'),['class'=>'col-sm-3 control-label']) !!}
                     <div class="col-sm-8">
                       <div class="row">                           
                           <div class="col-md-6">
                           		{!! Form::text('color',null,array('id' => 'colorpicker-tl','class'=>'form-control')) !!}
                           </div>
                        </div>
                    </div>
                </div>
		
				<div class="form-group">
	                   {!! Form::label('descripcion',trans('principal.inputdescrip'),['class'=>'col-sm-3 control-label']) !!}
	                    <div class="col-sm-6">
	                        {!! Form::textarea('descripcion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
	                    </div>
	           		</div>
		
		
		
				<div class="form-group centrartexto">
					{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
					{{ link_to_route('tiposdocumentales.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
				</div>
		
		
		{!! Form::close() !!}
	</div>

</div>
<script type="text/javascript" src="{{ asset('assets/widgets/colorpicker/colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/colorpicker/colorpicker-demo.js') }}"></script>
<script type="text/javascript">
		//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
			var id_estadoreg = {{ $tiposdocumentales->id_estado }};
			$("#id_estado option").each(function(){
				if ($(this).val() == id_estadoreg )
				{
					$(this).prop('selected', true);
				}
			});
			$(document).ready(function() {

				$('#bppal').attr('data-visor','');
				
				$('#bppal').attr('data-controller','tiposdocumentales');
			});	 
	
	</script>


	@endsection