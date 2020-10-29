<?php

namespace App\Http\Resources\Menu;

use App\Models\Menu;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Menu $menu) {
            return (new MenuResource($menu));
        });

        return parent::toArray($request);
    }
}
