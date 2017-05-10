@extends('admin.template.main')

@section('titulo')
 	{{ trans('principal.espacio') }}
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.espacio') }}</h3>
@endsection

@section('contenido')

@inject('permisos','App\helpers\Util')

<?php

	$ruta= $permisos->verurl();

?>

<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

<script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>

<style>
	.btn span.glyphicon {    			
		opacity: 0;				
	}
	.btn.active span.glyphicon {				
		opacity: 1;				
	}
	input[type=checkbox] {
	  display: none;
	}
</style>
<div class="panel" style="width: 100%">
	<div class="panel-body">

		@if ($message = Session::get('mensaje'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		
				{!! $message !!}
			 
				{!! Session::forget('mensaje') !!}
			</div>
		@endif

		 <h3 class="title-hero">
            &nbsp;
        </h3>
        
        <iframe id="hacerspace" src="<?php echo $ruta.'/makeworkspace/makeworkspace.php';?>"  height="700" width="100%" style="margin-top:1%" frameborder="0" ></iframe>
        
       
        
        <!--div class="example-box-wrapper">
            <form class="form-horizontal bordered-row">
               <div class="form-group">
                    <label class="col-sm-3 control-label">Name the workspace</label>
                    <div class="col-sm-6">
                        <input type="text" id="workspace" name="workspace" onblur="damenombrebd()" class="form-control popover-button-default" placeholder="Enter the name of the workspace" data-content="Please enter the name of the workspace you want to create" title="Workspace name" data-trigger="focus" data-placement="top">
                    </div>
                </div>
				
				<div class="form-group" style="display:none;">
                    <label class="col-sm-3 control-label">Database Name</label>  
                    <div class="col-sm-6">
                        <input type="text" id="databasename" name="databasename" disabled class="form-control popover-button-default" placeholder="Enter the name of the Database" data-content="Please enter the name of the database that will have the workspace" title="Database name" data-trigger="focus" data-placement="top">
                    </div>
                </div>
				<div class="example-box-wrapper" style="position:relative;text-align: center !important;">
                    <button id="crearws" onclick="crearlo()" class="btn btn-primary active" type="button">Create</button>
                </div>
				
            </form>
        </div-->
		
	</div>
</div>

<script type="text/javascript">
	/*function crearlo(){  
		var databasename = $('#workspace').val(); //$('#databasename').val();
		var workspace = $('#workspace').val();
		var ruta = 	'{{ $ruta }}';
		if (workspace != '' && databasename != '')
			{
				$('#fondomodal').show();
				
				//var enlacerecep = 'indagador.php';
				//var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=descargartodo'+'&d1='+td1+'&d2='+td2+'&iddoc='+d+'&idusuario='+idusuario;
				//var enlacerecep = ruta+'/public/makeworkspace/indagador.php';  //alert(enlacerecep);
				var enlacerecep = 'indagador.php';  //alert(enlacerecep);
				$.ajax({
					async:true, 
					type:'post', 
					complete:function(request, json) { 
					  var response1 = request.responseText;     alert(response1);
					  $('#fondomodal').hide();
					  if (response1 == '0')
						{
							alert('Already exists a workspace with that name, please enter a different name');
						}
					 else
						{
							alert('The new workspace was created successfully');
						}	
					  
					  $('#databasename').val('');
					  $('#workspace').val('');
					}, 
					 url:enlacerecep,  
					 data: {ip: 'crearespacios',workspace:workspace,databasename:databasename}
				})
		
			}
	} 
	function damenombrebd(){  //alert('sami');
		var workspace = $('#workspace').val();
		if (workspace != '')
			{
				$('#databasename').val(workspace);   alert(workspace);
			}
	}
	 
*/
</script>
@endsection