@extends('admin.template.main')
@section('titulo')
 {{ trans('principal.errorti') }}  
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.errorti') }}  </h3>
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
    
    		@if ($permisos->conocepermisos('set_up_load') == true)
    			<a href="{{ route('setuperror.create') }}" class="btn btn-primary" role="button">{{ trans('principal.nerror') }}</a>
    		@endif	
    		<br>
    		<br>
    		<div class="example-box-wrapper">
    				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-permiso">
                      <thead>
                        <tr>
                            <th width="5%" >ID</th>
                            <th class="centrartexto">{{ trans('principal.titnomodobo') }}</th>
                            <th class="centrartexto">{{ trans('principal.titserver') }}</th>
                            <th width="20%" class="centrartexto">{{ trans('principal.titestamayu') }}</th>
                            <th width="20%" class="centrartexto">{{ trans('principal.titestatusmayu') }}</th>
                            <th  width="20%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($setup as $datos)
                        	<tr>
                            <td class="centrartexto">{{ $datos->id_setup }}</td>
                            <td class="izqtexto">{{ $datos->modobodega }}</td>
                            <td class="centrartexto">{{ $datos->ftp_server }}</td>
                            @if ($datos->id_estado == 1) 
									<td class="centrartexto">{{ trans('principal.tiotestadoa') }}</td>
								@else
									<td class="centrartexto">{{ trans('principal.tiotestadoi') }}</td>	
							@endif	          
							@if ($datos->estatus == 1) 
									<td class="centrartexto">{{ trans('principal.titestaserverd') }}</td>  
								@else
									<td class="centrartexto">{{ trans('principal.titestaserveri') }}</td>	
							@endif	               
                            <td class="centrartexto">
                             @if ($permisos->conocepermisos('edit_error') == true)<a href="{{ route('setuperror.edit',$datos->id_setup) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif	
                             @if ($permisos->conocepermisos('delete_error') == true)<a  data-b="{{ $datos->id_setup }}" href="{{ route('setuperror.destroy',$datos->id_setup) }} " class="btn btn-danger btnborrar" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimerror') }}')" role="button" ><span class="glyphicon glyphicon-trash"></span></a>@endif
                          
                                                       	
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
			
		$('#bppal').attr('data-controller','tabla'); 
	      
        $('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [4]}]});

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

	