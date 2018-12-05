<div class="card gallery">
    <div class="card-header">
        {{ $label ?: $name }}
    </div>
    <div class="card-body">
        <div class="row">
            @if( Form::getModel() && count( Form::getModel()->{$name} ) )
                @foreach( Form::getModel()->gallery( $name ) as $image )
                    <div class="card gallery-image col-sm-6 col-md-4 col-lg-3">
                        <img class="card-img-top" src="{{ $image }}">
                        <div class="card-body text-center">
                            @isset( $attributes['multiple'] )
                                <input type="hidden" name="existing_{{ $name }}[]" value="{{ $image }}">
                                <button class="btn btn-danger remove-image" type="button">{{ __( 'Remove' ) }}</button>
                            @else
                                <input type="hidden" name="existing_{{ $name }}" value="{{ $image }}">
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="card-footer text-muted">
        @isset( $attributes['multiple'] )
            {{ Form::bsFile( $name . '[]', null, $label, [ 'multiple' ] ) }}
        @else
            {{ Form::bsFile( $name, null, $label ) }}
        @endif
    </div>
</div>