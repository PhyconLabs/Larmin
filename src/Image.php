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
        if( isset( $this->imageFields ) && array_key_exists( $key, $this->imageFields ) )
        {
            $this->uploadImage( $key, $value );
        }
        elseif( isset( $this->imageGalleryFields ) && array_key_exists( $key, $this->imageGalleryFields ) )
        {
            $this->uploadImageGallery( $key, $value );
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

        if( $method === 'gallery' )
        {
            return $this->galleryImagePaths( ...$parameters );
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
        if( filter_var( $this->attributes[$key], FILTER_VALIDATE_URL ) )
        {
            return $this->attributes[$key];
        }

        if( $preset )
        {
            $path = $this->attributes[$key];
            $pathInfo = pathinfo( $path );
            $presetFilePath = sprintf( '%s/%s_%s', $pathInfo['dirname'], $preset, $pathInfo['basename'] );

            return Storage::url( $presetFilePath );
        }

        return Storage::url( $this->attributes[$key] );
    }

    /**
     * @param string $key
     * @param string|null $preset
     * @return array
     */
    protected function galleryImagePaths( $key, $preset = null )
    {
        $images = unserialize( $this->attributes[$key] );

        if( !$images )
        {
            return [];
        }

        foreach( $images as &$image )
        {
            if( filter_var( $image, FILTER_VALIDATE_URL ) )
            {
                continue;
            }

            if( $preset )
            {
                $pathInfo = pathinfo( $image );
                $presetFilePath = sprintf( '%s/%s_%s', $pathInfo['dirname'], $preset, $pathInfo['basename'] );

                $image = Storage::url( $presetFilePath );
            }
            else
            {
                $image = Storage::url( $image );
            }
        }

        return $images;
    }

    /**
     * @param string $fieldName
     * @param UploadedFile $image
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

    /**
     * @param string $fieldName
     * @param UploadedFile[] $images
     */
    protected function uploadImageGallery( $fieldName, $images )
    {
        $request = request();
        $existingImages = $request->get( 'existing_' . $fieldName, [] );

        foreach( $images as $image )
        {
            $uploadedImage = ( new UploadedImage( $image, $fieldName, self::class, $this->imageGalleryFields[$fieldName] ) )->save();

            if( $uploadedImage->isSaved() )
            {
                $existingImages[] = $uploadedImage->path();
            }
        }

        parent::setAttribute( $fieldName, serialize( $existingImages ) );
    }
}