@extends('layouts.auth')

@section('content')

    {!! Form::open( [ 'route' => 'login', 'class' => 'validatable' ] ) !!}

        {{ Form::bsText( 'email', __( 'E-mail' ), null, [ 'placeholder' => __( 'E-mail' ), 'autofocus' ] ) }}

        {{ Form::bsPassword( 'password', __( 'Password' ), [ 'placeholder' => __( 'Password' ) ] ) }}

        <div class="text-center mb-3">
            {{ Form::bsCheckbox( 'remember', __('Remember Me') ) }}
        </div>

        <div class="form-group mb-3 text-center">
            {{ Form::bsSubmit( __('Login') ) }}
        </div>

    {!! Form::close() !!}

@endsection
