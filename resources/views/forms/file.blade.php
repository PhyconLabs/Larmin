<?php $errorKey = str_replace( ']', '', str_replace( [ '][', '[' ], '.', $name ) ); ?>

<div class="form-group">
    @if( $label !== false )
        {{ Form::label( $label ?: $name, null ) }}
    @endif

    <div class="custom-file form-group">

        {{ Form::file( $name, array_merge( [ 'class' => $errors->has( $errorKey ) ? 'custom-file-input form-control is-invalid' : 'custom-file-input form-control', 'id' => $name . '-image' ], $attributes ) ) }}

        <label class="custom-file-label" for="{{ $name . '-image' }}">Choose file</label>

    </div>

    @if( $errors->has( $errorKey ) )
        <span class="invalid-feedback" role="alert">{{ $errors->first( $errorKey ) }}</span>
    @endif
</div>
