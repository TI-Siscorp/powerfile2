@extends('admin.template.main')
 
@section('titulo')
 	{{ trans('principal.titpaguser') }}
@endsection

@section('tituloPagina')
    <h3> {{ trans('principal.titpaguser') }}</h3>
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
    
    		
    
    		@if ($permisos->conocepermisos('add_user') == true)
    			<a href="{{ route('usuarios.create') }}" class="btn btn-primary" role="button">{{ trans('principal.nuser') }}</a> 
    		@endif	
    		<br>
    		<br>
    		<div class="example-box-wrapper">
    				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-permiso">
                      <thead>
                        <tr>
                            <th width="5%" >ID</th>
                            <th class="centrartexto">{{ trans('principal.titnomayu') }}</th>
                            <th class="centrartexto">{{ trans('principal.titcorrmayu') }}</th>                               	
                            <th class="centrartexto">{{ trans('principal.titrolmayu') }}</th> 
                            <th width="10%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
                            <th  width="10%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($regusuarios as $usuario)
                        	<tr>
                            <td class="centrartexto">{{ $usuario->id }}</td>
                            <td class="izqtexto">{{ $usuario->name }}&nbsp;{{ $usuario->lastname }}</td>
                            <td class="izqtexto">{{ $usuario->email }}</td>
                            <td class="centrartexto">{{ $usuario->nombre }}</td>
                            @if ($usuario->descripcion == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($usuario->descripcion == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $usuario->descripcion }}</td>
									@endif			
							@endif	  
                            <td class="centrartexto">
                            @if ($permisos->conocepermisos('edit_user') == true)<a href="{{ route('usuarios.edit',$usuario->id) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif 
                            @if ($permisos->conocepermisos('delete_user') == true)<a href="{{ route('usuarios.destroy',$usuario->id) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelim') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif	
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
 
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

 <script type="text/javascript">
	 $(document).ready(function() {
		 $('#bppal').attr('data-visor','');
			
		 $('#bppal').attr('data-controller','usuario'); 
			
        $('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [1,5]}]});

     });
	 
	$('div.alert').delay(3000).slideUp(300);
	
</script>



@endsection