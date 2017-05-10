@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.encryp') }}
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.encryp') }}</h3>
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

		@if ($permisos->conocepermisos('add_depen') == true)
			@if ($numreg == 0)
				<a href="{{ route('key_encrypt.create') }}" class="btn btn-primary" role="button">{{ trans('principal.nuevakey') }}</a>
			@endif	
		@endif
		<br>
		<br>
		<div class="example-box-wrapper">
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-key">
			<thead>
			<tr>
			<th width="5%" >ID</th>
			<th width="10%" class="centrartexto">{{ trans('principal.titfechamayu') }}</th>
			<th width="20%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
			<th  width="20%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
			</tr>
			</thead>
			<tbody>
				@foreach($encrypts as $encrypt)
					<tr>
						<td class="centrartexto">{{ $encrypt->id_encrypt }}</td>
						<td class="izqtexto">{{ $encrypt->created_at }}</td>
						@if ($encrypt->nestado == 'Activo')
							<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
						@else
							@if ($encrypt->nestado == 'Inactivo')
								{
									<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
								}
							@else
									<td class="centrartexto">{{ $encrypt->nestado }}</td>
							@endif
						@endif
						<td class="centrartexto">
							@if ($encrypt->tiene_img == 0)
								@if ($permisos->conocepermisos('edit_encrypt') == true)<a href="{{ route('key_encrypt.edit',$encrypt->id_encrypt) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif
								@if ($permisos->conocepermisos('delete_encrypt') == true)<a href="{{ route('key_encrypt.destroy',$encrypt->id_encrypt) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimencrypt') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif
							@else
								@if ($encrypt->tiene_img > 0)
									&nbsp;
							    @endif	
							@endif
								
								
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

						$('#bppal').attr('data-controller','Key_encrypt');
							
						$('#datatable-key').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]});

					});

						$('div.alert').delay(3000).slideUp(300);

						</script>

						<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
						<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
						<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

						@endsection