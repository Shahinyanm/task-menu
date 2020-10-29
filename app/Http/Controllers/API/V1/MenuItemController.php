<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Menu\MenuItemResource;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Support\Arr;

class MenuItemController extends Controller
{

    /**
     * Store
     *
     * @param  mixed $request
     * @return MenuItemResource
     */
    public function store(Request $request)
    {
        $data = $this->prepareParameters(
            $request->all()
        );

        unset($data['id']);
        $data['order'] = MenuItem::highestOrderMenuItem();

        return response(new MenuItemResource(MenuItem::create($data)))
    }

    /**
     * Update
     *
     * @param  mixed $request
     * @return status 204
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data = $this->prepareParameters(
            $request->except(['id'])
        );

        $menuItem = MenuItem::findOrFail($id);

        $menuItem->update($data);

        return response('', 204);
    }

    /**
     * Delete Menu Item By Id
     *
     * @param  mixed $id
     * @return status 204
     */
    public function delete($id)
    {
        $item = MenuItem::findOrFail($id);

        $item->destroy($id);

        return response('', 204);
    }

    /**
     * Order
     *
     * @param  mixed $request
     * @return status 204
     */
    public function order(Request $request)
    {
        $this->orderMenu($request->input('order'), null);

        return response('', 204);
    }

    /**
     * Order Menu
     *
     * @param  mixed $menuItems
     * @param  mixed $parentId
     * @return void
     */
    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }

    /**
     * prepareParameters
     *
     * @param  mixed $parameters
     * @return void
     */
    protected function prepareParameters($parameters)
    {
        switch (Arr::get($parameters, 'type')) {
            case 'route':
                $parameters['url'] = null;
                break;
            default:
                $parameters['route'] = null;
                $parameters['parameters'] = '';
                break;
        }

        if (isset($parameters['type'])) {
            unset($parameters['type']);
        }

        return $parameters;
    }
}
