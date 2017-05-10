<!DOCTYPE html> 
<html lang="en">
<head>
@inject('permisos','App\helpers\Util')     
<?php
	@session_start();
	@require app_path().'/translation.php';
	
	$ruta= $permisos->verurl();
	
	$espaciotrabajo = $_SESSION['espaciotrabajo'];
	
	$workspace = $_SESSION['espaciotrabajo'];
	
	$vernoti = $permisos->misnotifica();  
	
	
	if ($vernoti == true)
		{
			$notificaciones = $permisos->vernotificaciones();
		}
	else 
		{	
			$notificaciones = '';
		}
	
?>	

 
    <style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        .sombraizq{
        	-webkit-box-shadow: 2px 2px 5px #999;
			  -moz-box-shadow: 2px 2px 5px #999;
			  filter: shadow(color=#999999, direction=135, strength=2);
        }
        
        .sombrader{
        	-webkit-box-shadow: -2px -2px -5px #999 !important;
			-moz-box-shadow: -2px -2px -5px #999 !important;
			filter: shadow(color=#999999, direction=-135, strength=2) !important;
			border-style: solid !important;
   			border-left-color: #DFE8F1!important;
   			border-top-color: #DFE8F1!important;
   			border-width: 1px;
        }
    </style>





    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>@yield('titulo','Default') | {{ env('BUSINESS', 'Powerfile') }}</title>
<link rel="shortcut icon" href="{{{ asset('img/icosiscorp.png') }}}">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/images/icons/apple-touch-icon-144-precomposed.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/images/icons/apple-touch-icon-114-precomposed.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/images/icons/apple-touch-icon-72-precomposed.png') }}">
<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/icons/apple-touch-icon-57-precomposed.png') }}">
<!-- link rel="shortcut icon" href="{{ asset('assets/img/icosiscorp.png') }}"-->



    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">


<!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/backgrounds.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/boilerplate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/border-radius.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/grid.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/page-transitions.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/spacing.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/typography.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/utils.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/colors.css') }}">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/badges.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/buttons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/content-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/dashboard-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/forms.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/images.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/info-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/invoice.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/loading-indicators.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/menus.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/panel-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/response-messages.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/responsive-tables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/ribbon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/social-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/tables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/tile-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/elements/timeline.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('css/estilo_powerfile.css') }}">



<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/fontawesome/fontawesome.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/linecons/linecons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/spinnericon/spinnericon.css') }}">


<!-- WIDGETS -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/owlcarousel/owlcarousel.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/accordion-ui/accordion.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/calendar/calendar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/carousel/carousel.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/charts/justgage/justgage.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/charts/morris/morris.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/charts/piegage/piegage.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/charts/xcharts/xcharts.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/chosen/chosen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/colorpicker/colorpicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/datatable/datatable.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/datepicker/datepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/datepicker-ui/datepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/dialog/dialog.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/dropdown/dropdown.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/dropzone/dropzone.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/file-input/fileinput.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/input-switch/inputswitch.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/input-switch/inputswitch-alt.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/ionrangeslider/ionrangeslider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/jcrop/jcrop.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/jgrowl-notifications/jgrowl.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/loading-bar/loadingbar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/maps/vector-maps/vectormaps.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/markdown/markdown.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/modal/modal.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/multi-select/multiselect.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/multi-upload/fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/nestable/nestable.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/noty-notifications/noty.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/popover/popover.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/pretty-photo/prettyphoto.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/progressbar/progressbar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/range-slider/rangeslider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/slidebars/slidebars.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/slider-ui/slider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/summernote-wysiwyg/summernote-wysiwyg.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/tabs-ui/tabs.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/theme-switcher/themeswitcher.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/timepicker/timepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/tocify/tocify.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/tooltip/tooltip.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/touchspin/touchspin.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/uniform/uniform.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/wizard/wizard.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/xeditable/xeditable.css') }}">

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/chat.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/files-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/login-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/notification-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/progress-box.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/todo.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/user-profile.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/snippets/mobile-navigation.css') }}">

<!-- APPLICATIONS -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/applications/mailbox.css') }}">

<!-- Admin theme -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/themes/admin/layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/themes/admin/color-schemes/default.css') }}">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/themes/components/default.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/themes/components/border-radius.css') }}">

<!-- Admin responsive -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/responsive-elements.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/helpers/admin-responsive.css') }}">

    <!-- JS Core -->

    <script type="text/javascript" src="{{ asset('assets/js-core/jquery-core.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-core.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-widget.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-mouse.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-position.js') }}"></script>
    <!--<script type="text/javascript" src="{{ asset('assets/js-core/transition.js') }}"></script>-->
    <script type="text/javascript" src="{{ asset('assets/js-core/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js-core/jquery-cookie.js') }}"></script>





    <script type="text/javascript">
        $(window).load(function(){
            setTimeout(function() {
                $('#loading').fadeOut( 400, "linear" );
            }, 300);
        });
    </script>



</head>


    <body id="bppal" data-buscarlo="" data-visor=""> 
    <div id="sb-site">
    <div id="sliderizq" class="sb-slidebar bg-white sb-left sb-style-overlay sombraizq">
    <div id="ladoizq" class="scrollable-content scrollable-slim-sidebar">
    
    <!--div id="google_translate_element"></div>
    	<script type="text/javascript">
			function googleTranslateElementInit() {
			  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,es,fr', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
			}
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script-->

		
		
        <div class="pad10A">
        
        	
        	
            <div class="divider-header">Online</div>
            <ul class="chat-box">
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial1.jpg') }}" alt="">
                        <div class="small-badge bg-green"></div>
                    </div>
                    <b>
                        Grace Padilla
                    </b>
                    <p>On the other hand, we denounce...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial2.jpg') }}" alt="">
                        <div class="small-badge bg-green"></div>
                    </div>
                    <b>
                        Carl Gamble
                    </b>
                    <p>Dislike men who are so beguiled...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial3.jpg') }}" alt="">
                        <div class="small-badge bg-green"></div>
                    </div>
                    <b>
                        Michael Poole
                    </b>
                    <p>Of pleasure of the moment, so...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial4.jpg') }}" alt="">
                        <div class="small-badge bg-green"></div>
                    </div>
                    <b>
                        Bill Green
                    </b>
                    <p>That they cannot foresee the...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial5.jpg') }}" alt="">
                        <div class="small-badge bg-green"></div>
                    </div>
                    <b>
                        Cheryl Soucy
                    </b>
                    <p>Pain and trouble that are bound...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
            </ul>
            <div class="divider-header">Idle</div>
            <ul class="chat-box">
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial6.jpg') }}" alt="">
                        <div class="small-badge bg-orange"></div>
                    </div>
                    <b>
                        Jose Kramer
                    </b>
                    <p>Equal blame belongs to those...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial7.jpg') }}" alt="">
                        <div class="small-badge bg-orange"></div>
                    </div>
                    <b>
                        Dan Garcia
                    </b>
                    <p>Weakness of will, which is same...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial8.jpg') }}" alt="">
                        <div class="small-badge bg-orange"></div>
                    </div>
                    <b>
                        Edward Bridges
                    </b>
                    <p>These cases are perfectly simple...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
            </ul>
            <div class="divider-header">Offline</div>
            <ul class="chat-box">
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial1.jpg') }}" alt="">
                        <div class="small-badge bg-red"></div>
                    </div>
                    <b>
                        Randy Herod
                    </b>
                    <p>In a free hour, when our power...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
                <li>
                    <div class="status-badge">
                        <img class="img-circle" width="40" src="{{ asset('assets/image-resources/people/testimonial2.jpg') }}" alt="">
                        <div class="small-badge bg-red"></div>
                    </div>
                    <b>
                        Patricia Bagley
                    </b>
                    <p>when nothing prevents our being...</p>
                    <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="lderecho" class="sb-slidebar bg-white sb-right sb-style-overlay sombrader">
<div id="ladoder" class="scrollable-content scrollable-slim-sidebar" >
<div class="pad15A">
<a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-1" class="popover-title">
    Cloud status
    <span class="caret"></span>
</a>
<div id="sidebar-toggle-1" class="collapse in">
    <div class="pad15A container">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center font-gray pad5B text-transform-upr font-size-12">New visits</div>
                <div class="chart-alt-3 font-gray-dark" data-percent="55"><span>55</span>%</div>
            </div>
            <div class="col-md-4">
                <div class="text-center font-gray pad5B text-transform-upr font-size-12">Bounce rate</div>
                <div class="chart-alt-3 font-gray-dark" data-percent="46"><span>46</span>%</div>
            </div>
            <div class="col-md-4">
                <div class="text-center font-gray pad5B text-transform-upr font-size-12">Server load</div>
                <div class="chart-alt-3 font-gray-dark" data-percent="92"><span>92</span>%</div>
            </div>
        </div>
        <div class="divider mrg15T mrg15B"></div>
        <div class="text-center">
            <a href="#" class="btn center-div btn-info mrg5T btn-sm text-transform-upr updateEasyPieChart">
                <i class="glyph-icon icon-refresh"></i>
                Update charts
            </a>
        </div>
    </div>
</div>

<div class="clear"></div>

<a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-6" class="popover-title">
    Latest transfers
    <span class="caret"></span>
</a>
<div id="sidebar-toggle-6" class="collapse in">

    <ul class="files-box">
        <li>
            <i class="files-icon glyph-icon font-red icon-file-archive-o"></i>
            <div class="files-content">
                <b>blog_export.zip</b>
                <div class="files-date">
                    <i class="glyph-icon icon-clock-o"></i>
                    added on <b>22.10.2014</b>
                </div>
            </div>
            <div class="files-buttons">
                <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                    <i class="glyph-icon icon-cloud-download"></i>
                </a>
                <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                    <i class="glyph-icon icon-times"></i>
                </a>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <i class="files-icon glyph-icon icon-file-code-o"></i>
            <div class="files-content">
                <b>homepage-test.html</b>
                <div class="files-date">
                    <i class="glyph-icon icon-clock-o"></i>
                    added  <b>19.10.2014</b>
                </div>
            </div>
            <div class="files-buttons">
                <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                    <i class="glyph-icon icon-cloud-download"></i>
                </a>
                <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                    <i class="glyph-icon icon-times"></i>
                </a>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <i class="files-icon glyph-icon font-yellow icon-file-image-o"></i>
            <div class="files-content">
                <b>monthlyReport.jpg</b>
                <div class="files-date">
                    <i class="glyph-icon icon-clock-o"></i>
                    added on <b>10.9.2014</b>
                </div>
            </div>
            <div class="files-buttons">
                <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                    <i class="glyph-icon icon-cloud-download"></i>
                </a>
                <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                    <i class="glyph-icon icon-times"></i>
                </a>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <i class="files-icon glyph-icon font-green icon-file-word-o"></i>
            <div class="files-content">
                <b>new_presentation.doc</b>
                <div class="files-date">
                    <i class="glyph-icon icon-clock-o"></i>
                    added on <b>5.9.2014</b>
                </div>
            </div>
            <div class="files-buttons">
                <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                    <i class="glyph-icon icon-cloud-download"></i>
                </a>
                <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                    <i class="glyph-icon icon-times"></i>
                </a>
            </div>
        </li>
    </ul>

</div>

<div class="clear"></div>

<a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-3" class="popover-title">
    Tasks for today
    <span class="caret"></span>
</a>
<div id="sidebar-toggle-3" class="collapse in">

    <ul class="progress-box">
        <li>
            <div class="progress-title">
                New features development
                <b>87%</b>
            </div>
            <div class="progressbar-smaller progressbar" data-value="87">
                <div class="progressbar-value bg-azure">
                    <div class="progressbar-overlay"></div>
                </div>
            </div>
        </li>
        <li>
            <b class="pull-right">66%</b>
            <div class="progress-title">
                Finishing uploading files
                
            </div>
            <div class="progressbar-smaller progressbar" data-value="66">
                <div class="progressbar-value bg-red">
                    <div class="progressbar-overlay"></div>
                </div>
            </div>
        </li>
        <li>
            <div class="progress-title">
                Creating tutorials
                <b>58%</b>
            </div>
            <div class="progressbar-smaller progressbar" data-value="58">
                <div class="progressbar-value bg-blue-alt"></div>
            </div>
        </li>
        <li>
            <div class="progress-title">
                Frontend bonus theme
                <b>74%</b>
            </div>
            <div class="progressbar-smaller progressbar" data-value="74">
                <div class="progressbar-value bg-purple"></div>
            </div>
        </li>
    </ul>

</div>

<div class="clear"></div>

<a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-4" class="popover-title">
    Pending notifications
    <span class="bs-label bg-orange tooltip-button" title="Label example">New</span>
    <span class="caret"></span>
</a>
<div id="sidebar-toggle-4" class="collapse in">
    <ul class="notifications-box notifications-box-alt">
        <li>
            <span class="bg-purple icon-notification glyph-icon icon-users"></span>
            <span class="notification-text">This is an error notification</span>
            <div class="notification-time">
                a few seconds ago
                <span class="glyph-icon icon-clock-o"></span>
            </div>
            <a href="#" class="notification-btn btn btn-xs btn-black tooltip-button" data-placement="left" title="View details">
                <i class="glyph-icon icon-arrow-right"></i>
            </a>
        </li>
        <li>
            <span class="bg-warning icon-notification glyph-icon icon-ticket"></span>
            <span class="notification-text">This is a warning notification</span>
            <div class="notification-time">
                <b>15</b> minutes ago
                <span class="glyph-icon icon-clock-o"></span>
            </div>
            <a href="#" class="notification-btn btn btn-xs btn-black tooltip-button" data-placement="left" title="View details">
                <i class="glyph-icon icon-arrow-right"></i>
            </a>
        </li>
        <li>
            <span class="bg-green icon-notification glyph-icon icon-random"></span>
            <span class="notification-text font-green">A success message example.</span>
            <div class="notification-time">
                <b>2 hours</b> ago
                <span class="glyph-icon icon-clock-o"></span>
            </div>
            <a href="#" class="notification-btn btn btn-xs btn-black tooltip-button" data-placement="left" title="View details">
                <i class="glyph-icon icon-arrow-right"></i>
            </a>
        </li>
    </ul>
</div>
</div>
</div>
</div>
    <div id="loading">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div id="page-wrapper">
        <div id="page-header" class="bg-gradient-9">
    <div id="mobile-navigation">
        <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button>
        <a href="index.html" class="logo-content-small" title="MonarchUI"></a>
    </div>
    <div id="header-logo" class="logo-bg">
        <a href="{{ url($_SESSION['espaciotrabajo'].'/principal') }}" class="logo-content-big " title="{{ env('BUSINESS', 'Powerfile') }}" style="background: url('{{ asset('img/logos/'.Session::get('logo'))}}') left no-repeat; background-size: 50px 50px; background-size: 100% 100%;">
           <span>Sistema de Gesti�n Documental</span> : 
        </a>
        <a href="{{ url('principal.home') }}" class="logo-content-small" title="Powerfile">
           
            <span>Sistema de Gesti�n Documental</span> : 
        </a>
        
        <a id="close-sidebar" href="#" title="Close sidebar">
            <i class="glyph-icon icon-angle-left"></i>
        </a>
    </div>
    <div id="header-nav-left">
        <div class="user-account-btn dropdown">
            <a href="#" title="{{ trans('principal.mcta')}}" class="user-profile clearfix" data-toggle="dropdown">
                <img width="33" height="33" src="{{ asset('img/perfiles/'.Session::get('avatar'))}}" alt="" class="img-borde_redonde">
                <span>{{ Session::get('nombre') }}</span>  <!-- $user->name -->
                <i class="glyph-icon icon-angle-down"></i>
            </a>
            <div class="dropdown-menu float-left">
                <div class="box-sm">
                    <div class="login-box clearfix">
                        <div class="user-img">
                            <!--  a href="#" title="" class="change-img">Change photo</a-->
                            <img width="33" height="33" class="img-borde_redonde" src="{{ asset('img/perfiles/'.Session::get('avatar')) }}" alt="">
                        </div>
                        <div class="user-info">
                            <span>
                               {{ Session::get('nombre') }}
                                <!-- i>UX/UI developer</i-->
                            </span>
                            <!--a href="{{ url('usuarios.perfil')}}" title="Perfil">Ver perfil</a-->
                            
                            
                            <a href="{{ route('usuarios.perfiles',Session::get('id_usuario')) }}" title="Perfil">{{ trans('principal.vperfil') }}</a>
                            <a href="#" title="Notificaciones">{{ trans('principal.vnoti') }}</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <!--  ul class="reset-ul mrg5B">
                        <li>
                            <a href="#">
                                <i class="glyph-icon float-right icon-caret-right"></i>
                                View login page example
                                
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="glyph-icon float-right icon-caret-right"></i>
                                View lockscreen example
                                
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="glyph-icon float-right icon-caret-right"></i>
                                View account details
                                
                            </a>
                        </li>
                    </ul-->
                    <div class="pad5A button-pane button-pane-alt text-center">
                        <a href="{{ URL::to($espaciotrabajo.'/logout') }}" class="btn display-block font-normal btn-danger">
                            <i class="glyph-icon icon-power-off"></i>
                            {{ trans('principal.cierres') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #header-nav-left -->

    <div id="header-nav-right">
        <!--a href="#" class="hdr-btn popover-button" title="{{ trans('principal.placehbusca') }}" data-placement="bottom" data-id="#popover-search" --> 
        <a data-toggle="dropdown" href="#"  data-placement="bottom" class="popover-button-header tooltip-button hdr-btn" title="{{ trans('principal.placehbusca') }}">
            <i class="glyph-icon icon-search sombraicono"></i>
        </a>
        <div class="hide" id="popover-search">
            <div class="pad5A box-md">
                <div class="input-group">
                    <input id="busca_secun" name="busca_secun" type="text" class="form-control"  onkeyup="captura(this.value,event)" placeholder="{{ trans('principal.placehbusca') }} "> 
                    <span class="input-group-btn">
                        <a id="busquedasecun" class="btn btn-primary" onclick="buscarsec()" href="javascript:;">{{ trans('principal.search') }} </a>
                    </span>
                </div>
            </div>
        </div>
        <!--a href="#" class="hdr-btn" id="fullscreen-btn" title="{{ trans('principal.modop')}}"-->
        <a data-toggle="dropdown" href="#"  data-placement="bottom" class="popover-button-header tooltip-button hdr-btn" title="{{ trans('principal.modop')}}">
            <i class="glyph-icon icon-arrows-alt"></i>
        </a>
        <!--a href="#" class="hdr-btn sb-toggle-left" id="chatbox-btn" title="Chat sidebar">
            <i class="glyph-icon icon-linecons-paper-plane"></i>
        </a-->
        
        
        <div class="dropdown" id="notifications-btn" >
        	<a data-toggle="dropdown" href="#"  data-placement="bottom" class="popover-button-header tooltip-button" title="{{ trans('principal.notificas') }}"><?php 
            	if ($vernoti == true)
            		{?>
                		<span class="small-badge bg-yellow"></span><?php 
                	}	
                else
                	{?>
                		<span ></span><?php 
                	}?>
                <i class="glyph-icon icon-linecons-megaphone"></i>
            </a>
            <div class="dropdown-menu box-md float-right anchonotifica">

                <div class="popover-title display-block clearfix pad10A">
                    {{ trans('principal.notificas') }}  
                    <!--a class="text-transform-cap font-primary font-normal btn-link float-right" href="#" title="View more options">
                        More options...
                    </a-->
                </div>
                <div id="notifica_docum" class="scrollable-content scrollable-slim-box">
                   <?php echo $notificaciones; ?>
                </div>
                <!--div class="pad10A button-pane button-pane-alt text-center">
                    <a href="#" class="btn btn-primary" title="View all notifications">
                        View all notifications
                    </a>
                </div-->
            </div>
        </div>
        <!--div class="dropdown" id="progress-btn">
            <a data-toggle="dropdown" href="#" title="">
                <span class="small-badge bg-azure"></span>
                <i class="glyph-icon icon-linecons-params"></i>
            </a>
            <div class="dropdown-menu pad0A box-sm float-right" id="progress-dropdown">
                <div class="scrollable-content scrollable-slim-box">
                    <ul class="no-border progress-box progress-box-links">
                        <li>
                            <a href="#" title="">
                                <b class="pull-right">23%</b>
                                <div class="progress-title">
                                    Finishing uploading files
                                    
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="23">
                                    <div class="progressbar-value bg-blue-alt">
                                        <div class="progressbar-overlay"></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <b class="pull-right">91%</b>
                                <div class="progress-title">
                                    Roadmap progress
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="91">
                                    <div class="progressbar-value bg-red">
                                        <div class="progressbar-overlay"></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <b class="pull-right">58%</b>
                                <div class="progress-title">
                                    Images upload
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="58">
                                    <div class="progressbar-value bg-green"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <b class="pull-right">74%</b>
                                <div class="progress-title">
                                    WordPress migration
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="74">
                                    <div class="progressbar-value bg-purple"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                 <b class="pull-right">91%</b>
                                <div class="progress-title">
                                    Agile development procedures
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="91">
                                    <div class="progressbar-value bg-black">
                                        <div class="progressbar-overlay"></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <b class="pull-right">58%</b>
                                <div class="progress-title">
                                    Systems integration
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="58">
                                    <div class="progressbar-value bg-azure"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                 <b class="pull-right">97%</b>
                                <div class="progress-title">
                                    Code optimizations
                                </div>
                                <div class="progressbar-smaller progressbar" data-value="97">
                                    <div class="progressbar-value bg-yellow"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="pad5A button-pane button-pane-alt text-center">
                    <a href="#" class="btn display-block font-normal hover-green" title="View all notifications">
                        View all notifications
                    </a>
                </div>
            </div>
        </div-->
        <!--div class="dropdown" id="cloud-btn">
            <a href="#" data-placement="bottom" class="tooltip-button sb-toggle-right" title="Statistics Sidebar">
                <i class="glyph-icon icon-linecons-cloud"></i>
            </a>
        </div-->
        <div class="dropdown" id="dashnav-btn">
            <a href="#" data-toggle="dropdown" data-placement="bottom" class="popover-button-header tooltip-button" title="{{ trans('principal.idiomas') }} ">
                <i class="glyph-icon icon-linecons-cog"></i>
            </a>
            <div class="dropdown-menu float-right">
                <div class="box-sm">
                    <div class="pad5T pad5B pad10L pad10R dashboard-buttons clearfix">
                        <a href="{{ url('lang', ['es']) }}" class="btn vertical-button hover-azure" title="">   
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                              <img  width="40" src="{{ asset('img/Spain-Flag.png') }}" alt="">
                            </span>
                            	{{ trans('principal.idiomae') }}                    
                        </a>
                        <a href="{{ url('lang', ['en']) }}" class="btn vertical-button hover-green" title="">			
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <img  width="40" src="{{ asset('img/United-Kingdom-flag-icon40.png') }}" alt="">
                            </span>
                           		{{ trans('principal.idiomai') }}
                        </a>
                        
                        						
                        <!--a href="#" class="btn vertical-button hover-orange" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-fire opacity-80 font-size-20"></i>
                            </span>
                            Tables
                        </a>
                        <a href="#" class="btn vertical-button hover-orange" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-bar-chart-o opacity-80 font-size-20"></i>
                            </span>
                            Charts
                        </a>
                        <a href="#" class="btn vertical-button hover-purple" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-laptop opacity-80 font-size-20"></i>
                            </span>
                            Buttons
                        </a>
                        <a href="#" class="btn vertical-button hover-azure" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-code opacity-80 font-size-20"></i>
                            </span>
                            Panels
                        </a-->
                    </div>
                    <!--div class="divider"></div>
                    <div class="pad5T pad5B pad10L pad10R dashboard-buttons clearfix">
                        <a href="#" class="btn vertical-button remove-border btn-info" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-dashboard opacity-80 font-size-20"></i>
                            </span>
                            Dashboard
                        </a>
                        <a href="#" class="btn vertical-button remove-border btn-danger" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-tags opacity-80 font-size-20"></i>
                            </span>
                            Widgets
                        </a>
                        <a href="#" class="btn vertical-button remove-border btn-purple" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-fire opacity-80 font-size-20"></i>
                            </span>
                            Tables
                        </a>
                        <a href="#" class="btn vertical-button remove-border btn-azure" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-bar-chart-o opacity-80 font-size-20"></i>
                            </span>
                            Charts
                        </a>
                        <a href="#" class="btn vertical-button remove-border btn-yellow" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-laptop opacity-80 font-size-20"></i>
                            </span>
                            Buttons
                        </a>
                        <a href="#" class="btn vertical-button remove-border btn-warning" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-code opacity-80 font-size-20"></i>
                            </span>
                            Panels
                        </a>
                    </div-->
                </div>
            </div>
        </div>
        <!--a class="header-btn" id="logout-btn" href="lockscreen-3.html" title="Lockscreen page example">
            <i class="glyph-icon icon-linecons-lock"></i>
        </a-->

    </div><!-- #header-nav-right -->

		
 
 </div>
        <div id="page-sidebar">
    <div class="scroll-sidebar">
        
    
		    <ul id="sidebar-menu">
		    	
		    	<li class="header">
		    		<a href="{{ url($_SESSION['espaciotrabajo'].'/principal') }}" title="">
		                <i class="glyphicon glyphicon-home sombraicono iconoazul">&nbsp;</i>
		                <span>{{ trans('principal.inicio') }}</span>
		            </a>
		    	</li>
		    	<!--i class="glyphicon glyphicon-home sombraicono" style="color:#0094D9">&nbsp;</i><span>Home</span></li-->
		    	    
		        <li id="administracion" class="subtitulomenu">
		            <a href="javascript:;" title="">
		                <i class="glyphicon glyphicon-equalizer sombraicono iconoverde">&nbsp;</i>
		                <span>{{ trans('principal.admin') }}</span>
		            </a>
		            
		            <div class="sidebar-submenu">
		                <ul>
		             
		                	 @if ($permisos->conocepermisos('view_permiso') == true)
		                    	<li class="icoadministra"><a href="{{ url($espaciotrabajo.'/permisos')}}" title=""><span>{{ trans('principal.permi') }}</span></a></li>
		                     @endif		
		                     @if ($permisos->conocepermisos('view_rol') == true)  
		                    	<li class="icoadministra"><a href="{{ url($espaciotrabajo.'/roles')}}" title=""><span>{{ trans('principal.rol') }}</span></a></li>
		                     @endif			
		                     @if ($permisos->conocepermisos('view_user') == true)
		                    	<li class="icoadministra"><a href="{{ url($espaciotrabajo.'/usuarios') }}" title=""><span>{{ trans('principal.user') }}</span></a></li>
		                     @endif		
		                      @if ($permisos->conocepermisos('view_grupo') == true)
		                    	<li class="icoadministra"><a href="{{ url($espaciotrabajo.'/grupos') }}" title=""><span>{{ trans('principal.grup') }}</span></a></li>
		                     @endif		
		                </ul>
		            </div><!-- .sidebar-submenu -->
		        </li>
		        <script type="text/javascript">
		        	var ctlicoadmin = 0;
			        $(".icoadministra").each(function(){
			        	ctlicoadmin = ctlicoadmin + 1;					
					});
		        if (ctlicoadmin == 0)
		        	{
						$('#administracion').hide();
		        	}
		        </script>
		        <li id="configuracion" class="subtitulomenu">
			    	<a href="javascript:;" title="">
			        	<i class="glyphicon glyphicon-wrench sombraicono iconomorado">&nbsp;</i>
			            <span>{{ trans('principal.conf') }}</span>
			        </a>
		            <div class="sidebar-submenu">
			        	<ul>
			        		@if ($permisos->conocepermisos('view_indice') == true)
			            		<li class="icoconfigura"><a href="{{ url($espaciotrabajo.'/indices') }}" title=""><span>{{ trans('principal.ind') }}</span></a></li>
			            	@endif			
			            	@if ($permisos->conocepermisos('view_tpdoc') == true)	
			                	<li class="icoconfigura"><a href="{{ url($espaciotrabajo.'/tiposdocumentales') }}" title=""><span>{{ trans('principal.tpd') }}</span></a></li>
			                @endif			
			                @if ($permisos->conocepermisos('view_tabla') == true)	
			                	<li class="icoconfigura"><a href="{{ url($espaciotrabajo.'/tablas') }}" title=""><span>{{ trans('principal.tabl') }}</span></a></li>
			                @endif			                
			                @if ($permisos->conocepermisos('view_depen') == true)	
			                	<li class="icoconfigura"><a href="{{ url($espaciotrabajo.'/dependencias') }}" title=""><span>{{ trans('principal.depe') }}</span></a></li>
			                @endif			
			            </ul>
		            </div><!-- .sidebar-submenu -->
		        </li> 
		        <script type="text/javascript">
		        	var ctlicoconfigura = 0;
			        $(".icoconfigura").each(function(){
			        	ctlicoconfigura = ctlicoconfigura + 1;					
					});
		        if (ctlicoconfigura == 0)
		        	{
						$('#configuracion').hide();
		        	}
		        </script>
		        
		        
		        
		        <li id="sistemas" class="subtitulomenu">
			    	<a href="javascript:;" title="">
			        	<i class="glyphicon glyphicon-cog sombraicono iconoocre">&nbsp;</i>
			            <span>{{ trans('principal.siste') }}</span>
			        </a>
		        	<div class="sidebar-submenu">
		        	 	<ul>
		        	 		@if ($permisos->conocepermisos('view_logo') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/logos') }}" title=""><span>{{ trans('principal.logo') }}</span></a></li>
			            	@endif		
			            	@if ($permisos->conocepermisos('make_key_crypt') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/key_encrypt') }}" title=""><span>{{ trans('principal.encryp') }}</span></a></li>
			            	@endif	
			            	@if ($permisos->conocepermisos('make_work_space') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/makespace') }}" title=""><span>{{ trans('principal.espacio') }}</span></a></li>
			            	@endif		
			            	@if ($permisos->conocepermisos('view_info_sys') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/infoys') }}" title=""><span>{{ trans('principal.infosys') }}</span></a></li>
			            	@endif	
							@if ($permisos->conocepermisos('set_up_storage') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/setupbodega') }}" title=""><span>{{ trans('principal.msgconfstorage') }}</span></a></li>
			            	@endif	
			            	@if ($permisos->conocepermisos('set_up_load') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/setupload') }}" title=""><span>{{ trans('principal.msgconfload') }}</span></a></li>
			            	@endif	
			            	@if ($permisos->conocepermisos('set_up_error') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/setuperror') }}" title=""><span>{{ trans('principal.msgconferror') }}</span></a></li>
			            	@endif	
			            	@if ($permisos->conocepermisos('set_up_recovery') == true)
			            		<li  class="icosistema"><a href="{{ url($espaciotrabajo.'/setuprecovery') }}" title=""><span>{{ trans('principal.msgconfrecovery') }}</span></a></li>
			            	@endif	
			            	
			            	
			            		
			            </ul>        	 	
		        	</div><!-- .sidebar-submenu -->
		         </li> 	
		          <script type="text/javascript">
		        	var ctlicosistema = 0;
			        $(".icosistema").each(function(){
			        	ctlicosistema = ctlicosistema + 1;					
					});
			        if (ctlicosistema == 0)
			        	{
							$('#sistemas').hide();
			        	}
			        </script>
		         
		        	 
		    </ul><!-- #sidebar-menu -->
	
    </div>
</div>


		
	        <div id="page-content-wrapper">
	            <div id="page-content">
	                
	                <div class="container ancho100" >
                    	<div id="page-title">
						  	@yield('tituloPagina','Default')
						</div>				
							@yield('contenido','Default') 
                            @include('flash::message')
					</div>
				</div>
			</div>		



    <!-- WIDGETS -->

<script type="text/javascript" src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>

<!-- Bootstrap Dropdown -->

<!-- <script type="text/javascript" src="{{ asset('assets/widgets/dropdown/dropdown.js') }}"></script> -->

<!-- Bootstrap Tooltip -->

<!-- <script type="text/javascript" src="{{ asset('assets/widgets/tooltip/tooltip.js') }}"></script> -->

<!-- Bootstrap Popover -->

<!-- <script type="text/javascript" src="{{ asset('assets/widgets/popover/popover.js') }}"></script> -->

<!-- Bootstrap Progress Bar -->

<script type="text/javascript" src="{{ asset('assets/widgets/progressbar/progressbar.js') }}"></script>

<!-- Bootstrap Buttons -->

<!-- <script type="text/javascript" src="{{ asset('assets/widgets/button/button.js') }}"></script> -->

<!-- Bootstrap Collapse -->

<!-- <script type="text/javascript" src="{{ asset('assets/widgets/collapse/collapse.js') }}"></script> -->



<!-- Superclick -->

<script type="text/javascript" src="{{ asset('assets/widgets/superclick/superclick.js') }}"></script>

<!-- Input switch alternate -->

<script type="text/javascript" src="{{ asset('assets/widgets/input-switch/inputswitch-alt.js') }}"></script>

<!-- Slim scroll -->

<script type="text/javascript" src="{{ asset('assets/widgets/slimscroll/slimscroll.js') }}"></script>

<!-- Slidebars -->

<script type="text/javascript" src="{{ asset('assets/widgets/slidebars/slidebars.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/slidebars/slidebars-demo.js') }}"></script>

<!-- PieGage -->

<script type="text/javascript" src="{{ asset('assets/widgets/charts/piegage/piegage.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/charts/piegage/piegage-demo.js') }}"></script>

<!-- Screenfull -->

<script type="text/javascript" src="{{ asset('assets/widgets/screenfull/screenfull.js') }}"></script>

<!-- Content box -->

<script type="text/javascript" src="{{ asset('assets/widgets/content-box/contentbox.js') }}"></script>

<!-- Overlay -->

<script type="text/javascript" src="{{ asset('assets/widgets/overlay/overlay.js') }}"></script>

<!-- Widgets init for demo -->

<script type="text/javascript" src="{{ asset('assets/js-init/widgets-init.js') }}"></script>

<!-- Theme layout -->

<script type="text/javascript" src="{{ asset('assets/themes/admin/layout.js') }}"></script>

<!-- Theme switcher -->

<script type="text/javascript" src="{{ asset('assets/widgets/theme-switcher/themeswitcher.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/owlcarousel/owlcarousel.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/widgets/owlcarousel/owlcarousel-demo.js') }}"></script>


</div>

</body>
</html>

<script type="text/javascript">

		var workspace = '<?php echo $workspace; ?>';  // alert(workspace);

		function captura(valor,e){
				$('#bppal').attr('data-buscarlo',valor); 
				if(e.which == 13) { 
					var busca_secun =  $('#bppal').attr('data-buscarlo');
					var espaciotrabajo = '{{ $espaciotrabajo }}'; 
					if (busca_secun == ''){busca_secun='_;_';}   
					busca_secun = busca_secun.replace(/%/g, '_..._');
					var iradonde =  $('#bppal').attr('data-visor'); 
					var iracontroller =  $('#bppal').attr('data-controller');
					if (iradonde != '')
						{
							window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/'+iracontroller+'/'+busca_secun+'/'+iradonde;
						}
								
				}	
			}

		function buscarsec(){
			var busca_secun =  $('#bppal').attr('data-buscarlo'); 
			var espaciotrabajo = '{{ $espaciotrabajo }}'; 
			if (busca_secun == ''){busca_secun='_;_';}   
			busca_secun = busca_secun.replace(/%/g, '_..._');
			var iradonde =  $('#bppal').attr('data-visor'); 
			var iracontroller =  $('#bppal').attr('data-controller');
			if (iradonde != '')
				{
					window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/'+iracontroller+'/'+busca_secun+'/'+iradonde;
				}	
			
	    }	
	    
		$(".visor").click(function() {  

			var espaciotrabajo = '<?php echo $_SESSION['espaciotrabajo'] ?>';
			
			var buscar =  '_;_';
			
			buscar = buscar.replace(/%/g, '_..._');
			
			var id_documento = $(this).attr('id').split('_');
			
			window.location.href = '{{ $ruta }}/'+espaciotrabajo+'/expedientes/'+id_documento[1]+'/'+buscar+'/visor_listado';	
			
		});
    	
</script>