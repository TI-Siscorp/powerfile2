@extends('admin.template.main')

@section('titulo')
{{ trans('principal.titedituser') }}
@endsection

@section('tituloPagina')
<!--h3>Perfil del Usuario: {{ $usuarios->name }}</h3-->
@endsection

@section('contenido')

<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">



<!--div class="panel">
 <div class="panel-body"-->
 	@if ($message = Session::get('mensaje'))
			<div class="alert alert-success">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		         
		        {!! $message !!}
		        
		        {!! Session::forget('mensaje') !!}
		    </div>
    @endif	
<div class="row mailbox-wrapper">	
	<div class="col-md-4">

	    <div class="panel-layout">
	        <div class="panel-box">
	
	            <div class="panel-content image-box">
	                <!--div class="ribbon">
	                    <div class="bg-primary">Ribbon</div>
	                </div-->
	                <div class="image-content font-white">
	
	                    <div class="meta-box meta-box-bottom">
	                        <img src="{{ asset('img/perfiles/'.Session::get('avatar'))}}" alt="" width="200" height="200" class="meta-image img-bordered">
	                        <h3 class="meta-heading">{{ Session::get('nombre') }}</h3>	                       
	                        <h4 class="meta-subheading">{{ $datorol->nombre }}</h4>
	                    </div>
	
	                </div>
	                <img src="{{ asset('assets/image-resources/blurred-bg/blurred-bg-13.jpg')}}" alt="">
	
	            </div>
	            
	            
	            <!-- div class="panel-content pad15A bg-white radius-bottom-all-4">
	
	                <div class="clear profile-box">
	                    <ul class="nav nav-pills nav-justified">
	                        <li>
	                            <a href="#" class="btn btn-sm bg-google">
	                                <span class="glyph-icon icon-separator">
	                                    <i class="glyph-icon icon-google-plus"></i>
	                                </span>
	                                <span class="button-content">
	                                    Google+
	                                </span>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#" class="btn btn-sm bg-facebook">
	                                <span class="glyph-icon icon-separator">
	                                    <i class="glyph-icon icon-facebook"></i>
	                                </span>
	                                <span class="button-content">
	                                    Facebook
	                                </span>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#" class="btn btn-sm bg-twitter">
	                                <span class="glyph-icon icon-separator">
	                                    <i class="glyph-icon icon-twitter"></i>
	                                </span>
	                                <span class="button-content">
	                                    Twitter
	                                </span>
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	                <div class="mrg15T mrg15B"></div>
	                <blockquote class="font-gray">
	                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
	                    <small>
	                        Programmer at
	                        <cite title="Monarch">Monarch</cite>
	                    </small>
	                </blockquote>
	            </div-->
	        </div>
	    </div>
	    <div class="content-box mrg15B">
	        <h3 class="content-box-header clearfix">
	           {{ trans('principal.conectados') }}
	            <div class="font-size-11 float-right">
	                <a href="#" title="">
	                    <i class="glyph-icon mrg5R opacity-hover icon-plus"></i>
	                </a>
	                <a href="#" title="">
	                    <i class="glyph-icon opacity-hover icon-cog"></i>
	                </a>
	            </div>
	        </h3>
	        <div class="content-box-wrapper text-center clearfix">
	            <div class="status-badge mrg10A">
	                <img class="img-circle" width="40" src="../../assets/image-resources/people/testimonial1.jpg" alt="">
	                <div class="small-badge bg-red"></div>
	            </div>
	            <div class="status-badge mrg10A">
	                <img class="img-circle" width="40" src="../../assets/image-resources/people/testimonial2.jpg" alt="">
	                <div class="small-badge bg-orange"></div>
	            </div>
	            <div class="status-badge mrg10A">
	                <img class="img-circle" width="40" src="../../assets/image-resources/people/testimonial3.jpg" alt="">
	                <div class="small-badge bg-red"></div>
	            </div>
	            <div class="status-badge mrg10A">
	                <img class="img-circle" width="40" src="../../assets/image-resources/people/testimonial4.jpg" alt="">
	                <div class="small-badge bg-green"></div>
	            </div>
	            <div class="status-badge mrg10A">
	                <img class="img-circle" width="40" src="../../assets/image-resources/people/testimonial5.jpg" alt="">
	                <div class="small-badge bg-orange"></div>
	            </div>
	            <div class="status-badge mrg10A">
	                <img class="img-circle" width="40" src="../../assets/image-resources/people/testimonial6.jpg" alt="">
	                <div class="small-badge bg-red"></div>
	            </div>
	        </div>
	    </div>
	    
	    <!--div class="content-box mrg15B">
	        <h3 class="content-box-header clearfix">
	            Recent activity
	            <div class="font-size-11 float-right">
	                <a href="#" title="">
	                    <i class="glyph-icon mrg5R opacity-hover icon-plus"></i>
	                </a>
	                <a href="#" title="">
	                    <i class="glyph-icon opacity-hover icon-cog"></i>
	                </a>
	            </div>
	        </h3>
	        <div class="content-box-wrapper text-center clearfix">
	            <div class="timeline-box timeline-box-right">
	                <div class="tl-row">
	                    <div class="tl-item">
	                        <div class="tl-icon bg-yellow">
	                            <i class="glyph-icon icon-eyedropper"></i>
	                        </div>
	                        <div class="popover left">
	                            <div class="arrow"></div>
	                            <div class="popover-content">
	                                <div class="tl-label bs-label label-success">Meeting</div>
	                                <p class="tl-content">Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.</p>
	                                <div class="tl-time">
	                                    <i class="glyph-icon icon-clock-o"></i>
	                                    a few seconds ago
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="tl-row">
	                    <div class="tl-item">
	                        <div class="tl-icon bg-blue">
	                            <i class="glyph-icon icon-line-chart"></i>
	                        </div>
	                        <div class="popover left">
	                            <div class="arrow"></div>
	                            <div class="popover-content">
	                                <div class="tl-label bs-label label-danger">Audio</div>
	                                <p class="tl-content">Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.</p>
	                                <div class="tl-time">
	                                    <i class="glyph-icon icon-clock-o"></i>
	                                    a few seconds ago
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="tl-row">
	                    <div class="tl-item">
	                        <div class="tl-icon bg-blue">
	                            <i class="glyph-icon icon-cab"></i>
	                        </div>
	                        <div class="popover left">
	                            <div class="arrow"></div>
	                            <div class="popover-content">
	                                <div class="tl-label bs-label label-warning">Video</div>
	                                <p class="tl-content">Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.</p>
	                                <div class="tl-time">
	                                    <i class="glyph-icon icon-clock-o"></i>
	                                    a few seconds ago
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div-->
	
	</div>
	<div class="col-md-8">

    <!--  div class="content-box">
        <div class="mail-header clearfix row">
            <div class="col-md-8">
                <span class="mail-title">My Profile</span>
                <div class="btn-group">
                    <a href="#" data-toggle="dropdown" class="btn btn-default btn-small dropdown-toggle"><span class="glyph-icon icon-caret-down"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
            </div>
            <div class="float-right col-md-4 pad0A">
                <div class="input-group">
                    <input type="text" class="form-control">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default" tabindex="-1">
                            <i class="glyph-icon icon-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div-->

    <!--div class="content-box bg-white post-box">
        <textarea name="" class="textarea-autosize" placeholder="What are you doing right now?"></textarea>
        <div class="button-pane">
            <a href="#" class="btn btn-md btn-link hover-white" title="">
                <i class="glyph-icon icon-volume-down"></i>
            </a>
            <a href="#" class="btn btn-md btn-link hover-white" title="">
                <i class="glyph-icon icon-video-camera"></i>
            </a>
            <a href="#" class="btn btn-md btn-link hover-white" title="">
                <i class="glyph-icon icon-microphone"></i>
            </a>
            <a href="#" class="btn btn-md btn-link hover-white" title="">
                <i class="glyph-icon icon-picture-o"></i>
            </a>

            <a href="#" class="btn btn-md btn-post float-right btn-success" title="">
                Share it!
            </a>

        </div>
    </div-->

    <div class="example-box-wrapper">
        <ul class="list-group row list-group-icons">
            <li class="col-md-3 active">
                <a href="#tab-example-4" data-toggle="tab" class="list-group-item">
                    <i class="glyph-icon font-red icon-user sombraicono"></i> 
                    {{ trans('principal.infop') }} 
                </a>
            </li>
            <li class="col-md-3">
                <a href="#tab-example-1" data-toggle="tab" class="list-group-item">
                    <i class="glyph-icon font-green icon-lock sombraicono"></i>
                    {{ trans('principal.cclave') }}   
                </a>
            </li>
            <li class="col-md-3">
                <a href="#tab-example-2" data-toggle="tab" class="list-group-item">
                    <i class="glyph-icon font-primary icon-list-alt sombraicono"></i>
                    {{ trans('principal.bmsj') }} 
                </a>
            </li>
            <li class="col-md-3">
                <a href="#tab-example-3" data-toggle="tab" class="list-group-item">
                    <i class="glyph-icon font-blue-alt icon-question sombraicono"></i>
                     {{ trans('principal.pregf') }} 
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="tab-example-1">
                <div class="alert alert-close alert-success">
                    <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
                    <div class="bg-green alert-icon">
                        <i class="glyph-icon icon-check"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">Example Infobox</h4>
                        <p>Lorem ipsum dolor sic amet dixit tu...</p>
                    </div>
                </div>
                <div class="row">
                    <!--div class="col-md-6">
                        <div class="content-box">
                            <form class="form-horizontal clearfix pad15L pad15R pad20B bordered-row">
                                <div class="form-group remove-border">
                                    <label class="col-sm-7 control-label">Enable account:</label>
                                    <div class="col-sm-3">
                                        <input type="checkbox" class="input-switch-alt">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-7 control-label">Visible Profile</label>
                                    <div class="col-sm-3">
                                        <input type="checkbox" checked class="input-switch-alt">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-7 control-label">Hide timeline</label>
                                    <div class="col-sm-3">
                                        <input type="checkbox" data-on-color="danger" data-size="small" name="checkbox-example-1" class="input-switch" data-on-text="On" data-off-text="Off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-7 control-label">Is it active?</label>
                                    <div class="col-sm-3">
                                        <input type="checkbox" data-on-color="info" data-size="small" name="checkbox-example-2" class="input-switch" data-on-text="On" data-off-text="Off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-7 control-label">Radio example</label>
                                    <div class="col-sm-3">
                                        <input type="checkbox" data-on-color="success" data-size="small" name="checkbox-example-3" class="input-switch" checked data-on-text="On" data-off-text="Off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div-->
                    <div class="col-md-6">
                        <div class="content-box mrg15B">
                            <h3 class="content-box-header clearfix">
                                {{ trans("principal.cambcla") }}
                                <!--div class="font-size-11 float-right">
                                    <a href="#" title="">
                                        <i class="glyph-icon mrg5R opacity-hover icon-plus"></i>
                                    </a>
                                    <a href="#" title="">
                                        <i class="glyph-icon opacity-hover icon-cog"></i>
                                    </a>
                                </div-->
                            </h3>
                            <div class="content-box-wrapper pad0T clearfix">
                                {!! Form::model($usuarios, ['method' => 'POST','route' => ['usuarios.updateclave', $usuarios->id],'class'=>'form-horizontal bordered-row']) !!}
                                <form class="form-horizontal pad15L pad15R bordered-row">
                                    
                                    <div class="form-group">
                                        {!! Form::label('password_nueva',trans("principal.inputnucla"),['class'=>'col-sm-3 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('password_nueva',['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('password_confirm',trans("principal.inputconfcla"),['class'=>'col-sm-3 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('password_confirm',['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group centrartexto" >
										{!! Form::submit(trans("principal.btnact"),['class'=>'btn btn-primary'])!!}
									</div>
                                    
                                </form>
                            </div>
                            <!--  div class="button-pane mrg20T">
                                <button class="btn btn-primary">Actualizar</button>
                            </div-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-example-2">
                <div class="content-box pad25A">
                    <ul class="chat-box">
                        <li>
                            <div class="chat-author">
                                <img width="36" src="../../assets/image-resources/gravatar.jpg" alt="">
                            </div>
                            <div class="popover left no-shadow">
                                <div class="arrow"></div>
                                <div class="popover-content">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
                                    <div class="chat-time">
                                        <i class="glyph-icon icon-clock-o"></i>
                                        a few seconds ago
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="float-left">
                            <div class="chat-author">
                                <img width="36" src="../../assets/image-resources/gravatar.jpg" alt="">
                            </div>
                            <div class="popover right no-shadow">
                                <div class="arrow"></div>
                                <div class="popover-content">
                                    <h3>
                                        <a href="#" title="Agile UI">Agile UI</a>
                                        <div class="float-right">
                                            <a href="#" class="btn glyph-icon icon-inbox font-gray tooltip-button" data-placement="bottom" title="This chat line was received in the mail."></a>
                                        </div>
                                    </h3>
                                    This comment line has a title (author name) and a right button panel.
                                    <div class="chat-time">
                                        <i class="glyph-icon icon-clock-o"></i>
                                        a few seconds ago
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="chat-author">
                                <img width="36" src="../../assets/image-resources/gravatar.jpg" alt="">
                            </div>
                            <div class="popover left no-shadow">
                                <div class="arrow"></div>
                                <div class="popover-content">
                                    This comment line has a bottom button panel, box shadow and title.
                                    <div class="chat-time">
                                        <i class="glyph-icon icon-clock-o"></i>
                                        a few seconds ago
                                    </div>
                                    <div class="divider"></div>
                                    <a href="#" class="btn btn-sm btn-default font-bold text-transform-upr" title=""><span class="button-content">Reply</span></a>
                                    <a href="#" class="btn btn-sm btn-danger float-right tooltip-button" data-placement="left" title="Remove comment"><i class="glyph-icon icon-remove"></i></a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="chat-author">
                                <img width="36" src="../../assets/image-resources/gravatar.jpg" alt="">
                            </div>
                            <div class="popover left no-shadow">
                                <div class="arrow"></div>
                                <div class="popover-content">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
                                    <div class="chat-time">
                                        <i class="glyph-icon icon-clock-o"></i>
                                        a few seconds ago
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="float-left">
                            <div class="chat-author">
                                <img width="36" src="../../assets/image-resources/gravatar.jpg" alt="">
                            </div>
                            <div class="popover right no-shadow">
                                <div class="arrow"></div>
                                <div class="popover-content">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
                                    <div class="chat-time">
                                        <i class="glyph-icon icon-clock-o"></i>
                                        a few seconds ago
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-example-3">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="mrg10B">
                                <a href="#faq-tab-1" data-toggle="tab" class="list-group-item">
                                    How to get paid
                                    <i class="glyph-icon icon-angle-right mrg0A"></i>
                                </a>
                            </li>
                            <li class="mrg10B">
                                <a href="#faq-tab-2" data-toggle="tab" class="list-group-item">
                                    ThemeForest related
                                    <i class="glyph-icon font-green icon-angle-right mrg0A"></i>
                                </a>
                            </li>
                            <li class="mrg10B">
                                <a href="#faq-tab-3" data-toggle="tab" class="list-group-item">
                                    Common questions
                                    <i class="glyph-icon icon-angle-right mrg0A"></i>
                                </a>
                            </li>
                            <li class="mrg10B">
                                <a href="#faq-tab-4" data-toggle="tab" class="list-group-item">
                                    Terms of service
                                    <i class="glyph-icon icon-angle-right mrg0A"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active in pad0A" id="faq-tab-1">
                                <div class="panel-group" id="accordion5">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion5" href="#collapseOne">
                                                    Collapsible Group Item #1
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion5" href="#collapseTwo">
                                                    Collapsible Group Item #2
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion5" href="#collapseThree">
                                                    Collapsible Group Item #3
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade pad0A" id="faq-tab-2">
                                <div class="panel-group" id="accordion1">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1">
                                                    Collapsible Group Item #1
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1">
                                                    Collapsible Group Item #2
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1">
                                                    Collapsible Group Item #3
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade pad0A" id="faq-tab-3">
                                <div class="panel-group" id="accordion2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
                                                    Collapsible Group Item #1
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne2" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo2">
                                                    Collapsible Group Item #2
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseThree2">
                                                    Collapsible Group Item #3
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade pad0A" id="faq-tab-4">
                                <div class="panel-group" id="accordion3">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne4">
                                                    Collapsible Group Item #1
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne4" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo4">
                                                    Collapsible Group Item #2
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo4" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree4">
                                                    Collapsible Group Item #3
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree4" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pad0A fade active in" id="tab-example-4">
                <div class="content-box">	
    		    
			    {!! Form::model($usuarios, ['method' => 'PATCH','route' => ['usuarios.update', $usuarios->id],'class'=>'form-horizontal bpad15L pad15R bordered-row','files'=>true,'enctype' => 'multipart/form-data']) !!}
			    
			    		<div class="form-group centrartexto" >
							{!! Form::label('avatar','Avatar',['class'=>'col-sm-3 control-label']) !!}
								<div class="col-sm-6">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" id="vistaprevia" data-trigger="fileinput" style="width: 200px; height: 150px;">
											@if ($usuarios->avatar != '')
												<img src="{{ asset('img/perfiles/'.$usuarios->avatar)}}" alt="" width="150" />
											@endif
										</div>
										<a href="javascript:;"  class="fileinput-exists glyphicon glyphicon-remove icoremover" id="resetear" data-dismiss="fileinput" style="position:relative;float:right"></a>
										<div>
											<span class="btn btn-default btn-file">
											<span class="fileinput-new">{{ trans('principal.savatar') }}</span>
											<span class="fileinput-exists">{{ trans('principal.mcamb') }}</span> 
												{!! Form::file('avatar', array('multiple'=>false)) !!}
											 
												<input id="avatar_tempo" name="avatar_tempo" type="hidden" value="{{$usuarios->avatar}}">
												<input id="datos_perfil" name="datos_perfil" type="hidden" value="p">
												<input id="id_rol" name="id_rol" type="hidden" value="{{$usuarios->id_rol}}">
												<input id="id_estado" name="id_estado" type="hidden" value="{{$usuarios->id_estado}}">
											</span>
									
										</div>
									</div>
								</div>
						</div>
			    
			    		<div class="form-group remove-border">
			    			
							{!! Form::label('lastname',trans("principal.inputnombre"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::text('name',null,['class'=>'form-control']) !!}
							</div>
						</div>
                        
                        <div class="form-group">
							{!! Form::label('lastname',trans("principal.inputapellido"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::text('lastname',null,['class'=>'form-control']) !!}
							</div>
						</div>
                        
                        
                        <div class="form-group">
							{!! Form::label('cedula',trans("principal.inputced"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::text('cedula',null,['class'=>'form-control']) !!}
							</div>
						</div>
					
						<div class="form-group">
							{!! Form::label('login',trans("principal.inputlogin"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::text('login',null,['class'=>'form-control']) !!}
							</div>
						</div>
							
						<div class="form-group">
							{!! Form::label('email',trans("principal.inputmail"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::email('email',null,['class'=>'form-control']) !!}
								
								{!! Form::hidden('password','',['class'=>'form-control']) !!}
								{!! Form::hidden('password_tempo',$usuarios->password,['class'=>'form-control']) !!}
							</div>
						</div>
                       
                        
                        <div class="form-group">
							{!! Form::label('celular',trans("principal.inputcel"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::text('celular',null,['class'=>'form-control']) !!}
							</div>
						</div>
					
						<div class="form-group">
							{!! Form::label('fijo',trans("principal.inputfijo"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::text('fijo',null,['class'=>'form-control']) !!}
							</div>
						</div>
					
							
						<div class="form-group">
							{!! Form::label('direccion',trans("principal.inputdir"),['class'=>'col-sm-3 control-label']) !!}
							<div class="col-sm-6">
								{!! Form::textarea('direccion',null,['class'=>'form-control','rows' => 2, 'cols' => 40]) !!}
							</div>
						</div>
						
											
						
							
						<div class="form-group centrartexto" >
							{!! Form::submit(trans("principal.btngu"),['class'=>'btn btn-primary'])!!} 
							{{ link_to_route('usuarios.index', trans("principal.btnca"), '', array('class'=>'btn btn-danger btn-close')) }}
						</div>	
						
                        
                        
                        
					{!! Form::close() !!}
					</div>		
				</div>
    		</div>
		</div>
	</div>	
</div>						
	<!--/div>
</div-->
<script>

	
	

	$(document).ready(function () {

		 $('#bppal').attr('data-visor','');
			
		 $('#bppal').attr('data-controller','usuario'); 
		 
		//se carga el valor de la imagen q tenga por defecto si la tiene
		$('#password').bind('blur', function () {
		//se valida con su confirmacion
		if ($('#password_nueva').val() != '' && $('#password_confirm').val() != '')
			{
				if ($('#password_nueva').val() != $('#password_confirm').val() )
					{
						alert('{{ trans("principal.msgerrpass") }}'); 
						$('#password_nueva').val('');
						$('#password_confirm').val('');
					}
			}
		});
		 $('#password_confirm').bind('blur', function () {
			 //se valida con su confirmacion
		 	if ($('#password').val() != '' && $('#password_confirm').val() != '')
				{
					if ($('#password_nueva').val() != $('#password_confirm').val() )
						{
							alert('{{ trans("principal.msgerrpass") }}'); 
							$('#password_nueva').val('');
							$('#password_confirm').val('');
						}
				}
		 });

	});

		if (window.FileReader) {
			function seleccionArchivo(evt) {
				var files = evt.target.files;
				var f = files[0];
				var leerArchivo = new FileReader();
				document.getElementById('resetear').style.display= 'block';
				leerArchivo.onload = (function(elArchivo) {
					return function(e) {
						$("#vistaprevia").html('<img src="'+ e.target.result +'" alt="" width="150" />');
					};
				})(f);
				 
				leerArchivo.readAsDataURL(f);
			}
		}
		else
		{
			$("#vistaprevia").html('{{ trans("principal.msgerrpreview") }}'); 
		}

		document.getElementById('avatar').addEventListener('change', seleccionArchivo, false);

		function cancela(elForm){
		 document.getElementById(elForm).reset();
		 if (window.FileReader)
			{
				document.getElementById('vistaprevia').innerHTML = '{{ trans("principal.Preview") }}';
			}
		 else
		 {
		 	$("#vistaprevia").html('{{ trans("principal.msgerrpreview") }}');
		 }
		 document.getElementById('resetear').style.display= 'none';
		}
		 
		 
		$('#resetear').bind('click', function () {
			//se limpia la seleccion de avatar
			$("#avatar").val("");
			$("#resetear").hide();
			$("#vistaprevia").html('<img src="../../img/perfiles/'+$("#avatar_tempo").val()+'" alt="" width="150" />');
		});

		$('div.alert').delay(3000).slideUp(300);
</script>	
@endsection