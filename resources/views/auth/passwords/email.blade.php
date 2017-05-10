@extends('admin.template.email')
 
@section('titulo')
 {{ trans('principal.etirecopera') }}
@endsection

<!-- Main Content -->
@section('email')
<link rel="shortcut icon" href="{{{ asset('img/icopowerfile.png') }}}">
<div class="container" style="display:block !important">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('principal.etirecopera') }}</div>
                <div class="panel-body">
                
                	 @if ($message = Session::get('mensaje'))
							<div class="alert alert-success">
						        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						         
						        {!! $message !!}
						        
						        {!! Session::forget('mensaje') !!}
						    </div>
				    @endif	
                   

					{!! Form::open(['route'=>'usuarios.recuperar','method'=>'POST','class'=>'form-horizontal bordered-row']) !!}
                    <!--form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}"-->
                        {{ csrf_field() }}

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="login" class="col-md-4 control-label">Login</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required>

                                @if ($message = Session::get('mensalogin'))
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<i class="glyphicon glyphicon-exclamation-sign iconomensajeerror sombraicono"></i> 
											{!! $message !!}
											 
											{!! Session::forget('mensalogin') !!}
									</div>
								@endif
                            </div>
                        </div>
						
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{ trans('principal.inputdir') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($message = Session::get('mensaemail'))
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<i class="glyphicon glyphicon-exclamation-sign iconomensajeerror sombraicono"></i> 
											{!! $message !!}
											 
											{!! Session::forget('mensaemail') !!}
									</div>
								@endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('principal.btnenvemail') }} 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$('div.alert').delay(5000).slideUp(300);
</script>
@endsection