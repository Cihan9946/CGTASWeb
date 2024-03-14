<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = "submenus";
    protected $guarded = [
        'id'
    ];


    function getMenu(){
        return $this -> belongsTo(Menu::class, 'menu_id','id');
    }

    function getPage(){
        return $this -> hasOne(Page::class, 'submenu_id', 'id');
    }
}
