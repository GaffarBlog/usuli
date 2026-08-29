<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteList extends Model
{
    protected $table = 'route_lists';

    protected $fillable = ['name', 'route', 'parent_id'];

    // public function parent()
    // {
    //     return $this->belongsTo(RouteList::class, 'parent_id');
    // }

    public function Childrens()
    {
        return $this->hasMany(RouteList::class, 'parent_id')->select('id', 'name', 'route', 'parent_id');
    }
}
