<?php
/**
 * Created by PhpStorm.
 * User: yves
 * Date: 28/09/17
 * Time: 21:20
 */

namespace deezer\Entity;


class Song
{
    protected $id;
    protected $song_ref;
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    

    /**
     * @return mixed
     */
    public function getSongRef()
    {
        return $this->song_ref;
    }

    /**
     * @param mixed $song_ref
     * @return Song
     */
    public function setSongRef($song_ref)
    {
        $this->song_ref = $song_ref;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Song
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }




}