@inject('permisos','App\helpers\Util')
<?php
@session_start();


$espaciotrabajo = $_SERVER['REQUEST_URI'];

if (trim($espaciotrabajo) == '/')
	{
		
		$_SESSION['espaciotrabajo'] = 'powerfile2';
		
	}
else
	{
				
		$espaciotrabajo = substr($espaciotrabajo,1);
		
		$ruteado = explode("/",$espaciotrabajo);
		
		$_SESSION['espaciotrabajo'] = $ruteado[0];
		
	}
	$idusuario = Session::get('id_usuario'); echo $idusuario;
	
	$ruta= $permisos->verurl();
?>
@extends('admin.template.login')
 
@section('titulo')
 Principal
@endsection

@section('login')
    <link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
	 </script--> 
     <?php
     if ($espaciotrabajo != '')
     	{?>
     	    <form class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin" method="post" action="{{ url($espaciotrabajo.'/login') }}"><?php
     	}
     else
     	{?>
     		 <form class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin" method="post" action="{{ url('login') }}"><?php
     	}	    ?>
       {{ csrf_field() }}
            <!-- h3 class="text-center pad25B font-gray text-transform-upr font-size-23"></h3-->
            <div id="login-form" class="content-box bg-default" >
                <div class="content-box-wrapper pad20A">     
                	<img class="mrg25B center-margin  display-block" src="{{ asset('img/logopowerfile.png') }}" alt="logo">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon addon-inside bg-gray">
                                <i class="glyph-icon icon-unlock-alt"></i>
                            </span>
                              
                               <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus placeholder="{{ trans('principal.inputlogin') }}">
                               <!-- input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email"-->

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>                                 
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon addon-inside bg-gray">
                                <i class="glyph-icon icon-unlock-alt"></i>
                            </span>
                               <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">{{ trans('principal.btningresa') }}</button>
                    </div>
                    <div class="row">
                        <!--div class="checkbox-primary col-md-6" style="height: 20px;">
                            <label>
                                <input type="checkbox" id="loginCheckbox1" class="custom-checkbox">
                                Remember me
                            </label>
                        </div-->
                        <div class="text-right col-md-6" style="float:right;">
                            <a href="{{ url('/password/reset') }}" title="Recover password">{{ trans('principal.btnolido') }}?</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="login-forgot" class="content-box bg-default hide">
                <div class="content-box-wrapper pad20A">

                    <div class="form-group">
                        <label for="exampleInputEmail2">Email address:</label>
                        <div class="input-group">
                            <span class="input-group-addon addon-inside bg-gray">
                                <i class="glyph-icon icon-envelope-o"></i>
                            </span>
                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                        </div>
                    </div>
                </div>
                <!--div class="button-pane text-center">
                    <a class="btn btn-link" href="{{ url('http://www.siscorp.com.co') }}">
                        Forgot Your Password?
                    </a>
                </div-->
            </div>

        </form>
        <div style="margin: 0 auto; width: 100%; text-align:center; position:relative;"> <a class="btn btn-link" href="{{ url(env('URL_COMPANY', false)) }}">{{env('COMPANY', false)}}</a></div>
@endsection

<script type="text/javascript">

	$(document).ready(function() {
		
		//se limpia la carpeta de descargas del usuario
		
		var idusuario = '{{ Session::get("id_usuario") }}'; 
				
		var ruta = 	'{{ $ruta }}';
		
		/////// se limpia la carpeta de imagenes del usuario
		$('#fondomodal').show();
		var enlacerecep = ruta+'/treepowerfile2/cargalo_documentos.php?otraoperation=limpiarlo'+'&idusuario='+idusuario;   
		$.ajax({
		   type: "GET",
		   async:false, 
		   url: enlacerecep,
		   success: function(msg){  

			   $('#fondomodal').hide();	   				   
		   },
			error: function(x,err,msj){alert(msj) }
		  });
		 //////// 

		
	});

	
	
</script>
