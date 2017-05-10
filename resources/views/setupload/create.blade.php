@extends('admin.template.main')

@section('titulo')
	 {{ trans('principal.nload') }}  
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.nload') }} </h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

<script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>

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
				 
				{!! Form::open(['route'=>'setupload.store','method'=>'POST','class'=>'form-horizontal bordered-row']) !!}
					
					
					<div class="form-group">
	                    {!! Form::label('modobodega',trans('principal.msgconfload'),['class'=>'col-sm-3 control-label']) !!}
	                    <div class="col-sm-6">
	                        <select class="form-control" id="modobodega" name="modobodega" onchange="vermodobodega()">
	                            <option value="powerfile2" selected="selected">Powerfile2</option>
	                            <option value="FTP">FTP</option>
	                             <option value="SFTP">SFTP</option>
	                        </select>
	                    </div>
                	</div>
                
                
                
					<div class="form-group mododebodega">
						{!! Form::label('ftp_server',trans('principal.itemserver'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('ftp_server',null,['class'=>'form-control']) !!} 
						</div>
					</div>
					
					<div class="form-group mododebodega">
						{!! Form::label('ftp_user',trans('principal.itemuserserver'),['class'=>'col-sm-3 control-label']) !!} 
						<div class="col-sm-6">
							{!! Form::text('ftp_user',null,['class'=>'form-control']) !!}
						</div>
					</div>
						
						
					<div class="form-group mododebodega">
	                   {!! Form::label('ftp_pass',trans('principal.itempassserver'),['class'=>'col-sm-3 control-label']) !!}
	                    <div class="col-sm-6">
	                       {!! Form::text('ftp_pass',null,['class'=>'form-control']) !!}
	                    </div>
	           		</div>	
						
					<div class="form-group mododebodega">
						{!! Form::label('ftp_port',trans('principal.itemportserver'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('ftp_port','21',['class'=>'form-control']) !!} 
						</div>
					</div>
						
					<div class="form-group">
	                    {!! Form::label('estatus',trans('principal.itemestatusserver'),['class'=>'col-sm-3 control-label']) !!}    		
	                    <div class="col-sm-6">
	                        <select class="form-control" id="estatus" name="estatus">
	                            <option value="1" >Default</option>
	                            <option value="2" selected="selected">Inactive</option>
	                        </select>
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
					{{ link_to_route('setupload.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
					</div>
					
				{!! Form::close() !!}
					
		
					
				 
	</div>
</div>
<script>

function vermodobodega(){ 
	var modo = $('#modobodega').val();  
	if (modo == 'powerfile2')
		{
			$('.mododebodega').hide(); 
			$('#ftp_server').val('000.000.0.0'); 
			$('#ftp_user').val('powerfile2');   
			$('#ftp_pass').val('powerfile2'); 
			$('#ftp_port').val('21');  
			$('#estatus').val(2);   
			
		}
	else
		{
			if (modo == 'FTP' || modo == 'SFTP')
				{
					$('.mododebodega').show(); 
					$('#ftp_server').val(''); 
					$('#ftp_user').val('');   
					$('#ftp_pass').val(''); 
					$('#ftp_port').val('21');  
					$('#estatus').val(2);  
				}	
		}
	
}
	$(document).ready(function() {

		$('.mododebodega').hide();
		 
		
	});	
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection

