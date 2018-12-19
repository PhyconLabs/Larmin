# Larmin

## Installation

Via Composer

``` bash
$ composer require phyconlabs/larmin
```

Publish vendor assets.
``` bash
$ php artisan vendor:publish --provider="Phycon\Larmin\LarminServiceProvider"
```

Add service providers to provider array in `config/app.php`.
```
Phycon\Larmin\LarminServiceProvider::class
```

Add facades to aliases array in `config/app.php`.
```
'Menu' => \Phycon\Larmin\Facades\Menu::class,
'Form' => \Collective\Html\FormFacade::class,
```

Add authorization routes in `routes/web.php`.
```
Route::get( 'login', 'Auth\LoginController@showLoginForm' )->name( 'login' );
Route::post( 'login', 'Auth\LoginController@login' );
Route::post( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );
```

Add the following code to app/Http/Controllers/Auth/LoginController.php
```
use Illuminate\Http\Request;
use Phycon\Larmin\Validator;
```
```
public function login( Request $request )
{
    $this->validateLogin( $request );

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if( $this->hasTooManyLoginAttempts( $request ) )
    {
        $this->fireLockoutEvent( $request );

        return $this->sendLockoutResponse( $request );
    }

    if( $this->attemptLogin( $request ) )
    {
        if( request()->get( 'validation' ) && request()->ajax() )
        {
            return Validator::successResponse();
        }

        return $this->sendLoginResponse( $request );
    }

    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts( $request );

    return $this->sendFailedLoginResponse( $request );
}
```

Add compilation of admin assets in `webpack.mix.js`
```
mix.js('resources/js/admin.js', 'public/js')
    .sass('resources/sass/admin.scss', 'public/css');
```

Install npm packages.
```
npm install bootstrap bootswatch @fortawesome/fontawesome-free jquery.scrollto tinymce popper.js jquery-ui-bundle
```