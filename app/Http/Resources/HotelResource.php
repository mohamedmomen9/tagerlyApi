<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'vendor_name' => $this->vendor_name,
            'sales' => $this->sales,
            'price' => $this->price,
            'votes' => $this->votes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
