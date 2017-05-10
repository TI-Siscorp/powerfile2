@extends('admin.template.login')
 
@section('titulo')
 Error 404
@endsection

@section('login')

<img src="../../assets/image-resources/blurred-bg/blurred-bg-7.jpg" class="login-img wow fadeIn" alt="">

<div class="center-vertical">
    <div class="center-content row">

        <div class="col-md-6 center-margin">
            <div class="server-message wow bounceInDown inverse">
                <h1>Error 401</h1>
                <h2>Página no disponible</h2>
                <p>Esta Página solo esta disponible para usuarios con el rol Administrador. </p>
      
                    
            </div>
        </div>

    </div>
</div>

@endsection