<?php $errorKey = str_replace( ']', '', str_replace( [ '][', '[' ], '.', $name ) ); ?>

<div class="form-group">
    @if( $label !== false )
        {{ Form::label( $label ?: $name, null ) }}
    @endif

    {{ Form::password( $name, array_merge( [ 'class' => $errors->has( $errorKey ) ? 'form-control is-invalid' : 'form-control' ], $attributes ) ) }}

    @if( $errors->has( $errorKey ) )
        <span class="invalid-feedback" role="alert">{{ $errors->first( $errorKey ) }}</span>
    @endif
</div>