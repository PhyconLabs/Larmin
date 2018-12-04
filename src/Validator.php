<?php

namespace Phycon\Larmin;

use Illuminate\Validation\ValidationException;

class Validator extends \Illuminate\Validation\Validator
{
    /**
     * Run the validator's rules against its data.
     *
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate()
    {
        if( $this->fails() )
        {
            throw new ValidationException( $this );
        }

        if( request()->get( 'validation' ) && request()->ajax() )
        {
            self::successResponse()->send();die();
        }

        $data = collect( $this->getData() );

        return $data->only( collect( $this->getRules() )->keys()->map( function ( $rule ) {
            return explode( '.', $rule )[0];
        } )->unique() )->toArray();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successResponse()
    {
        return response()->json( [ 'valid' => true ], 200 );
    }
}