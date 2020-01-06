<?php

namespace Phycon\Larmin\Utilities\Menu;

use Illuminate\Support\Arr;

class MenuItem
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $url;

    /**
     * @var bool
     */
    private $active = false;

    /**
     * MenuItem constructor.
     * @param array $data
     */
    public function __construct( $data )
    {
        $this->title = Arr::get( $data, 'title' );
        $this->url = Arr::get( $data, 'url' );
        $this->active = Arr::get( $data, 'active', false );
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}