@extends('admin.template.main')

@section('titulo')
 {{ trans('principal.titvroles') }} 
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.titvroles') }}</h3>
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
    
    		@if ($permisos->conocepermisos('add_rol') == true)
    			<a href="{{ route('roles.create') }}" class="btn btn-primary" role="button">{{ trans('principal.nrol') }}</a>
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
                        @foreach($roles as $rol)
                        	<tr>
                            <td class="centrartexto">{{ $rol->id_rol }}</td>
                            <td class="izqtexto">{{ $rol->nombre }}</td>
                           @if ($rol->descripcion == 'Activo') 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									@if ($rol->descripcion == 'Inactivo')
										{ 
											<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>
										}
									@else
										<td class="centrartexto">{{ $rol->descripcion }}</td>
									@endif			
							@endif	
                            <td class="centrartexto">
                            @if ($permisos->conocepermisos('edit_rol') == true)<a href="{{ route('roles.edit',$rol->id_rol) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif	
                            @if ($permisos->conocepermisos('delete_rol') == true)<a  data-b="{{ $rol->id_rol }}" href="{{ route('roles.destroy',$rol->id_rol) }} " class="btn btn-danger btnborrar" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimrol') }}')" role="button" ><span class="glyphicon glyphicon-trash"></span></a>@endif
                            @if ($permisos->conocepermisos('permi_rol') == true)<a href="{{ route('roles.permiso',$rol->id_rol) }}" class="btn btn-warning" role="button" title="{{ trans('principal.msgpermi') }}" ><span class="glyphicon glyphicon-lock"></span></a>@endif
                            </td>
                                
                            <!--td class="centrartexto">
                            	<a href="{{ route('roles.edit',$rol->id_rol) }}"  style="font-size:2em; color:#00CEB4" role="button" title="Editar">
                            	<span class="glyphicon glyphicon-edit sombraicono"></span></a>&nbsp;
                            	<a href="{{ route('roles.destroy',$rol->id_rol) }}" class="btn btn-danger" role="button" title="Eliminar" onclick="return confirm('¿Esta seguro de eliminar el rol?')"><span class="glyphicon glyphicon-trash"></span></a> '{{ trans('principal.msgconfelim') }}
                            	&nbsp;<a href="{{ route('roles.permiso',$rol->id_rol) }}" class="btn btn-warning" role="button" title="Permisos" ><span class="glyphicon glyphicon-lock"></span></a>
                            	</td-->    
                                
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
			
		$('#bppal').attr('data-controller','rol'); 
	      
        $('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]});

     });
	 
	$('div.alert').delay(3000).slideUp(300);

	/*$('.btnborrar').bind('click', function () {   
		//alert($this.attr('data-b'));
	   	//alert('sami');
	   	$('#lamodal').show();//fadeIn('slow');
	});*/
	
</script>

<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

@endsection


	<!--div id="lamodal" class="modal fade" >
	   <div class="modal-dialog">
          <div class="modal-content">
		    	<p>¿Esta seguro de eliminar el rol?</p>
		    	{!! Form::open(['method' => 'DELETE', 'id'=>'delForm']) !!}
			    	<button type="submit" class="btn btn-primary">Delete</button>
			 	{!! Form::close() !!}
		   </div>
       </div>	 	
	</div-->

	