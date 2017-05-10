@extends('admin.template.main')
 
@section('titulo')
    {{ trans('principal.titvcarpeta') }}  
@endsection

@inject('permisos','App\helpers\Util')    		
		
		
@section('tituloPagina')
    <h3>{{ trans('principal.tittcarpeta') }} : {{ $tablas->nombre_tabla }}</h3>
@endsection

<?php

	$ruta= $permisos->verurl();
?>

@section('contenido')
	<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}"> 
	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/multi-select/multiselect.css') }}">
		  
    <script type="text/javascript" src="{{ asset('assets/widgets/multi-select/multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('dist/themes/default/style.css') }} " />
	<script type="text/javascript" src="{{ asset('dist/jstree.js') }} "></script>
	<script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>
	
	<!-- Modal -->
		  <div class="modal fade" id="modaltipodoc" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="titulotipodoc" lass="modal-title">{{ trans('principal.ntpdoc') }}</h4> 
			        </div>
			        <div class="modal-body">
			        
				          <div class="form-group">
				          	<!--input id="id_carpetaindice" type="hidden" name="id_carpetaindice"> 
				          	<input id="id_tipodocindice" type="hidden" name="id_tipodocindice"--> 
				          	
		                    <label class="col-sm-3 control-label"></label>
		                    <div class="col-sm-6" style="width:100% !important;">
		                       
		                       {!! Form::open(['route'=>'tiposdocumentales.store','method'=>'POST','class'=>'form-horizontal bordered-row','id'=> 'grabtpdoc']) !!}
	
									{{ Form::hidden('id_ctltpdoc', 'arbol') }}
									
									<div class="form-group">
										{!! Form::label('nombre',trans('principal.inputnombre'),['class'=>'col-sm-3 control-label']) !!}
										<div class="col-sm-6">
											{!! Form::text('nombre',null,['class'=>'form-control']) !!}
										</div>
									</div>
							
									<div class="form-group">
										{!! Form::label('id_estado',trans('principal.inputestado'),['class'=>'col-sm-3 control-label']) !!}
										<div class="col-sm-6">
											{{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
										</div>
									</div>
												
									<div class="form-group">
					                      {!! Form::label('color',trans('principal.inputcolor'),['class'=>'col-sm-3 control-label']) !!}
					                     <div class="col-sm-8">
					                       <div class="row">                           
					                           <div class="col-md-6">
					                           		{!! Form::text('color',null,array('id' => 'colorpicker-tl','class'=>'form-control')) !!}
					                           </div>
					                        </div>
					                    </div>
					                </div>
							
									<div class="form-group">
						                   {!! Form::label('descripcion',trans('principal.inputdescrip'),['class'=>'col-sm-3 control-label']) !!}
						                    <div class="col-sm-6">
						                        {!! Form::textarea('descripcion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
						                    </div>
						           		</div>
							
							
							
									<div class="form-group centrartexto">
										<button id="guardartpdoc" type="button" class="btn btn-primary" >{{  trans('principal.btngu') }}</button>  
										<button id="cancelartpdoc" type="button" class="btn btn-danger btn-close" data-dismiss="modal">{{  trans('principal.btnca') }}</button>										
									</div>
						
								{!! Form::close() !!}
		                       
		                       
		                       
	                    	</div>
	                      </div>
		      </div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		    </div>
		  </div>
		</div>   <!-- fin del contenedor emergente de tipo de documentos-->
	 
	<div class="modal fade" id="modalindice" role="dialog">
		    <div class="modal-dialog" style="width:50%">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
			        <div class="modal-header" style="background-color: #009ACC !important;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 id="tituloindice" lass="modal-title">{{ trans('principal.nind') }}</h4> 
			        </div>
			        <div class="modal-body">
			        
				          <div class="form-group">
				          	<!--input id="id_carpetaindice" type="hidden" name="id_carpetaindice"> 
				          	<input id="id_tipodocindice" type="hidden" name="id_tipodocindice"--> 
				          	
		                    <label class="col-sm-3 control-label"></label>
		                    <div class="col-sm-6" style="width:100% !important;">
		                       
		                       {!! Form::open(['route'=>'indices.store','method'=>'POST','class'=>'form-horizontal bordered-row','id'=> 'grabindic']) !!}
			
								{{ Form::hidden('id_ctlindice', 'arbol') }}
								<div class="form-group">
									{!! Form::label('nombre',trans('principal.inputnombre'),['class'=>'col-sm-3 control-label']) !!}
									<div class="col-sm-6">
										{!! Form::text('nombre',null,['class'=>'form-control']) !!}
										<!--para control de datos-->
										{{ Form::hidden('ntipo', '', array('id' => 'ntipo')) }}
										{{ Form::hidden('totalitem', '1', array('id' => 'totalitem')) }}
										
									</div>
								</div>
						
								<div class="form-group"> 
									{!! Form::label('id_tipo',trans('principal.inputtpcamp'),['class'=>'col-sm-3 control-label']) !!}
									<div class="col-sm-6">
										{{Form::select('id_tipo', $tipos  ,null,['class'=>'form-control'])}}
									</div>
								</div>
								
								<div class="form-group">
									{!! Form::label('id_estado',trans('principal.inputestado'),['class'=>'col-sm-3 control-label']) !!}
									<div class="col-sm-6">
										{{Form::select('id_estado', $estados  ,null,['class'=>'form-control'])}}
										
									</div>
								</div>
								
								<div id="bloque_lista" class="form-group noseve">
									<table id="tblista" width="50%" border="1" class="centrartabla" cellspacing="5" data-ctl="1" > 
										<tr>
											<th class="centrartexto colorth1" width="20%">KEY</th> 
											<th class="centrartexto colorth1">{{ trans('principal.titvalmayu') }}</th>
											<th class="centrartexto"><a href="javascript:;"  class="fileinput-exists glyphicon glyphicon-plus icoagrega" id="agregar" ></a></th>
										</tr>
										<tr id="linea_{!! 1 !!}}" class="linealista">
											<td class="centrartexto">
												<div class="col-sm-6 ajustainputtd">
													{!! Form::text('key[]',null,['class'=>'form-control']) !!}
												</div>
											</td>
											<td class="centrartexto">
												<div class="col-sm-6 ajustainputtd" >
													{!! Form::text('valor[]',null,['class'=>'form-control']) !!}
												</div>
											</td>
											<td  class="centrartexto">&nbsp;</td>
											
										</tr>
									</table>
								</div>
								
								<div class="form-group">
									{!! Form::label('orden',trans('principal.inputorden'),['class'=>'col-sm-3 control-label']) !!}
									<div class="col-sm-6">
										{!! Form::text('orden',null,['class'=>'form-control spinner-input','onKeyUp' => 'return ValNumero(this)']) !!}
									</div>
								</div>
								
								
								<div class="form-group">
				                   {!! Form::label('descripcion',trans('principal.inputdescrip'),['class'=>'col-sm-3 control-label']) !!}
				                    <div class="col-sm-6">
				                        {!! Form::textarea('descripcion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
				                    </div>
				           		</div>
						
								<div class="form-group centrartexto">
									<button id="guardarindice" type="button" class="btn btn-primary" >{{  trans('principal.btngu') }}</button>  
									<button id="cancelarindice" type="button" class="btn btn-danger btn-close" data-dismiss="modal">{{  trans('principal.btnca') }}</button>	
								</div>
						
								{!! Form::close() !!}
		                       
		                       
		                       
	                    	</div>
	                      </div>
		      		</div>
		      <div class="modal-footer">
		          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		      </div>
		    </div>
		  </div>
		</div>   <!-- fin del contenedor emergente de indices-->
	
	
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
	
	
	<div class="panel"> 
	    <div class="panel-body">
	       @if ($permisos->conocepermisos('add_tpdoc') == true)
				<a href="javascript:;"  id="btncreatpdoc" class="btn btn-primary" role="button">{{ trans('principal.ntpdoc') }}</a>
		   @endif
		   @if ($permisos->conocepermisos('add_indice') == true)
				<a href="javascript:;" id="btncreaindice" class="btn btn-primary" role="button">{{ trans('principal.nind') }}</a>
			@endif		
			<?php
				
			echo '<iframe src="'.$ruta.'/treepowerfile2/arbol.php?tablaid='.$tablaid.'&tiposdocumentales='.$tiposdocumentales.'&ruta='.$ruta.'"  height="700" width="100%" style="margin-top:1%" frameborder="0" ></iframe>';
			
			
			?>
			
	    </div>
	</div>
<script type="text/javascript" src="{{ asset('assets/widgets/colorpicker/colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/colorpicker/colorpicker-demo.js') }}"></script>	
<script type="text/javascript" src="{{ asset('assets/widgets/spinner/spinner.js') }}"></script>

	
<script type="text/javascript">	

	$(document).ready(function() {
		$('#bppal').attr('data-visor','');
	
		$('#bppal').attr('data-controller','folders'); 
	});
	$(function() { "use strict";
		$(".spinner-input").spinner();
	});
	
	//para los tipos documentales
		$( "#btncreatpdoc" ).click(function() {
			$('#modaltipodoc').modal('show');
		});	
		$( "#guardartpdoc" ).click(function() {
			 $('#grabtpdoc').submit(); 
			 $('#modaltipodoc').modal('hide');	
		});	
		$( "#cancelartpdoc" ).click(function() {
			$('#modaltipodoc').modal('hide');
		});	
	//////////////////////////////
	// para los indices
	$( "#btncreaindice" ).click(function() {
			$('#modalindice').modal('show');
		});	
	
	$( "#guardarindice" ).click(function() {
		 $('#grabindic').submit(); 
		 $('#modalindice').modal('hide');	
	});	

	$( "#cancelarindice" ).click(function() {
		$('#modalindice').modal('hide');
	});	


	$('#id_tipo').bind('change', function () { 
		var seleccion = $("#id_tipo option:selected").text();
		seleccion = seleccion.toUpperCase();
		$('#ntipo').val(seleccion);
		switch (seleccion) { 
	    	case 'LISTA': case 'LISTAS': 
	        	// SE GENERAN LOS ITEM DE KEY Y VALOR
	        	$('#bloque_lista').show();
	      	break;
	      	default:
	      		$('#bloque_lista').hide();
		}	
	});

	$('#agregar').bind('click', function () {  
		var ctl = $("#tblista").attr('data-ctl');
		var ctotal = $("#totalitem").val();
		ctl = parseInt(ctl) + 1;
		ctotal = parseInt(ctotal) + 1; 
		$("#totalitem").val(ctotal); 
		//se agregan los valores nuevos a la tabla
		var script = '';
		script += '<tr id="linea_'+ctl+'">';
		script += '<td class="centrartexto">';
		script += '<div class="col-sm-6 ajustainputtd">';
		script += '{!! Form::text('key[]',null,['class'=>'form-control']) !!}';
		script += '</div>';
		script += '</td>';
		script += '<td class="centrartexto">';
		script += '<div class="col-sm-6 ajustainputtd" >';
		script += '{!! Form::text('valor[]',null,['class'=>'form-control']) !!}';
		script += '</div>';
		script += '</td>';
		script += '<td  class="centrartexto"><a href="javascript:;"  onclick="quitaritem('+ctl+')" class="fileinput-exists glyphicon glyphicon-remove icoremover" id="quitar_{!! 1 !!}}" ></a>';
		script += '</td>';		
		script += '</tr>';
		$("#tblista").append(script);

		
	});	
	
 function quitaritem(item){	 
	$('#linea_'+item).remove();
	var ctotal = $("#totalitem").val();
	ctotal = parseInt(ctotal) - 1; 
	$("#totalitem").val(ctotal); 
	
 }

 $('div.alert').delay(3000).slideUp(300);	
</script>	
	
@endsection
