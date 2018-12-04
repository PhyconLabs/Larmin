<?php $errorKey = str_replace( ']', '', str_replace( [ '][', '[' ], '.', $name ) ); ?>

<div class="form-group">
    @if( $label !== false )
        {{ Form::label( $label ?: $name, null, [ 'class' => 'control-label' ] ) }}
    @endif

    {{ Form::select( $name, $options, $value, array_merge( [ 'class' => $errors->has( $errorKey ) ? 'form-control is-invalid' : 'form-control' ], $attributes ) ) }}

    @if( $errors->has( $errorKey ) )
        <span class="invalid-feedback" role="alert">{{ $errors->first( $errorKey ) }}</span>
    @endif
</div>