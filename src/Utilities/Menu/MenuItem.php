<?php

namespace Phycon\Larmin\Utilities\Menu;


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
        $this->title = array_get( $data, 'title' );
        $this->url = array_get( $data, 'url' );
        $this->active = array_get( $data, 'active', false );
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}