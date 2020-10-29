<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\MenuItem;
/**
 * @todo: Refactor this class by using something like MenuBuilder Helper.
 */
class Menu extends Model
{
    protected $table = 'menus';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->removeMenuFromCache();
        });

        static::deleted(function ($model) {
            $model->removeMenuFromCache();
        });
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function parent_items()
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id');
    }

    public function removeMenuFromCache()
    {
        \Cache::forget('menu_'.$this->name);
    }
}
