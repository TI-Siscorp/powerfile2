@extends('admin.template.main')

@section('titulo')
Tipos de indices
@endsection

@section('tituloPagina')
<h3>Tipos de Indices</h3>
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
	
	
		<a href="{{ route('tiposindices.create') }}" class="btn btn-primary" role="button">Nuevo Tipo de Indice</a>
		<br>
		<br>
		<div class="example-box-wrapper">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-permiso">
				<thead>
				<tr>
				<th width="5%" >ID</th>
				<th class="centrartexto">NOMBRE</th>
				<th width="20%" class="centrartexto">ESTADO</th>
				<th  width="10%" class="centrartexto">Acciones</th>
				</tr>
				</thead>
				<tbody>
					@foreach($tiposindices as $tipol)
						<tr>
						<td class="centrartexto">{{ $tipol->id_tipo }}</td>
						<td class="izqtexto">{{ $tipol->nombre }}</td>
						<td class="centrartexto">{{ $tipol->descripcion }}</td>
						<td class="centrartexto"><a href="{{ route('tiposindices.edit',$tipol->id_tipo) }}" class="btn btn-primary" role="button" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;<a href="{{ route('tiposindices.destroy',$tipol->id_tipo) }}" class="btn btn-danger" role="button" title="Eliminar" onclick="return confirm('¿Esta seguro de eliminar el Tipo de Indice?')"><span class="glyphicon glyphicon-trash"></span></a></td>
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
		
			 	$('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]});
		
			 });
		
			 	$('div.alert').delay(3000).slideUp(300);

	 	</script>

	 	<script type="text/javascript" src="assets/widgets/datatable/datatable.js"></script>
	 	<script type="text/javascript" src="assets/widgets/datatable/datatable-bootstrap.js"></script>
	 	<script type="text/javascript" src="assets/widgets/datatable/datatable-tabletools.js"></script>

	 	@endsection