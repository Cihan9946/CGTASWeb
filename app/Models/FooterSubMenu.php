<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSubMenu extends Model
{

    use HasFactory;

    protected $table = "footer_sub_menus";
    protected $guarded = [
        'id'
    ];


    function getMenu(){
        return $this -> belongsTo(FooterMenu::class, 'menu_id','id');
    }

    function getPage(){
        return $this -> hasOne(FooterPage::class, 'submenu_id', 'id');
    }
}
