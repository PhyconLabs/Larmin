<div class="card gallery">
    <div class="card-header">
        {{ $label ?: $name }}
    </div>
    <div class="card-body">
        <div class="row">
            @if( Form::getModel() )
                @isset( $attributes['multiple'] )
                    @foreach( Form::getModel()->gallery( $name ) as $image )
                        <div class="card gallery-image col-sm-6 col-md-4 col-lg-3">
                            <img class="card-img-top" src="{{ $image }}">
                            <div class="card-body text-center">
                                <input type="hidden" name="{{ $name }}[]" value="{{ $image }}">
                                <button class="btn btn-danger remove-image" type="button">{{ __( 'Remove' ) }}</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    @if( Form::getModel()->image( $name ) )
                        <div class="card gallery-image col-sm-6 col-md-4 col-lg-3">
                            <img class="card-img-top" src="{{ Form::getModel()->image( $name ) }}">
                            <div class="card-body text-center">
                                <input type="hidden" name="existing_{{ $name }}" value="{{ Form::getModel()->image( $name ) }}">
                            </div>
                        </div>
                    @endif
                @endif

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