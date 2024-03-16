<?php

namespace App\Http\Controllers;


use App\Models\Card1;
use App\Models\Card2;
use App\Models\FooterMenu;
use App\Models\FooterPage;
use App\Models\Menu;

use App\Models\Page;
use App\Models\PageCard;
use App\Models\SabitIcon;
use App\Models\SabitSide;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function appIndex(Request $request)
    {
        $images = Slider::get();
        $card1 = Card1::get();
        $card2 = Card2::get();
        $SabitSide =SabitSide::get();
        $SabitIcon=SabitIcon::get();
        $menus = Menu::where('top_menu_id', $request->top_menu_id)->get();
        $PageCard=PageCard::get();
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();
        return view('Index', compact('menus','footerMenus','images','card1','card2','SabitSide','SabitIcon','PageCard'));
    }

    //Menü ve alt menü sayfası getirmek için
    function pages($page_id,Request $request){
        $menus = Menu::where('top_menu_id', $request->top_menu_id)->get();
        $page = Page::where('id', $page_id)->first();

        return view('page', compact('page','menus'));
    }

    //Slider sayfası getirmek için yazıldı
    public function getPageBySlider(Request $request) {

        $link = $request->input('link');
        $page = Slider::where('link', $link)->first();
        $PageCard=PageCard::get();
        return view('page', compact('page','PageCard'));
    }

    //Card1 sayfası getirmek için yazıldı
    public function getPageByCard1(Request $request) {

        $link = $request->input('link');
        $page = Card1::where('link', $link)->first();

        return view('page', compact('page'));
    }

    //Card2 sayfası getirmek için yazıldı
    public function getPageByCard2(Request $request) {

        $link = $request->input('link');
        $page = Card2::where('link', $link)->first();

        return view('page', compact('page'));
    }

    //SabitSide sayfası getirmek için yazıldı
    public function getPageBySabitSide(Request $request) {

        $link = $request->input('link');
        $page = SabitSide::where('link', $link)->first();

        return view('page', compact('page'));
    }

    //SabitIcon getirmek için yazıldı
    public function getPageBySabitIcon(Request $request) {

        $link = $request->input('maintitle');
        $page = SabitIcon::where('maintitle', $link)->first();

        return view('page', compact('page'));
    }

    //PageCard sayfası getirmek için yazıldı
    public function getPageByPageCard(Request $request) {

        $link = $request->input('link');
        $page = PageCard::where('link', $link)->first();

        return view('page', compact('page'));
    }

    //Footer sayfası getirmek için
    function pagefooter($page_id,Request $request){
        $menus = FooterMenu::where('top_menu_id', $request->top_menu_id)->get();
        $page = FooterPage::where('id', $page_id)->first();

        return view('page', compact('page','menus'));
    }
}
