<?php

namespace Phycon\Larmin\Utilities\Menu;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;

class Menu
{
    /**
     * @param string $type
     * @return MenuItem[]
     */
    public function getItems( $type = null )
    {
        $menuItems = [];

        if( $type )
        {
            $menuLinks = config( 'larmin.menu.' . $type, [] );
        }

        foreach( $menuLinks as $title => $options )
        {
            if( self::hasAccessToMenuItem( $options ) )
            {
                $menuItems[] = new MenuItem( [
                    'title' => __( $title ),
                    'url' => route( Arr::get( $options, 'route' ), Arr::get( $options, 'routeParameters', [] ) ),
                    'active' => self::isRouteActive( Route::is( Arr::get( $options, 'route' ) ), Arr::get( $options, 'routeParameters', [] ) )
                ] );
            }
        }

        return $menuItems;
    }

    /**
     * @param string $route
     * @param array $parameters
     * @return bool
     */
    private static function isRouteActive( $route, $parameters = [] )
    {
        $routeMatches = Route::is( $route );
        $parametersMatch = true;

        if( $parameters )
        {
            foreach( $parameters as $key => $value )
            {
                if( Route::input( $key ) != $value )
                {
                    $parametersMatch = false;
                }
            }
        }

        return $parametersMatch && $routeMatches;
    }

    /**
     * @param array $options
     * @return bool
     */
    private static function hasAccessToMenuItem( $options )
    {
        $user = Auth::user();

        if( !isset( $options['permission'] ) && !isset( $options['role'] ) && !isset( $options['ability'] ) )
        {
            return true;
        }

        if( isset( $options['permission'] ) && $user->can( $options['permission'] ) )
        {
            return true;
        }

        if( isset( $options['role'] ) && $user->hasRole( $options['role'] ) )
        {
            return true;
        }

        if( isset( $options['ability'] ) )
        {
            return $options['ability'];
        }

        return false;
    }
}