@extends('admin.template.main')

@section('titulo')
	{{ trans('principal.tvgrupa') }} 
@endsection

@section('tituloPagina')
	<h3>{{ trans('principal.tvgrupa1') }}  : {{ $grupos->nombre }}</h3>
@endsection

@section('contenido')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/multi-select/multiselect.css') }}">



<?php

//se carga la data previamente registrada en la tabla rompimiento de grupo_usuario
    				
$id_usuariogrup = '';    
for ($i = 0; $i < count($userxgrupo); $i++)
	{
		$id_usuariogrup .= $userxgrupo[$i]->id_usuario.'_;_';
    }
    
?>

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
	
		{!! Form::model($grupos, ['method' => 'GET','route' => ['grupos.actualizar_agrupar', $grupos->id_grupo],'class'=>'form-horizontal bordered-row']) !!}
		
		
		
			<div class="form-group">
                    {!! Form::label('usuarios_grupo',trans('principal.user'),['class'=>'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                    	{{Form::select('usuarios_grupo', $usuarios  ,null,['class'=>'multi-select','multiple'=>'multiple','name'=>'usuarios_grupo[]'])}}
                    	
                    	{{ Form::hidden('idgrupo', $grupos->id_grupo, array('id' => 'idgrupo')) }}
                    </div>
            </div>
		
			<div class="form-group centrartexto">
					{!! Form::submit(trans('principal.btngu'),['class'=>'btn btn-primary '])!!}
					{{ link_to_route('grupos.index', trans('principal.btnca'), '', array('class'=>'btn btn-danger btn-close')) }}
					
					
			</div>
		{!! Form::close() !!}
	
	</div>

</div>

<script type="text/javascript" src="{{ asset('assets/widgets/multi-select/multiselect.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quicksearch/jquery.quicksearch.js') }}"></script>



<script type="text/javascript">

$(document).ready(function () {
	$('#bppal').attr('data-visor','');

	$('#bppal').attr('data-controller','grupos'); 
	var id_usuariogrup = '{{ $id_usuariogrup }}';		
	var vectordatos = id_usuariogrup.split("_;_"); 
	$('#usuarios_grupo option').each(function (){
	    var option_val = this.value;
	    if(jQuery.inArray(option_val, vectordatos) != -1)
			{
	    	 	$("#usuarios_grupo option[value='" + this.value + "']").attr("selected", 1);
			}    
	});

});	

    /* Multiselect inputs */

    $(function() { "use strict";
        $(".multi-select").multiSelect({
        	  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='{{ trans('principal.placehbusca') }}'>",
        	  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='{{ trans('principal.placehbusca') }}'>",
        	  afterInit: function(ms){
        	    var that = this,
        	        $selectableSearch = that.$selectableUl.prev(),
        	        $selectionSearch = that.$selectionUl.prev(),
        	        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        	        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

        	    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        	    .on('keydown', function(e){
        	      if (e.which === 40){
        	        that.$selectableUl.focus();
        	        return false;
        	      }
        	    });

        	    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        	    .on('keydown', function(e){
        	      if (e.which == 40){
        	        that.$selectionUl.focus();
        	        return false;
        	      }
        	    });
        	  },
        	  afterSelect: function(){
        	    this.qs1.cache();
        	    this.qs2.cache();
        	  },
        	  afterDeselect: function(){
        	    this.qs1.cache();
        	    this.qs2.cache();
        	  }
        	}

                );
        $(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
    });
</script>
<script type="text/javascript">
	$('div.alert').delay(3000).slideUp(300);
</script>


	@endsection
