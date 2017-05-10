@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.msgdocume') }}
@endsection

@inject('permisos','App\helpers\Util')


@section('tituloPagina')
	<h3>{{ trans('principal.msgdocumeexp') }}: {{ $expedientes->nombre }}</h3>
@endsection

<?php
	$ruta= $permisos->verurl();
?>

@section('contenido')
	<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}"> 
	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/multi-select/multiselect.css') }}">
		  
    <script type="text/javascript" src="{{ asset('assets/widgets/multi-select/multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('dist/themes/default/style.css') }} " />
	<script type="text/javascript" src="{{ asset('dist/jstree.js') }} "></script>
	
	
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
	
	
	<div class="panel"> 
	    <div class="panel-body">
	      
			<iframe src="{{ $ruta }}/treepowerfile2/arbol_documentos.php?tablaid={{ $tablaid }}&expedid={{ $expedid }}&ruta={{ $ruta }}&id_usuario={{ $id_usuario }}"  height="700" width="100%" style="margin-top:1%" frameborder="0" ></iframe>
	    </div>
	</div>
	<script type="text/javascript" src="{{ asset('assets/widgets/colorpicker/colorpicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/widgets/colorpicker/colorpicker-demo.js') }}"></script>	
	<script type="text/javascript" src="{{ asset('assets/widgets/spinner/spinner.js') }}"></script>
	
		
	<script type="text/javascript">	
	$(document).ready(function() {
		$('#bppal').attr('data-visor','');

		$('#bppal').attr('data-controller','expedientes'); 
	});
		$('div.alert').delay(3000).slideUp(300);	

		function Dios(elvalorb){

			 var ruta = '{{ $ruta }}';

			 var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
			 
			 window.location.href = ruta+'/'+espaciotrabajo+'/expedientes/'+elvalorb+'/visor_lista';
			 
		}
	</script>	
	
@endsection
