@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titvindice') }} 
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.titvindice') }} </h3>
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
		@if ($permisos->conocepermisos('add_indice') == true)
			<a href="{{ route('indices.create') }}" class="btn btn-primary" role="button">{{ trans('principal.nind') }} </a>
		@endif	
		<br>
		<br>
		<div class="example-box-wrapper">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-indices">
				<thead>
					<tr>
						<th width="5%" >ID</th>
						<th class="centrartexto">{{ trans('principal.titnomayu') }}</th>
						<th width="20%" class="centrartexto">{{ trans('principal.tittipomayu') }}</th>
						<th width="20%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
						<th  width="10%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
					</tr>
				</thead>
				<tbody>
				@foreach($indices as $indice)
					<tr>
					<td class="centrartexto">{{ $indice->id_indice }}</td>
					<td class="izqtexto">{{ $indice->nombre }}</td>					
					<td class="izqtexto" >{{ $indice->ntipo }}</td>
					@if ($indice->descripcion == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($indice->descripcion == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $indice->descripcion }}</td>
									@endif			
							@endif	
					<td class="centrartexto">
					 @if ($permisos->conocepermisos('edit_indice') == true)<a href="{{ route('indices.edit',$indice->id_indice) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif
					 @if ($permisos->conocepermisos('delete_indice') == true)<a href="{{ route('indices.destroy',$indice->id_indice) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimindice') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif
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
		
		$('#bppal').attr('data-controller','indices'); 
		
		$('#datatable-indices').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [4]}]});

	});

		$('div.alert').delay(3000).slideUp(300);

</script>

<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

 	@endsection