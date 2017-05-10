@extends('admin.template.main')
 
@section('titulo')
 {{ trans('principal.editpermi') }}  
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.editpermi') }}: {{ $permiso->permiso }}</h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
<div class="panel">
    <div class="panel-body">

    
     
     {!! Form::model($permiso, ['method' => 'PATCH','route' => ['permisos.update', $permiso->id_permiso],'class'=>'form-horizontal bordered-row']) !!}

        <div class="form-group">
            {!! Form::label('permiso',trans('principal.msgpermiso'),['class'=>'col-sm-3 control-label']) !!}            
            <div class="col-sm-6">
                {!! Form::text('permiso',$permiso->permiso,['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('llave','llave',['class'=>'col-sm-3 control-label']) !!}            
            <div class="col-sm-6">
                {!! Form::text('llave',$permiso->llave,['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group centrartexto" >
            {!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary'])!!}
            {{ link_to_route('permisos.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
        </div>

        

    {!! Form::close() !!}
    </div>
    
</div>
<script>
	$(document).ready(function() {
		$('#bppal').attr('data-visor','');
		
		$('#bppal').attr('data-controller','permisos'); 
	});	
	
</script>
@endsection
