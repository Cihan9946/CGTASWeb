<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";

    protected $guarded = [
        'id'
    ];

    function getSubMenu(){
        return $this -> hasMany(SubMenu::class, 'menu_id','id');
    }

    function getPage(){
        return $this -> hasOne(Page::class, 'menu_id', 'id');
    }

    function getSubmenus(){
        return $this->hasMany(Menu::class,'top_menu_id','id');
    }

    function getTopmenu(){
        return $this->belongsTo(Menu::class,'top_menu_id', 'id');
    }
}
