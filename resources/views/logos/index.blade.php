@extends('admin.template.main')
 
@section('titulo')
 	{{ trans('principal.logo') }}  
@endsection

@section('tituloPagina')
    {{ trans('principal.logo') }}  
@endsection

@inject('permisos','App\helpers\Util')    
@section('contenido')
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
        <h3 class="title-hero">
            Logos
        </h3>

        @if ($permisos->conocepermisos('add_logo') == true)
        	<button type="button" id="uploads" class="btn btn-success">{{ trans('principal.tradsublo') }}</button> 
        @endif	
        <br>
        <br>
        <ul id="portfolio-grid" class="reset-ul row">
	        @foreach($logos as $logo)
	        	<li class="col-sm-6 mix hover_1" data-cat="1" style="display:flex !important;">
			    	
			    	
			    	<div class="thumbnail-box">
				        <div class="thumb-content">
				            <div class="center-vertical">
				                <div class="center-content">
				                    <div class="thumb-btn animated bounceInDown">
				                        @if ($permisos->conocepermisos('act_logo') == true)<a href="{{ route('logos.activar',$logo->id_logo) }} " class="btn btn-md btn-round btn-success" title="Activar" "><i class="glyph-icon icon-check"></i></a>@endif
				                        @if ($permisos->conocepermisos('desac_logo') == true)<a href="{{ route('logos.desactivar',$logo->id_logo) }}" class="btn btn-md btn-round btn-danger" title="Desactivar" ><i class="glyph-icon icon-remove"></i></a>@endif
				                    </div>
				                </div>           
				            </div>
				        </div>
				        <div class="thumb-overlay bg-primary"></div>
				        <img src="{{ asset('img/logos/'.$logo->nombrelogo)}}" width="100" heigth="100"  alt=""> <!-- onclick="activarlo('{{ $logo->nombrelogo }}',{{ $logo->id_logo }})  onclick="desactivarlo('{{ $logo->nombrelogo }}',{{ $logo->id_logo }})"-->
				    </div>
			    	
			    	
			    	
			    	
			    	
			    	
			    	<!--div class="example-box-wrapper">
			            <div class="row">
			                <div class="col-sm-6">
			                    <div class="thumbnail-box">
			                        <div class="thumb-content">
			                            <div class="center-vertical">
			                                <div class="center-content">
			                                    <div class="thumb-btn animated bounceInDown">
			                                        <a href="#" class="btn btn-md btn-round btn-success" title=""><i class="glyph-icon icon-check"></i></a>
			                                        <a href="#" class="btn btn-md btn-round btn-danger" title=""><i class="glyph-icon icon-remove"></i></a>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="thumb-overlay bg-primary"></div>
			                        <img src="{{ asset('img/logos/'.$logo->nombrelogo)}}" alt="">
			                    </div>
			                </div>
			            </div>
			        </div-->  
			         
			    </li>   
	        @endforeach
	    </ul> 
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/logo.js') }}"></script>
<!--<script type="text/javascript" src="{{ asset('js/dropzone/dropzone.min.js') }}"></script>-->
<!--script type="text/javascript" src="{{ asset('assets/widgets/dropzone/dropzone.js') }}"></script-->

<script>

	if (window.FileReader) {
	    function seleccionArchivo(evt) { 
	      var files = evt.target.files;
	      var f = files[0];    
	      var leerArchivo = new FileReader();
	      document.getElementById('resetear').style.display= 'block';
	        leerArchivo.onload = (function(elArchivo) {
	          return function(e) {   
	            document.getElementById('vistaprevia').innerHTML = '<img src="'+ e.target.result +'" alt="" width="150" />';
	          };
	        })(f);
	 
	        leerArchivo.readAsDataURL(f);
	    }
	   } 
	else 
	  {
			document.getElementById('vistaprevia').innerHTML = "El navegador no soporta vista previa";
		 }
	
	document.getElementById('nombrelogo').addEventListener('change', seleccionArchivo, false);
	
	function cancela(elForm){
		 document.getElementById(elForm).reset();
		 if (window.FileReader) 
			{
		 		document.getElementById('vistaprevia').innerHTML = "Vista Previa";
		 	}
		 else
			 {
		 		document.getElementById('vistaprevia').innerHTML = "El navegador no soporta vista previa";
		 	}
		 document.getElementById('resetear').style.display= 'none';
	}
	
	
		$('#resetear').bind('click', function () {   
			 //se limpia la seleccion de avatar
		   	$("#nombrelogo").val("");
		   	$("#resetear").hide();
		   	$("#vistaprevia").html('');
		   	
		});
	function activarlo(logo,idlogo){

			alert(logo); alert(idlogo);

	}
	function desactivarlo(logo,idlogo){

		alert(logo); alert(idlogo);
		
	}	

	$(document).ready(function() {

		$('#bppal').attr('data-visor','');

		$('#bppal').attr('data-controller','indices'); 
	});	
	$('div.alert').delay(3000).slideUp(300);
</script>

@endsection

 					<div id="uploadlo" class="modal fade" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">{{ trans('principal.tradsubelogo') }}</h4> 
                                </div>
                                <div class="modal-body">
                                    <div class="row" id="dropzone-example">
                                    	<div class="example-box-wrapper">
                                    	
                							{!! Form::open(['route'=>'logos.store','method'=>'POST','class'=>'form-horizontal bordered-row','files'=>true,'enctype' => 'multipart/form-data']) !!} 
			    
									    		<div class="form-group centrartexto" >
													{!! Form::label('nombrelogo','Logo',['class'=>'col-sm-3 control-label']) !!}
														<div class="col-sm-6">
															<div class="fileinput fileinput-new" data-provides="fileinput">
																<div class="fileinput-preview thumbnail" id="vistaprevia" data-trigger="fileinput" style="width: 200px; height: 150px;">
																	
																</div>
																<a href="javascript:;"  class="fileinput-exists glyphicon glyphicon-remove icoremover" id="resetear" data-dismiss="fileinput" style="position:relative;float:right"></a>
																<div>
																	<span class="btn btn-default btn-file">
																	<span class="fileinput-new">{{ trans('principal.tradseleclogo') }}</span> 
																	<span class="fileinput-exists">{{ trans('principal.mcamb') }}</span>
																		{!! Form::file('nombrelogo', array('multiple'=>false)) !!}
																	 
																		
																	</span>
															
																</div>
															</div>
														</div>
												</div>
												<div class="form-group centrartexto">
													{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
													{{ link_to_route('logos.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
													
													
												</div>
											{!! Form::close() !!}	
            							</div>
            						</div>
                               </div>
                                <!--div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes8</button>
                                </div-->
                            </div>
                        </div>
                    </div>