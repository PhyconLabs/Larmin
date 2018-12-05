<?php

namespace Phycon\Larmin\Utilities\UploadedImage;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image as Imagick;

class UploadedImage
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var UploadedFile
     */
    protected $image;

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var array
     */
    protected $presets = [];

    /**
     * @var bool
     */
    protected $saved = false;

    /**
     * Image constructor.
     * @param UploadedFile $image
     * @param string $model
     * @param array $presets
     */
    public function __construct( $image, $fieldName, $model, $presets )
    {
        $this->image = $image;
        $this->model = $model;
        $this->presets = $presets;
        $this->fieldName = $fieldName;
    }

    /**
     * @return UploadedImage
     */
    public function save()
    {
        try
        {
            $fileName = $this->generateFileName();
            $modelPath = $this->modelPath();

            $this->path = $this->image->storeAs( $modelPath, $fileName );

            foreach( $this->presets as $presetName => $presetOptions )
            {
                $width = $presetOptions[0];
                $height = $presetOptions[1];

                $canvas = Imagick::canvas( $width, $height );

                if( $width >= $height )
                {
                    $resizedImage = Imagick::make( $this->image->getRealPath() )
                        ->resize( $width, null, function ( $constraint ) {
                            $constraint->aspectRatio();
                        } )
                        ->encode( $this->image->extension() );
                }
                else
                {
                    $resizedImage = Imagick::make( $this->image->getRealPath() )
                        ->resize( null, $height, function ( $constraint ) {
                            $constraint->aspectRatio();
                        } )
                        ->encode( $this->image->extension() );
                }

                $canvas->insert( $resizedImage, 'center' )->encode( $this->image->extension() );

                Storage::put( $modelPath . '/' . $presetName . '_' . $fileName, $canvas->__toString() );
            }
        }
        catch( FileException $exception )
        {
            return $this;
        }

        $this->saved = true;

        return $this;
    }

    /**
     * @return string
     */
    protected function modelPath()
    {
        return sprintf( 'public/%s', class_basename( $this->model ) );
    }

    /**
     * @return string
     */
    protected function generateFileName()
    {
        return sprintf( '%s_%s.%s', $this->fieldName, md5( file_get_contents( $this->image->getRealPath() ) ), $this->image->getClientOriginalExtension() );
    }

    /**
     * @return null|string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isSaved()
    {
        return $this->saved;
    }
}