@extends('admin.template.main')
 
@section('titulo')
	{{ trans('principal.npermis') }} 
 
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.npermis') }} </h3>
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
    	
    	
    	
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif

    {!! Form::open(['route'=>'permisos.store','method'=>'POST','class'=>'form-horizontal bordered-row']) !!}

    	<div class="form-group">
    		{!! Form::label('permiso',trans('principal.msgpermiso'),['class'=>'col-sm-3 control-label']) !!}    		
            <div class="col-sm-6"> 
            	{!! Form::text('permiso',null,['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
    		{!! Form::label('llave','llave',['class'=>'col-sm-3 control-label']) !!}    		
            <div class="col-sm-6">
            	{!! Form::text('llave',null,['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group centrartexto">
    		{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
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
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection

