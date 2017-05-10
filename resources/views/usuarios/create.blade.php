@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.nuser') }} 
@endsection

@section('tituloPagina')
<h3>{{ trans('principal.nuser') }} </h3>
@endsection

@section('contenido')



<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
			
		
	 			
			{!! Form::open(['route'=>'usuarios.store','method'=>'POST','class'=>'form-horizontal bordered-row','files'=>true,'enctype' => 'multipart/form-data']) !!} 
			
			
			<div class="form-group centrartexto" >
					{!! Form::label('avatar',trans('principal.navatar'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						<div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" id="vistaprevia" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <a href="javascript:;"  class="fileinput-exists glyphicon glyphicon-remove icoremover" id="resetear" data-dismiss="fileinput" style="position:relative;float:right"></a>
                         	<div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">{{ trans('principal.savatar') }}</span>  
                                    <span class="fileinput-exists">{{ trans('principal.mcamb') }}</span>
                                   {!! Form::file('avatar', array('multiple'=>false)) !!} 
                                </span>
                                
                         	</div>
                        </div>						
					</div> 
			</div>
			
			
				
				<div class="form-group">
					{!! Form::label('name',trans('principal.inputnombre'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('name',null,['class'=>'form-control']) !!} 
					</div> 
				</div>
				
				<div class="form-group">
					{!! Form::label('lastname',trans('principal.inputapellido'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('lastname',null,['class'=>'form-control']) !!}
					</div>
				</div>	
				
				<div class="form-group">
					{!! Form::label('cedula',trans('principal.inputced'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('cedula',null,['class'=>'form-control']) !!}
					</div>
				</div>	
				
				<div class="form-group">
					{!! Form::label('login',trans('principal.inputlogin'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('login',null,['class'=>'form-control']) !!}
					</div>
				</div>		
					
				<div class="form-group">
					{!! Form::label('email',trans('principal.inputmail'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::email('email',null,['class'=>'form-control']) !!}
					</div>
				</div>	
				
				<div class="form-group">
					{!! Form::label('password',trans('principal.inputclave'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::password('password',['class'=>'form-control awesome']) !!}
					</div>
				</div>	
				
				<div class="form-group">
					{!! Form::label('password_confirm',trans('principal.inputconfcla'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::password('password_confirm',['class'=>'form-control awesome']) !!}
					</div>
				</div>	
				
				<div class="form-group">
					{!! Form::label('celular',trans('principal.inputcel'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('celular',null,['class'=>'form-control']) !!}
					</div>
				</div>	
				
				<div class="form-group">
					{!! Form::label('fijo',trans('principal.inputfijo'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('fijo',null,['class'=>'form-control']) !!}
					</div>
				</div>	
				
				 
				<div class="form-group">
	                   {!! Form::label('direccion',trans('principal.inputdir'),['class'=>'col-sm-3 control-label']) !!}
	                    <div class="col-sm-6">
	                        {!! Form::textarea('direccion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
	                    </div>
	             </div>
					
				<div class="form-group">
					{!! Form::label('id_rol',trans('principal.inputrol'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{{Form::select('id_rol', $roles  ,null,['class'=>'form-control'])}}
					</div>
				</div>		
					
					 
				<div class="form-group">
					{!! Form::label('id_estado',trans('principal.inputestado'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
					</div>
				</div>
					
				
					
					
					
				<div class="form-group centrartexto">
					{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
					{{ link_to_route('usuarios.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
					
					
				</div>
					
			{!! Form::close() !!}
				
			
				
			 
  </div>
</div>
<!-- dropzone -->

<script type="text/javascript" src="{{ asset('assets/widgets/dropzone/dropzone.js') }}"></script>
	
<script>
	$(document).ready(function () {

		$('#bppal').attr('data-visor','');
		
		 $('#bppal').attr('data-controller','usuario'); 
		 
		 $('#password').bind('blur', function () { 
			 //se valida con su confirmacion
			if ($('#password').val() != '' && $('#password_confirm').val() != '')
				{
					if ($('#password').val() != $('#password_confirm').val() )
						{
							alert('{{ trans("principal.msgerrorclave") }}');
							$('#password').val('');
							$('#password_confirm').val('');
						}
				}
		});
		 $('#password_confirm').bind('blur', function () { 
			 //se valida con su confirmacion
			if ($('#password').val() != '' && $('#password_confirm').val() != '')
				{
					if ($('#password').val() != $('#password_confirm').val() )
						{
							alert('{{ trans("principal.msgerrorclave") }}');
							$('#password').val('');
							$('#password_confirm').val('');
						}
				}
		});

	}); 		

    if (window.FileReader) {
	       function seleccionArchivo(evt) { //avatar vistaprevia
	         var files = evt.target.files;
	         var f = files[0];    
	         var leerArchivo = new FileReader();
	         document.getElementById('resetear').style.display= 'block';
	           leerArchivo.onload = (function(elArchivo) {
	             return function(e) {   
	               document.getElementById('vistaprevia').innerHTML = '<img src="'+ e.target.result +'" alt="" width="150" />';
	             };
	           })(f);
	    
	           leerArchivo.readAsDataURL(f);
	       }
	      } 
     else 
         {
       		document.getElementById('vistaprevia').innerHTML = '{{ trans("principal.msgerrpreview") }}';
    	 }
    
       document.getElementById('avatar').addEventListener('change', seleccionArchivo, false);
      
       function cancela(elForm){
		 document.getElementById(elForm).reset();
		 if (window.FileReader) 
			{
		 		document.getElementById('vistaprevia').innerHTML = '{{ trans("principal.Preview") }}';
		 	}
		 else
			 {
		 		document.getElementById('vistaprevia').innerHTML = '{{ trans("principal.msgerrpreview") }}';
		 	}
		 document.getElementById('resetear').style.display= 'none';
       }
       
       
       $('#resetear').bind('click', function () {   
			 //se limpia la seleccion de avatar
    	   	$("#avatar").val("");
    	   	$("#resetear").hide();
    	   	$("#vistaprevia").html('');
    	   	
		});
	
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection

