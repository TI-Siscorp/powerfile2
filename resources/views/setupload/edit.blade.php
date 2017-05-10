@extends('admin.template.main')

@section('titulo')
 {{ trans('principal.editload') }} 
@endsection

@section('tituloPagina')
<h3>{{ trans('principal.editload') }} : {{ $loads->ftp_server }}</h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">  
<div class="panel">
	<div class="panel-body">

		
		{!! Form::model($loads, ['method' => 'PATCH','route' => ['setupload.update', $loads->id_setup],'class'=>'form-horizontal bordered-row']) !!}
	
	
		    <div class="form-group">
	             {!! Form::label('modobodega',trans('principal.msgconfload'),['class'=>'col-sm-3 control-label']) !!}
	             <div class="col-sm-6">
	                <select class="form-control" id="modobodega" name="modobodega" onchange="vermodobodega()">
	                    <option value="powerfile2">Powerfile2</option>
	                    <option value="FTP">FTP</option>
	                    <option value="SFTP">SFTP</option>
	                </select>
	             </div>
             </div>
		    
		    	<div class="form-group mododebodega">
					{!! Form::label('ftp_server',trans('principal.itemserver'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('ftp_server',$loads->ftp_server,['class'=>'form-control']) !!} 
					</div>
				</div>
				
				<div class="form-group mododebodega">
					{!! Form::label('ftp_user',trans('principal.itemuserserver'),['class'=>'col-sm-3 control-label']) !!} 
					<div class="col-sm-6">
						{!! Form::text('ftp_user',$loads->ftp_user,['class'=>'form-control']) !!}
					</div>
				</div>
					
					
				<div class="form-group mododebodega">
                   {!! Form::label('ftp_pass',trans('principal.itempassserver'),['class'=>'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                       {!! Form::text('ftp_pass',$loads->ftp_pass,['class'=>'form-control']) !!}
                    </div>
           		</div>	
					
				<div class="form-group mododebodega">
					{!! Form::label('ftp_port',trans('principal.itemportserver'),['class'=>'col-sm-3 control-label']) !!}
					<div class="col-sm-6">
						{!! Form::text('ftp_port',$loads->ftp_port,['class'=>'form-control']) !!} 
					</div>
				</div>
		
			<div class="form-group">
			      {!! Form::label('id_estado',trans('principal.inputestado'),['class'=>'col-sm-3 control-label']) !!}    		
			      <div class="col-sm-6">
			          {{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
			      </div>
		    </div>	
		    
		    <div class="form-group">
	                    {!! Form::label('estatus',trans('principal.itemestatusserver'),['class'=>'col-sm-3 control-label']) !!}    		
	                    <div class="col-sm-6">
	                        <select class="form-control" id="estatus" name="estatus">
	                            <option value="1" >Default</option>
	                            <option value="2">Inactive</option>
	                        </select>
	                    </div>
                	</div>	
		
				<div class="form-group centrartexto" >
					{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary'])!!}
					{{ link_to_route('setupload.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
				</div>
		
		
		
		{!! Form::close() !!}
	</div>

</div>
<script type="text/javascript">		
	//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
	var id_estadoreg = '{{ $loads->id_estado }}'; 

	var estatus = '{{ $loads->estatus }}'; 

	var modobodega = '{{ $loads->modobodega }}';   
 
	$("#modobodega option").each(function(){  
        if ($(this).val() == modobodega )
            {        
        		$(this).prop('selected', true);
        	}
     });
	
	$("#id_estado option").each(function(){
        if ($(this).val() == id_estadoreg )
            {        
        		$(this).prop('selected', true);
        	}
     });

	$("#iestatus option").each(function(){
        if ($(this).val() == estatus )
            {        
        		$(this).prop('selected', true);
        	}
     });

	function vermodobodega(){ 
		var modo = $('#modobodega').val();  
		if (modo == 'powerfile2')
			{
				$('.mododebodega').hide();  
				
			}
		else
			{
				if (modo == 'FTP' || modo == 'SFTP')
					{
						$('.mododebodega').show(); 
						
					}	
			}
		
	}

	$(document).ready(function() {

		var modo = $('#modobodega').val();  
		if (modo == 'powerfile2')
			{
				$('.mododebodega').hide();
			}
		else
			{
			if (modo == 'FTP')
				{
					$('.mododebodega').show();
				}
			}	
		 
		
	});	

</script>


@endsection