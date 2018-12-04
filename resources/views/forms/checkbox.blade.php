<?php $errorKey = str_replace( ']', '', str_replace( [ '][', '[' ], '.', $name ) ); ?>

<div class="form-group">
    <div class="checkbox">
        <label>
            {{ Form::checkbox( $name, $value, old( $name, null ) ) }} {!! $label ?: $name !!}
        </label>
    </div>

    @if( $errors->has( $errorKey ) )
        <span class="invalid-feedback" role="alert">{{ $errors->first( $errorKey ) }}</span>
    @endif
</div>