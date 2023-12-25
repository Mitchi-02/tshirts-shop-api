<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   $temp = explode('~', $this->images);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price."€",
            //"tailles" => join(",", $this->sizes()->pluck('value')->toArray()),
            "tailles" => $this->sizes,
            "image1" => $temp[0],
            "image2" => $temp[1],
            "reviews" => ReviewResource::collection($this->reviews)
        ];
    }
}
