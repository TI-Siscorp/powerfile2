@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.vexpe') }}
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.vexpe') }}</h3>
@endsection

@section('contenido')
<?php
	
	$espaciotrabajo = $_SESSION['espaciotrabajo'];
?>
@inject('permisos','App\helpers\Util')
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
			        
			        {!! Session::forget('mensaje') !!}
			   </div>
		@endif
		
		<div class="example-box-wrapper">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-expediente">
				<thead>
					<tr>
						<th width="5%" >ID</th>
						<th class="centrartexto">{{ trans('principal.titnomayu') }}</th>
						<th class="centrartexto">{{ trans('principal.tablnmayu') }}</th>
						<th width="20%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
						<th  width="20%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
					</tr>
				</thead>
			<tbody>
			@foreach($expedientes as $expediente)
				<tr>
					<td class="centrartexto">{{ $expediente->id_expediente }}</td>
					<td class="izqtexto">{{ $expediente->nombre }}</td>
					<td class="centrartexto">{{ $expediente->nombre_tabla }}</td>
					
					@if ($expediente->nestado == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($expediente->nestado == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $expediente->nestado }}</td>
									@endif			
							@endif	
					<td class="cen
					
					<td class="centrartexto">
					
					@if ($permisos->conocepermisos('view_doc') == true)<a href="{{ url($espaciotrabajo.'/expedientes/documentos',[$expediente->id_expediente,$expediente->id_tabla]) }}" class="btn btn-info" role="button" title="{{ trans('principal.msgdocume') }}"><span class="glyphicon glyphicon-align-left"></span></a>@endif
					@if ($permisos->conocepermisos('delete_exp') == true)<a href="{{ url($espaciotrabajo.'/expedientes/destroy',$expediente->id_expediente) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimdocument') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif
		
		
					 
					</td>
				</tr>
			@endforeach
	
				</tbody>
				</table>
			 
			</div>
	</div>
</div>
</div>
</div>

<script type="text/javascript">
		$(document).ready(function() {
			$('#bppal').attr('data-visor','');

			$('#bppal').attr('data-controller','expedientes'); 
			
			$('#datatable-expediente').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [4]}]});

		});

			$('div.alert').delay(3000).slideUp(300);

			</script>

	<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

	@endsection


