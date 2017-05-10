@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.infosys') }}
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.infosys') }}</h3>
@endsection

@section('contenido')

@inject('permisos','App\helpers\Util')

<?php
	@session_start();
	$ruta= $permisos->verurl();
?>	
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

		<br>
		<br>
		<div class="example-box-wrapper">
		      <iframe id="paddimg" src="<?php echo $ruta.'/treepowerfile2/info.php';?>"  height="700" width="100%" style="margin-top:1%" frameborder="0" ></iframe>
        </div>
	 </div>           
 </div>



@endsection
