<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Menu\MenuCollection;
use App\Http\Resources\Menu\MenuResource;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Menu Collection
     *
     * @return MenuCollection
     */
    public function index() {
        return new MenuCollection(Menu::with(['items', 'parent_items' => function($q){
            $q->with('children');
        }])->get());
    }


    /**
     * Get Menu By Id
     *
     * @param  mixed $id
     * @return MenuResource
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu->load(['items', 'parent_items' => function($q){
            $q->with('children');
        }]));
    }

    /**
     * Store
     *
     * @param  mixed $request
     * @return MenuResource
     */
    public function store(Request $request) {
        $menu = Menu::create($request->all());

        return new MenuResource($menu->load(['items', 'parent_items' => function ($q) {
            $q->with('children');
        }]));
    }
}
