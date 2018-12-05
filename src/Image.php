<?php

namespace Phycon\Larmin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Phycon\Larmin\Utilities\UploadedImage\UploadedImage;

trait Image
{
    /**
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute( $key, $value )
    {
        if( array_key_exists( $key, $this->imageFields ) )
        {
            $this->uploadImage( $key, $value );
        }
        else
        {
            parent::setAttribute( $key, $value );
        }
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call( $method, $parameters )
    {
        if( $method === 'image' )
        {
            return $this->imagePath( ...$parameters );
        }

        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        return $this->forwardCallTo($this->newQuery(), $method, $parameters);
    }

    /**
     * @param string $key
     * @param string|null $preset
     * @return string
     */
    protected function imagePath( $key, $preset = null )
    {
        if( $preset )
        {
            $path = $this->{$key};
            $pathInfo = pathinfo( $path );
            $presetFilePath = sprintf( '%s/%s_%s', $pathInfo['dirname'], $preset, $pathInfo['basename'] );

            return Storage::url( $presetFilePath );
        }

        return Storage::url( $this->{$key} );
    }

    /**
     * @param string $fieldName
     * @param UploadedFile|null $image
     */
    protected function uploadImage( $fieldName, $image )
    {
        $uploadedImage = ( new UploadedImage( $image, $fieldName, self::class, $this->imageFields[$fieldName] ) )->save();

        if( $uploadedImage->isSaved() )
        {
            parent::setAttribute( $fieldName, $uploadedImage->path() );
        }
        else
        {
            parent::setAttribute( $fieldName, null );
        }
    }
}