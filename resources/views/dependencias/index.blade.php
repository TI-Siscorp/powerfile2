@extends('admin.template.main')
 
@section('titulo')
 {{ trans('principal.depe') }} 
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.depe') }}</h3>
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
    
    		@if ($permisos->conocepermisos('add_depen') == true)
    			<a href="{{ route('dependencias.create') }}" class="btn btn-primary" role="button">{{ trans('principal.nuevadepe') }}</a>
    		@endif		
    		<br>
    		<br>
    		<div class="example-box-wrapper">
    				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-dependencias">
                      <thead>
                        <tr>
                            <th width="5%" >ID</th>
                            <th width="10%" class="centrartexto">{{ trans('principal.titcodimayu') }}</th>
                            <th class="centrartexto">{{ trans('principal.titnomayu') }}</th>
                            <th width="20%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
                            <th  width="20%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dependencias as $dependencia)
                        	<tr>
                            <td class="centrartexto">{{ $dependencia->id_dependencia }}</td>
                            <td class="izqtexto">{{ $dependencia->codigo_departamento }}</td>
                            <td class="centrartexto">{{ $dependencia->descripcion }}</td>
                            @if ($dependencia->nestado == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($dependencia->nestado == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $dependencia->nestado }}</td>
									@endif			
							@endif	                          
                            <td class="centrartexto">
                            @if ($permisos->conocepermisos('edit_depen') == true)<a href="{{ route('dependencias.edit',$dependencia->id_dependencia) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif
                            @if ($permisos->conocepermisos('view_folders') == true)<a href="{{ route('dependencias.estructura',$dependencia->id_dependencia) }}" class="btn btn-info" role="button" title="{{ trans('principal.msgetru') }}"><span class="glyphicon glyphicon-align-left"></span></a>@endif	
                            @if ($permisos->conocepermisos('delete_depen') == true)<a href="{{ route('dependencias.destroy',$dependencia->id_dependencia) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimdepende') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif	
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

			$('#bppal').attr('data-controller','dependencias'); 
			
        $('#datatable-dependencias').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]});

     });
	 
	$('div.alert').delay(3000).slideUp(300);
	
</script>

<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

@endsection