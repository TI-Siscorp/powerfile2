@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.nind') }} 
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.nind') }} </h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

<script type="text/javascript" src="{{ asset('js/herramientas.js') }}"></script>
<style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}
        .spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}
        .spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}
        .spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}
        @-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
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
			
					{!! Form::open(['route'=>'indices.store','method'=>'POST','class'=>'form-horizontal bordered-row']) !!}
			
					{{ Form::hidden('id_ctlindice', '') }}
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
					{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
					{{ link_to_route('indices.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
					</div>
			
					{!! Form::close() !!}
		
		</div>
</div>

<script type="text/javascript" src="{{ asset('assets/widgets/spinner/spinner.js') }}"></script>

<script>
	$(function() { "use strict";
		$(".spinner-input").spinner();
	});

	//se verifica q tipo de indice se escogio
	$(document).ready(function () {

		$('#bppal').attr('data-visor','');
		
		$('#bppal').attr('data-controller','indices'); 
		
		var seleccion = $("#id_tipo option:selected").text();
		seleccion = seleccion.toUpperCase();
		switch (seleccion) { 
	    	case 'LISTA': case 'LISTAS': 
	        	// SE GENERAN LOS ITEM DE KEY Y VALOR
	        	$('#bloque_lista').show();
	        	//se contabilizan las lineas de la lista a generar
	        	var cglineaslista = 0;
				$(".linealista").each(function(){
					cglineaslista = parseInt(cglineaslista) + 1;					
				});
				$("#totalitem").val(cglineaslista); 
	        	
	      	break;
	      	default:
	      		$('#bloque_lista').hide();
		}	
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

