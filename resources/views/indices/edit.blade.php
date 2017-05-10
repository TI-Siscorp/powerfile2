@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.titveditindice') }} 
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.titveditindice') }} : {{ $indices->nombre }}</h3>
@endsection

@section('contenido')



<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

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
	
	
		{!! Form::model($indices, ['method' => 'PATCH','route' => ['indices.update', $indices->id_indice],'class'=>'form-horizontal bordered-row']) !!}
		
		
		
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
								<th class="centrartexto colorth1">{{  trans('principal.titvalmayu') }} </th>
								<th class="centrartexto"><a href="javascript:;"  class="fileinput-exists glyphicon glyphicon-plus icoagrega" id="agregar" ></a></th>
							</tr>
							<?php
								$tirakey =  $indices->delistakey;
								$tiravalor =  $indices->delistavalor;
								$totlineas = count($tirakey);
								if ($tirakey != '')
									{
										$vkey = json_decode($tirakey, true);
										$vvalor = json_decode($tiravalor, true);
										//se carga la tabla con los valores originales
										$linea = 1;
										for ($i = 0; $i < count($vkey); $i++)
											{?>
												<tr id="linea_{!! $linea !!}}" class="linealista">
													<td class="centrartexto">
														<div class="col-sm-6 ajustainputtd">
														{!! Form::text('key[]',$vkey[$i],['class'=>'form-control']) !!}
														</div>
													</td>
													<td class="centrartexto">
														<div class="col-sm-6 ajustainputtd" >
														{!! Form::text('valor[]',$vvalor[$i],['class'=>'form-control']) !!}
														</div>
													</td><?php
													if ($i == 0)
														{?>
															<td  class="centrartexto">&nbsp;</td><?php
														}	
													else
														{?>
															<td  class="centrartexto"><a href="javascript:;"  onclick="quitaritem(<?php echo  $linea;?>)" class="fileinput-exists glyphicon glyphicon-remove icoremover" id="quitar_<?php echo  $linea;?>" ></a><?php
														}	?>
												</tr><?php
												$linea++;
											}	
									}
								else 
									{?>
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
										</tr><?php										
									}
							?>							
						</table>
					</div>
					
					<div class="form-group">
						{!! Form::label('orden',trans('principal.inputorden'),['class'=>'col-sm-3 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('orden',null,['class'=>'form-control spinner-input']) !!}
						</div>
					</div>
					
					<div class="form-group">
	                   {!! Form::label('descripcion',trans('principal.inputdescrip'),['class'=>'col-sm-3 control-label']) !!}
	                    <div class="col-sm-6">
	                        {!! Form::textarea('descripcion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
	                    </div>
	           		</div>
			
			<div class="form-group centrartexto" >
			{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary'])!!}
			{{ link_to_route('indices.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
			</div>
		
		
		
		{!! Form::close() !!}
	</div>

</div>

<script type="text/javascript" src="{{ asset('assets/widgets/spinner/spinner.js') }}"></script>


<script type="text/javascript">
	$(function() { "use strict";
		$(".spinner-input").spinner();
	});
		//se recorre el select para seleccionar el q le corresponda el valor previamente guardado
		var id_estadoreg = '<?php echo $indices->id_estado; ?>'; 
		$("#id_estado option").each(function(){
			if ($(this).val() == id_estadoreg )
				{
					$(this).prop('selected', true);
				}
		});
		//el tipo de indice
		var id_estadoregtipo = {{ $indices->id_tipo }};
		$("#id_etipo option").each(function(){
			if ($(this).val() == id_estadoregtipo )
				{
					$(this).prop('selected', true);
				}
		});	
		  
		$(document).ready(function () {

			$('#bppal').attr('data-visor','');
			
			$('#bppal').attr('data-controller','indices'); 
			
			var seleccion = $("#id_tipo option:selected").text();
			seleccion = seleccion.toUpperCase();
			$('#ntipo').val(seleccion);
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
					if (cglineaslista > 0)
						{
							$("#tblista").attr('data-ctl',cglineaslista);
						}			        	
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
		
</script>


	@endsection