<?php

namespace App\Http\Resources\Menu;

use App\Models\MenuItem;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (MenuItem $menuItem) {
            return (new MenuItemResource($menuItem));
        });

        return parent::toArray($request);
    }
}
