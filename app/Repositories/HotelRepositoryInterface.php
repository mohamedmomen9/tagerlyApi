<?php
namespace App\Repositories;

use Illuminate\Support\Collection;

interface HotelRepositoryInterface
{
   public function all($search , $sort , $skip , $limit , $columns);
}