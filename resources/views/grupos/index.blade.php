@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.grup') }} 
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.grup') }} </h3>
@endsection

@section('contenido')

@inject('permisos','App\helpers\Util')

<?php
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
	
		@if ($permisos->conocepermisos('add_grupo') == true)
			<a href="{{ route('grupos.create') }}" class="btn btn-primary" role="button">{{ trans('principal.ngrup') }}</a>
			@endif
			<br>
			<br>
			<div class="example-box-wrapper">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-permiso">
					<thead>
						<tr>
							<th width="5%" >ID</th>
							<th class="centrartexto">{{ trans('principal.titnomayu') }}</th>
							<th width="20%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
							<th  width="20%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($grupos as $grupo)
							<tr>
								<td class="centrartexto">{{ $grupo->id_grupo }}</td>
								<td class="izqtexto">{{ $grupo->nombre }}</td>
								
								@if ($grupo->descripcion == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($grupo->descripcion == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $grupo->descripcion }}</td>
									@endif			
								@endif	
								
								<td class="centrartexto">
									@if ($permisos->conocepermisos('edit_grupo') == true)<a href="{{ route('grupos.edit',$grupo->id_grupo) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif
									@if ($permisos->conocepermisos('agrupa_user') == true)<a href="{{ route('grupos.agrupar',$grupo->id_grupo) }}" class="btn btn-warning" role="button" title="{{ trans('principal.titaccion') }}" ><span class="glyphicon glyphicon-user"></span></a>@endif
									@if ($permisos->conocepermisos('delete_grupo') == true)<a  data-b="{{ $grupo->id_grupo }}" href="{{ route('grupos.destroy',$grupo->id_grupo) }} " class="btn btn-danger btnborrar" onclick="return confirm('{{ trans('principal.msgconfelimgrupo') }}')" role="button" title="{{ trans('principal.msgelim') }}" ><span class="glyphicon glyphicon-trash"></span></a>@endif
								</td>
							</tr>
						@endforeach
		
					</tbody>
				</table>
				 
			</div>
	</div>
</div>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$('#bppal').attr('data-visor','');
		
		$('#bppal').attr('data-controller','grupos'); 
			
	$('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]});

	});

	$('div.alert').delay(3000).slideUp(300);
</script>

	
@endsection