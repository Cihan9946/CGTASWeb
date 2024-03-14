<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterPage extends Model
{
    use HasFactory;

    protected $table = 'footer_pages';
    protected $guarded = [
        'id'
    ];



    function getMenu(){
        return $this -> belongsTo(FooterMenu::class, 'menu_id','id');
    }

    function getSubMenu(){
        return $this -> belongsTo(FooterSubMenu::class, 'submenu_id', 'id');
    }
}
