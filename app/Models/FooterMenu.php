<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    use HasFactory;

    protected $table = "footer_menus";

    protected $guarded = [
        'id'
    ];

    function getSubMenu(){
        return $this -> hasMany(FooterSubMenu::class, 'menu_id','id');
    }

    function getPage(){
        return $this -> hasOne(FooterPage::class, 'menu_id', 'id');
    }

    function getSubmenus(){
        return $this->hasMany(FooterMenu::class,'top_menu_id','id');
    }

    function getTopmenu(){
        return $this->belongsTo(FooterMenu::class,'top_menu_id', 'id');
    }}
