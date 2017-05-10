@extends('admin.template.main')
 
@section('titulo')
 	{{ trans('principal.permi') }} 
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.permi') }} </h3>
@endsection

@section('contenido')

@inject('permisosk','App\helpers\Util')     
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
	    
    
    		@if ($permisosk->conocepermisos('add_permiso') == true)
    			<a href="{{ route('permisos.create') }}" class="btn btn-primary" role="button">{{ trans('principal.npermis') }}</a>
    		@endif		
    		<br>
    		<br>
    		<div class="example-box-wrapper">
    				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-permiso">
                      <thead>
                        <tr>
                            <th width="5%" >ID</th>
                            <th class="centrartexto">{{ trans('principal.titpermayu') }}</th>
                            <th width="20%" class="centrartexto">KEY</th>
                            <th  width="10%" class="centrartexto">{{ trans('principal.titaccion') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permisos as $permiso)
                        	<tr>
                            <td class="centrartexto">{{ $permiso->id_permiso }}</td>
                            @if ($permiso->permiso == 'Agregar Usuario') 
									<td class="centrartexto">{{ trans('principal.tradaddu') }}</td>
								@else
									@if ($permiso->permiso == 'Editar Usuario')										 
											<td class="centrartexto">{{ trans('principal.tradeditu') }}</td>									
									@else
										@if ($permiso->permiso == 'Borrar Usuario')											
												<td class="centrartexto">{{ trans('principal.traddelu') }}</td>											
									   @else
									   		@if ($permiso->permiso == 'Ver Usuario')												
													<td class="centrartexto">{{ trans('principal.tradveu') }}</td>												
											 @else
												@if ($permiso->permiso == 'Agregar Rol')													
														<td class="centrartexto">{{ trans('principal.tradadr') }}</td>													
												 @else
												 	@if ($permiso->permiso == 'Editar Rol')														
															<td class="centrartexto">{{ trans('principal.tradedr') }}</td>														
													 @else
													 		@if ($permiso->permiso == 'Borrar Rol')														
																	<td class="centrartexto">{{ trans('principal.traddelr') }}</td>																
													 		@else
													 			@if ($permiso->permiso == 'Ver Rol')														
																	<td class="centrartexto">{{ trans('principal.tradver') }}</td>			
																@else	
																	@if ($permiso->permiso == 'Agregar Permiso')														
																		<td class="centrartexto">{{ trans('principal.traddper') }}</td>		
																	@else		
																		@if ($permiso->permiso == 'Editar Permiso')														
																			<td class="centrartexto">{{ trans('principal.tradedper') }}</td>		
																		@else	
																			@if ($permiso->permiso == 'Borrar Permiso')														
																				<td class="centrartexto">{{ trans('principal.traddelper') }}</td>	
																		    @else	
																				@if ($permiso->permiso == 'Permisar Rol')														
																					<td class="centrartexto">{{ trans('principal.tradperrol') }}</td>	
																				@else		
																					@if ($permiso->permiso == 'Ver Permiso')														
																						<td class="centrartexto">{{ trans('principal.tradverper') }}</td>	
																					@else	
																						@if ($permiso->permiso == 'Agregar Indice')														
																							<td class="centrartexto">{{ trans('principal.tradaddind') }}</td>
																					    @else	
																							@if ($permiso->permiso == 'Editar Indice')														
																								<td class="centrartexto">{{ trans('principal.tradediind') }}</td>
																							@else	
																								@if ($permiso->permiso == 'Borrar Indice')														
																									<td class="centrartexto">{{ trans('principal.traddelind') }}</td>
																								@else
																									@if ($permiso->permiso == 'Ver Indice')														
																										<td class="centrartexto">{{ trans('principal.tradverind') }}</td>
																									@else	
																										@if ($permiso->permiso == 'Agregar Tipo documental')														
																											<td class="centrartexto">{{ trans('principal.tradaddtp') }}</td>
																										@else	
																											@if ($permiso->permiso == 'Editar Tipo documental')														
																												<td class="centrartexto">{{ trans('principal.tradeditp') }}</td>
																											@else
																												@if ($permiso->permiso == 'Borrar Tipo documental')														
																													<td class="centrartexto">{{ trans('principal.traddeltp') }}</td>
																												@else
																													@if ($permiso->permiso == 'Ver Tipo documental')														
																														<td class="centrartexto">{{ trans('principal.tradvertp') }}</td>
																													@else
																														@if ($permiso->permiso == 'Agregar Dependencias')														
																															<td class="centrartexto">{{ trans('principal.tradadddep') }}</td>
																														@else	
																															@if ($permiso->permiso == 'Editar Dependencias')														
																																<td class="centrartexto">{{ trans('principal.tradeddep') }}</td>
																															@else	
																																@if ($permiso->permiso == 'Borrar Dependencias')														
																																	<td class="centrartexto">{{ trans('principal.traddeldep') }}</td>
																																@else	
																																	@if ($permiso->permiso == 'Ver Dependencias')														
																																		<td class="centrartexto">{{ trans('principal.tradverdep') }}</td>
																																	@else	
																																		@if ($permiso->permiso == 'Subir Logo')														
																																			<td class="centrartexto">{{ trans('principal.tradsublo') }}</td>
																																		@else	
																																			@if ($permiso->permiso == 'Activar Logo')														
																																				<td class="centrartexto">{{ trans('principal.tradactlo') }}</td>
																																			@else	
																																				@if ($permiso->permiso == 'Desactivar Logo')														
																																					<td class="centrartexto">{{ trans('principal.traddeslo') }}</td>
																																				@else	
																																					@if ($permiso->permiso == 'Ver logo')							
																																						<td class="centrartexto">{{ trans('principal.tradverlo') }}</td>
																																					@else	
																																						@if ($permiso->permiso == 'Agregar Grupo')							
																																							<td class="centrartexto">{{ trans('principal.tradaddgru') }}</td>
																																						@else		
																																							@if ($permiso->permiso == 'Editar Grupo')							
																																								<td class="centrartexto">{{ trans('principal.tradedigru') }}</td>
																																							@else	
																																								@if ($permiso->permiso == 'Borrar Grupo')							
																																									<td class="centrartexto">{{ trans('principal.traddelgru') }}</td>
																																								@else
																																									@if ($permiso->permiso == 'Ver Grupo')							
																																										<td class="centrartexto">{{ trans('principal.tradvergru') }}</td>
																																									@else	
																																										@if ($permiso->permiso == 'Agrupar Usuarios')							
																																											<td class="centrartexto">{{ trans('principal.tradagregru') }}</td>
																																										@else
																																											@if ($permiso->permiso == 'Agregar Tabla')							
																																												<td class="centrartexto">{{ trans('principal.tradagretab') }}</td>
																																											@else	
																																												@if ($permiso->permiso == 'Editar Tabla')							
																																													<td class="centrartexto">{{ trans('principal.tradeditab') }}</td>
																																												@else	
																																													@if ($permiso->permiso == 'Borrar Tabla')							
																																														<td class="centrartexto">{{ trans('principal.traddeltab') }}</td>
																																													@else
																																														@if ($permiso->permiso == 'Ver Tabla')							
																																															<td class="centrartexto">{{ trans('principal.tradvertab') }}</td>
																																														@else
																																															@if ($permiso->permiso == 'Ver Carpetas')							
																																																<td class="centrartexto">{{ trans('principal.tradvercar') }}</td>
																																															@else
																																																@if ($permiso->permiso == 'Agregar Expediente')							
																																																	<td class="centrartexto">{{ trans('principal.tradadexp') }}</td>
																																																@else	
																																																	@if ($permiso->permiso == 'Ver Expedientes')							
																																																		<td class="centrartexto">{{ trans('principal.tradverexp') }}</td>
																																																	@else	
																																																		@if ($permiso->permiso == 'Ver Documentos')							
																																																			<td class="centrartexto">{{ trans('principal.tradverdoc') }}</td>
																																																		@else
																																																			@if ($permiso->permiso == 'Borrar Expedientes')							
																																																				<td class="centrartexto">{{ trans('principal.traddelexp') }}</td>
																																																			@else	
																																																			 	@if ($permiso->permiso == 'Crear Documentos')							
																																																					<td class="centrartexto">{{ trans('principal.tradaddoc') }}</td>
																																																				@else	
																																																					@if ($permiso->permiso == 'Borrar Documentos')							
																																																						<td class="centrartexto">{{ trans('principal.traddeldoc') }}</td>
																																																					@else	
																																																						@if ($permiso->permiso == 'Ordenar imagenes')							
																																																							<td class="centrartexto">{{ trans('principal.tradordedoc') }}</td>
																																																						@else	
																																																							<td class="centrartexto">{{ $permiso->permiso }}</td>
																																																						@endif		
																																																					@endif		
																																																				@endif	
																																																			@endif	
																																																		@endif		
																																																	@endif		
																																																@endif		
																																															@endif		
																																														@endif	
																																													@endif		
																																												@endif		
																																											@endif		
																																										@endif		
																																									@endif		
																																								@endif		
																																							@endif			
																																						@endif			
																																					@endif		
																																				@endif		
																																			@endif		 
																																		@endif	
																																	@endif		
																																@endif			
																															@endif		
																														@endif	
																													@endif	   
																												@endif   
																											@endif      
																										@endif      
																									@endif 
																								@endif	    
																							@endif	
																						@endif	 
																					@endif	
																				@endif	  
																			@endif																			
																		@endif	
																	@endif		
																@endif	
															@endif			
													 @endif			
												 @endif			
											 @endif	
									   @endif	
									@endif			
							@endif	
                            
                            
                            
                            
                            
                            <td class="centrartexto">{{ $permiso->llave }}</td> 
                            <td class="centrartexto">
                            @if ($permisosk->conocepermisos('edit_permiso') == true)<a href="{{ route('permisos.edit',$permiso->id_permiso) }}" class="btn btn-primary" role="button" title="{{ trans('principal.msgedit') }}"><span class="glyphicon glyphicon-edit"></span></a>@endif	
                            @if ($permisosk->conocepermisos('delete_permiso') == true)<a href="{{ route('permisos.destroy',$permiso->id_permiso) }}" class="btn btn-danger" role="button" title="{{ trans('principal.msgelim') }}" onclick="return confirm('{{ trans('principal.msgconfelimpermiso') }}')"><span class="glyphicon glyphicon-trash"></span></a>@endif
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

		 $('#bppal').attr('data-controller','permisos'); 
			
        $('#datatable-permiso').dataTable({"iDisplayLength": 10,"aLengthMenu": [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],"aaSorting": [[0, "asc"]],"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [2,3]}]}); 

     });
	 
	$('div.alert').delay(3000).slideUp(300);
	
</script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-tabletools.js') }}"></script>

@endsection