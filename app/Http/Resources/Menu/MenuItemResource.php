<?php

namespace App\Http\Resources\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link(),
            'target' => $this->target,
            'parent_id' => $this->parent_id,
            'menu_id' => $this->menu_id,
            'children' => new MenuItemCollection($this->whenLoaded('children'))
        ];
    }
}
