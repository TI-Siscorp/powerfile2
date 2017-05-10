@extends('admin.template.main')
 
@section('titulo')
 {{ trans('principal.titvpermiroles') }}  
@endsection

@section('tituloPagina')
    <h3>{{ trans('principal.titvpermiroles') }}: {{ $roles->nombre }}</h3>
@endsection

@section('contenido')

<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">  
  

<style>
	input[type=checkbox] {
	  display: none;
	}
</style>
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
    
    		
    		<br>
    		<br>
    		<div class="example-box-wrapper">
    			
    			{!! Form::model($roles, ['method' => 'GET','route' => ['roles.store_permiso', $roles->id_rol],'class'=>'form-horizontal bordered-row']) !!}
    			
    				{{ Form::hidden('idrol', $roles->id_rol, array('id' => 'idrol')) }}
    				{{ Form::hidden('idpermhabiles', '', array('id' => 'idpermhabiles')) }}
    				{{ Form::hidden('idpermnegados', '', array('id' => 'idpermnegados')) }}
    				
    				<?php
    				//se carga la data previamente registrada en la tabla rompimiento de permiso_rol
    				
    				$id_permisov = '';    
    				for ($i = 0; $i < count($permiso_rol); $i++)
    					{
    						$id_permisov .= $permiso_rol[$i]->id_permiso.'_,_'.$permiso_rol[$i]->value.'_;_';
    					}
    				?>
    				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-permiso">
                      <thead>
                        <tr>
                            
                            <th width="20%" class="centrartexto">{{ trans('principal.titpermayu') }}</th>
                            <th width="5%" class="centrartexto">
                            	{{ trans('principal.tithabmayu') }}&nbsp;
                            	<input type="checkbox" id="habilitatodo"  class="habilitatodos" onclick="habilitatodos(this.id)" >
                            	<label for="habilitatodo" title="Habilitar Todos"></label>
                            </th>
                            <th  width="5%" class="centrartexto"> 
                            	{{ trans('principal.titnegmayu') }}&nbsp;
                            	<input type="checkbox" id="niegatodo"  class="deshabilitatodos" onclick="deshabilitatodos(this.id)" >	
                            	<label for="niegatodo" title="Negar Todos"></label>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permisos as $permiso)
                        	<tr>
                            <td class="izqtexto">{{ $permiso->permiso }} </td>
                            <td style="text-align:center !important;">
	                            <div class="checkbox checkbox-primary">
                                     <input type="checkbox" id="habilitado_{{ $roles->id_rol }}_{{ $permiso->id_permiso }}" data-rol="{{ $roles->id_rol }}" data-permiso="{{ $permiso->id_permiso }}" class="habilitados" onclick="validaitem(this.id)" value="1"/>
									 <label for="habilitado_{{ $roles->id_rol }}_{{ $permiso->id_permiso }}"></label>
                                </div>	
                            </td>
                            <td class="centrartexto">
                            	    <input type="checkbox" id="negado_{{ $roles->id_rol }}_{{ $permiso->id_permiso }}" data-rol="{{ $roles->id_rol }}" data-permiso="{{ $permiso->id_permiso }}" class="negados" onclick="validaitem(this.id)" value="0"/>
									<label for="negado_{{ $roles->id_rol }}_{{ $permiso->id_permiso }}"></label>
                            </td>
                           
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group centrartexto">
					{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
					{{ link_to_route('roles.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
					</div>
               {!! Form::close() !!}
                <!--  input type="checkbox" id="inputOne" />
				<label for="inputOne"></label-->
				
				
          </div>
    </div>
</div>



 <script type="text/javascript">

 
 $(document).ready(function () {

		$('#bppal').attr('data-visor','');
		
		$('#bppal').attr('data-controller','rol'); 
		
	    var totalhab = $('.habilitados').size();
	    var totalneg = $('.negados').size();	    
		var id_permisov = '{{ $id_permisov }}';			
		$('.habilitados').prop('checked',false);
		$('.negados').prop('checked',false);
		var vectordatos = id_permisov.split("_;_");   
		var vidper = [];
		var vvalper = [];
		for (i = 0; i < (vectordatos.length) - 1; i++)
			{
				var dpermr = vectordatos[i].split("_,_");
				vidper[i] = dpermr[0];
				vvalper[i] = dpermr[1];			
			}
		var thab = 0;
		$(".habilitados").each(function(){ 
			var idp = $(this).attr('data-permiso'); 

			if(jQuery.inArray(idp, vidper) != -1)
				{
					var posihab = jQuery.inArray(idp, vidper);
					if (vvalper[posihab] == 1)
						{
							$(this).prop('checked',true);
							thab = parseInt(thab) + 1;
						}
				}
		});
		if (thab == totalhab)
			{
				$('#habilitatodo').prop('checked',true);
			}
		else
			{
				$('#habilitatodo').prop('checked',false);
			}
		var tneg = 0;
		$(".negados").each(function(){ 
			var idp = $(this).attr('data-permiso'); 

			if(jQuery.inArray(idp, vidper) != -1)
				{
					var posihab = jQuery.inArray(idp, vidper);
					if (vvalper[posihab] == 0)
						{
							$(this).prop('checked',true);
							tneg = parseInt(tneg) + 1;
						}
				}
		});
		if (tneg == totalneg)
			{
				$('#niegatodo').prop('checked',true);
			}
		else
			{
				$('#niegatodo').prop('checked',false);
			}

		
		//se cargan los valores dentro de los items respectivos 
		cargardatosperm();	
	});
	function habilitatodos(id){
		if ($('#'+id).prop('checked') == true)
			{
				$('.habilitados').prop('checked',false);
				$('.negados').prop('checked',false);
				$('.habilitados').prop('checked',true);
				$('#niegatodo').prop('checked',false);
			}	
		else
			{
				$('.habilitados').prop('checked',false);
			}
		cargardatosperm();
	}
	function deshabilitatodos(id){  
		if ($('#'+id).prop('checked') == true)
			{
				$('.habilitados').prop('checked',false);
				$('.negados').prop('checked',false);
				$('.negados').prop('checked',true);
				$('#habilitatodo').prop('checked',false);
			}	
		else
			{
				$('.negados').prop('checked',false);
			}
		cargardatosperm();
	}
	function validaitem(id){
		var rolid = $('#'+id).attr('data-rol');
		var permisoid = $('#'+id).attr('data-permiso');
		$('#habilitado_'+rolid+'_'+permisoid).prop('checked',false);
		$('#negado_'+rolid+'_'+permisoid).prop('checked',false);
		$('#'+id).prop('checked',true);
		cargardatosperm();
	}	

	
	function cargardatosperm(){
		var totalhab = $('.habilitados').size();
	    var totalneg = $('.negados').size();	    
		var permisohabid = '';	
		permisonega = '';
		//se recorren los check habilitados y se arma el paquete de envios
		var permisohabid = '';
		var thab = 0;
		$(".habilitados:checked").each(function(){ 
			//cada elemento seleccionado
			permisohabid +=  $(this).attr('data-permiso')+'_;_'+$(this).val()+',';
			thab = parseInt(thab) + 1;
		}); 
		if (thab == totalhab)
			{
				$('#habilitatodo').prop('checked',true);
			}
		else
			{
				$('#habilitatodo').prop('checked',false);
			}
		//se registra en el input de habilitados
		$('#idpermhabiles').val(permisohabid);
		//se recorren los check negados y se arma el paquete de envios
		var permisonega = '';
		var tneg = 0;
		$(".negados:checked").each(function(){
			//cada elemento seleccionado
			permisonega += $(this).attr('data-permiso')+'_;_'+$(this).val()+','
			tneg = parseInt(tneg) + 1;
		}); 
		if (tneg == totalneg)
			{
				$('#niegatodo').prop('checked',true);
			}
		else
			{
				$('#niegatodo').prop('checked',false);
			}		
		//se registra en el input de negados
		$('#idpermnegados').val(permisonega);
		
	}
	$('div.alert').delay(3000).slideUp(300);
 </script>


@endsection