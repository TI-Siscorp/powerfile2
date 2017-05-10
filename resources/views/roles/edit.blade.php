@extends('admin.template.main')

@section('titulo')
 {{ trans('principal.editrol') }} 
@endsection

@section('tituloPagina')
<h3>{{ trans('principal.editrol') }} : {{ $roles->nombre }}</h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">  
<div class="panel">
	<div class="panel-body">

		
		{!! Form::model($roles, ['method' => 'PATCH','route' => ['roles.update', $roles->id_rol],'class'=>'form-horizontal bordered-row']) !!}
	
	
		    
			<div class="form-group">
				{!! Form::label('nombre',trans('principal.inputnombre'),['class'=>'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::text('nombre',$roles->nombre,['class'=>'form-control']) !!}
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
					{{ link_to_route('roles.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
				</div>
		
		
		
		{!! Form::close() !!}
	</div>

</div>
<script type="text/javascript">		
	//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
	var id_estadoreg = '{{ $roles->id_estado }}'; 
	$("#id_estado option").each(function(){
        if ($(this).val() == id_estadoreg )
            {        
        		$(this).prop('selected', true);
        	}
     });
	$(document).ready(function() {
		
		$('#bppal').attr('data-visor','');
			
		$('#bppal').attr('data-controller','rol'); 
	});	
</script>


@endsection