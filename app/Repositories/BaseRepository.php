<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Container\Container as Application;


abstract class BaseRepository 
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();


    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSortable();

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    

    

}
