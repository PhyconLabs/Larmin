<?php $errorKey = str_replace( ']', '', str_replace( [ '][', '[' ], '.', $name ) ); ?>

@isset( $attributes['i18n'] )
    <div class="i18n-field">

        <ul class="nav nav-tabs switcher">
            @foreach( config( 'translatable.locales' ) as $key => $language )
                <li class="nav-item language">
                    <a class="nav-link <?= $key === 0 ? 'active' : '' ?>" data-toggle="tab" href="#<?= $name . '-' . $language ?>"><?= $language ?></a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach( config( 'translatable.locales' ) as $key => $language )
                <?php $languageErrorKey = sprintf( '%s.%s', $language, $errorKey ); ?>

                <div class="i18n-input tab-pane fade <?= $key === 0 ? 'active show' : '' ?>" id="<?= $name . '-' . $language ?>">
                    <div class="form-group">
                        @if( $label !== false )
                            {{ Form::label( $label ?: $name, null ) }}
                        @endif

                        {{ Form::text( sprintf( '%s[%s]', $language, $name ), old( $name, ( Form::getModel() && Form::getModel()->translate($language) ) ? Form::getModel()->translate($language)->{$name} : null ), array_merge( [ 'class' => $errors->has( $languageErrorKey ) ? 'form-control is-invalid' : 'form-control' ], $attributes ) ) }}

                        @if( $errors->has( $languageErrorKey ) )
                            <span class="invalid-feedback" role="alert">{{ $errors->first( $languageErrorKey ) }}</span>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

    </div>
@else
    <div class="form-group">
        @if( $label !== false )
            {{ Form::label( $label ?: $name, null ) }}
        @endif

        {{ Form::text( $name, old( $name, $value ), array_merge( [ 'class' => $errors->has( $errorKey ) ? 'form-control is-invalid' : 'form-control' ], $attributes ) ) }}

        @if( $errors->has( $errorKey ) )
            <span class="invalid-feedback" role="alert">{{ $errors->first( $errorKey ) }}</span>
        @endif
    </div>
@endif