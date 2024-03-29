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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    //TR

//EN
    public function appIndex(Request $request)
    {
        $locale = App::currentLocale();

        if (App::isLocale('tr')) {
            $menus = Menu::where('top_menu_id', $request->top_menu_id)->where('lang', 'TR')->get();
            $images = Slider::where('lang', 'TR')->get();
            $card1 = Card1::where('lang', 'TR')->get();
            $card2 = Card2::where('lang', 'TR')->get();
            $SabitSide =SabitSide::where('lang', 'TR')->get();
            $SabitIcon=SabitIcon::where('lang', 'TR')->get();
            $PageCard=PageCard::where('lang', 'TR')->get();
            $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->where('lang', 'TR')->get();
            $keyword = $request->input('keyword');
            if ($keyword) {
                $search = Menu::where('name', 'like', '%' . $keyword . '%')
                    ->where('lang', 'TR')
                    ->get();
            } else {
                $search = [];
            }
        }else if(App::isLocale("en")){
            $menus = Menu::where('top_menu_id', $request->top_menu_id)->where('lang', 'EN')->get();
            $images = Slider::where('lang', 'EN')->get();
            $card1 = Card1::where('lang', 'EN')->get();
            $card2 = Card2::where('lang', 'EN')->get();
            $SabitSide =SabitSide::where('lang', 'EN')->get();
            $SabitIcon=SabitIcon::where('lang', 'EN')->get();
            $PageCard=PageCard::where('lang', 'EN')->get();
            $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->where('lang', 'EN')->get();
            $keyword = $request->input('keyword');
            if ($keyword) {
                $search = Menu::where('name', 'like', '%' . $keyword . '%')
                    ->where('lang', 'EN')
                    ->get();
            } else {
                $search = [];
            }
        }
        return view('Index', compact('menus', 'footerMenus', 'images', 'card1', 'card2', 'SabitSide', 'SabitIcon', 'PageCard', 'search'));

    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";

            // Check if search term is empty and return empty response
            if (empty($request->search)) {
                return Response('');
            }

            $products = Menu::where('name', 'LIKE', '%' . $request->search . "%")->take(2)->get();

            foreach ($products as $key => $product) {
                $link = $product->getPage ? route('pages', $product->getPage->id) : ""; // Check for page link

                $output .= '<tr>' .
                    '<td><a href="' . $link . '">' . $product->name . '</a></td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }



    //Menü ve alt menü sayfası getirmek için
    function pages($page_id,Request $request){
        $menus = Menu::where('top_menu_id', $request->top_menu_id)->get();
        $page = Page::where('id', $page_id)->first();
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $keyword = $request->input('keyword');
        if ($keyword) {
            $search = Menu::where('name', 'like', '%' . $keyword . '%')->get();
        } else {
            $search = [];
        }

        return view('page', compact('page','menus','search','footerMenus'));
    }

    //Slider sayfası getirmek için yazıldı
    public function getPageBySlider(Request $request) {
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $link = $request->input('link');
        $page = Slider::where('link', $link)->first();
        $PageCard=PageCard::get();
        return view('page', compact('page','PageCard','footerMenus'));
    }

    //Card1 sayfası getirmek için yazıldı
    public function getPageByCard1(Request $request) {
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $link = $request->input('link');
        $page = Card1::where('link', $link)->first();

        return view('page', compact('page','footerMenus'));
    }

    //Card2 sayfası getirmek için yazıldı
    public function getPageByCard2(Request $request) {
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $link = $request->input('link');
        $page = Card2::where('link', $link)->first();

        return view('page', compact('page','footerMenus'));
    }

    //SabitSide sayfası getirmek için yazıldı
    public function getPageBySabitSide(Request $request) {
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $link = $request->input('link');
        $page = SabitSide::where('link', $link)->first();

        return view('page', compact('page','footerMenus'));
    }

    //SabitIcon getirmek için yazıldı
    public function getPageBySabitIcon(Request $request) {
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $link = $request->input('maintitle');
        $page = SabitIcon::where('maintitle', $link)->first();

        return view('page', compact('page','footerMenus'));
    }

    //PageCard sayfası getirmek için yazıldı
    public function getPageByPageCard(Request $request) {
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $link = $request->input('link');
        $page = PageCard::where('link', $link)->first();

        return view('page', compact('page','footerMenus'));
    }

    //Footer sayfası getirmek için
    function pagefooter($page_id,Request $request){
        $footerMenus=FooterMenu::where('top_menu_id', $request->top_menu_id)->get();

        $menus = FooterMenu::where('top_menu_id', $request->top_menu_id)->get();
        $page = FooterPage::where('id', $page_id)->first();

        return view('page', compact('page','menus','footerMenus'));
    }
}
