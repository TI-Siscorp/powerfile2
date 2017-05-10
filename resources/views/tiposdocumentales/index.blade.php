@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titvtpdoc') }}  
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.titvtpdoc') }}</h3>
@endsection

@section('contenido')

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
		
				{!! Session::forget('mensajeerror') !!}
			</div>
		@endif
	
		@if ($permisos->conocepermisos('add_tpdoc') == true)
			<a href="{{ route('tiposdocumentales.create') }}" class="btn btn-primary" role="button">{{ trans('principal.ntpdoc') }}  </a>
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
						<th  width="10%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tiposdocumentales as $tipol)
							<tr>
							<td class="centrartexto">{{ $tipol->id_tipodoc }}</td>
							<td class="izqtexto">{{ $tipol->nombre }}</td>
							 @if ($tipol->descripcion == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($tipol->descripcion == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $tipol->descripcion }}</td>
									@endif			
							@endif	 
							<td class="centrartexto">
							@if ($permisos->conocepermisos('edit_tpdoc') == true)<a href="{{ route('tiposdocumentales.edit',$tipol->id_tipodoc) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif
							@if ($permisos->conocepermisos('delete_tpdoc') == true)<a href="{{ route('tiposdocumentales.destroy',$tipol->id_tipodoc) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimtpdoc') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif
							</td>
							</tr>
						@endforeach							
					</tbody>
				</table>
	
		</div>
	</div>
</div>

		<script type="text/javascript">
		$(document).ready(function() {

			$('#bppal').attr('data-visor','');
			
			$('#bppal').attr('data-controller','tiposdocumentales'); 

			$('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]});

		});

			$('div.alert').delay(3000).slideUp(300);

	 	</script>

	 	<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

	 	@endsection