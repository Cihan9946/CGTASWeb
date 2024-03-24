<?php

namespace App\Http\Controllers;

use App\Models\Card1;
use App\Models\Card2;
use App\Models\Country;
use App\Models\FooterMenu;
use App\Models\FooterPage;
use App\Models\FooterSubMenu;
use App\Models\Menu;

use App\Models\Page;

use App\Models\PageCard;
use App\Models\SabitIcon;
use App\Models\SabitSide;
use App\Models\Slider;
use App\Models\SubMenu;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{

    //Menu-SubMenu Add-Update-Delete-Detail

    function menuIndex(){
        $menu = Menu::where('user_id', Auth::id())->get();
        $countries = Country::all();
        return view('admin.menu.menuCreate',compact('menu','countries'));
    }
    public function create_menu(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'top_menu_id' => 'nullable|exists:menus,id',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması
        ]);

        if ($request->top_menu_id){
            $top_menu = Menu::where('id', $request->top_menu_id)->where('user_id', Auth::id())->first();

            if (!$top_menu){
                abort(401);
            }
        }

        $menu = Menu::create([
            'top_menu_id' => $request->top_menu_id,
            'name' => $request->name,
            'lang' => $request->language_code, // Dil kodunu kaydet
            'user_id' => Auth::id()
        ]);

        return response() -> json(['data' => $menu]);
    }

    function menuDetail($id){
        $menu = Menu::where('user_id', Auth::id())->where('id',$id)->first();
        $submenu = SubMenu::where('menu_id', $menu -> id) -> first();
        return view('admin.menu.menuDetail', compact('menu','submenu'));
    }

    function pageMenuDetail($id){
        $menu = Menu::where('user_id', Auth::id())->where('id',$id)->first();
        return view('admin.menu.menuPage', compact('menu'));
    }

    function subMenuDetail($id){
        $submenu = SubMenu::where('id',$id)->whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        })->first();
        return view('admin.menu.submenuDetail', compact('submenu'));
    }



    function subMenuCreate(Request $request){

        $menu = Menu::where('id', $request->menu)->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $submenu = new SubMenu();
        $submenu -> menu_id = $request -> menu;
        $submenu -> name = $request -> name;

        $submenu -> save();

        return 'true';
    }

    function pageSubMenuCreate(Request $request){

        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $menu = Menu::whereHas('getSubMenu', function ($q) use ($request){
            $q->where('id', $request->submenu);
        })->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $page = new Page();
        $page -> submenu_id = $request -> submenu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;



        $page -> save();

        return response() -> json(['success' => true]);
    }

    function pageMenuCreate(Request $request){
        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $menu = Menu::where('id', $request->menu)->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $page = new Page();
        $page -> menu_id = $request -> menu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;

        $page -> save();

        return response() -> json(['success' => true]);
    }

    function fetchMenu(){
        $menu = Menu::where('user_id', Auth::id());

        return DataTables::of($menu)

            ->addColumn('name', function ($data){
                return $data -> name;
            })
            ->addColumn('detail', function ($data){
                if ($data -> getSubMenu -> count() > 0){
                    return '<a class="btn btn-primary" href="'. route('menuDetail', $data -> id) .'">Detay</a>'.
                        '<button class="btn btn-warning" onclick="openMenuUpdate('.$data -> id.')">Güncelle</button>'.
                        '<button class="btn btn-danger" onclick="delete_m('.$data -> id.')">Sil</button>';
                }
                else{
                    return '<a class="btn btn-primary" href="'. route('pageMenuDetail', $data -> id) .'">Detay</a>'.
                        '<button class="btn btn-warning" onclick="openMenuUpdate('.$data -> id.')">Güncelle</button>'.
                        '<button class="btn btn-danger" onclick="delete_m('.$data -> id.')">Sil</button>';
                }


            })
            ->addColumn('top_menu', function ($data){
                if ($data->getTopmenu){
                    return $data->getTopmenu->name;
                }else{
                    return '';
                }

            })
            ->rawColumns(['detail'])
            ->make();
    }

    function getMenu(Request $request){
        $menu = Menu::where('id', $request -> id)->where('user_id', Auth::id())->first();

        return response($menu);
    }

    function updateMenu(Request $request){
        $menu = Menu::where('id',$request -> id)->where('user_id', Auth::id())->first();

        $request -> validate([
            'name' => 'required'
        ]);

        $menu -> name = $request -> name;

        $menu -> save();

        return response() -> json(['succes' => true]);

    }

    function fetchSubMenu($id){
        $submenu = SubMenu::where('menu_id', $id)->whereHas('getMenu', function ($q){
            $q->where('user_id',Auth::id());
        })->get();

        return DataTables::of($submenu)

            ->addColumn('name', function ($data){
                return $data -> name;
            })
            ->addColumn('detail', function ($data){
                return '<a class="btn btn-primary" href="'. route('submenuDetail', $data -> id) .'">Detay</a>'.
                    '<button class="btn btn-warning" onclick="openSubMenuUpdate('.$data -> id.')">Güncelle</button>'.
                    '<button class="btn btn-danger" onclick="delete_sm('.$data -> id.')">Sil</button>';
            })
            ->rawColumns(['detail'])
            ->make();
    }

    function getSubMenu(Request $request){
        $submenu = SubMenu::where('id', $request->id)->whereHas('getMenu', function ($q){
            $q->where('user_id',Auth::id());
        })->first();

        return response($submenu);
    }

    function updateSubMenu(Request $request){
        $submenu = SubMenu::where('id', $request->id)->whereHas('getMenu', function ($q){
            $q->where('user_id',Auth::id());
        })->first();

        $submenu -> menu_id = $request -> menu_id;
        $submenu -> name = $request -> name;


        $submenu -> save();

        return response() ->json(['success', true]);
    }

    function fetchPageMenu($id){
        $pageMenu = Page::where('menu_id', $id) -> whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        }) -> get();

        return DataTables::of($pageMenu)

            ->addColumn('title', function ($data){
                return $data -> title;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-warning" onclick="openPageMenuUpdate('.$data -> id.')">Güncelle</button>'.
                    '<button class="btn btn-danger" onclick="delete_pm('.$data -> id.')">Sil</button>';
            })
            ->rawColumns(['detail'])
            ->make();
    }

    function getPageMenu(Request $request){
        $pageMenu = Page::where('id', $request->id) -> whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        })->orWhere('id', $request->id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();

        return response($pageMenu);
    }

    function updatePageMenu(Request $request){
        $page = Page::where('id', $request->id) -> whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        })->first();

        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $page -> menu_id = $request -> menu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;

        $page -> save();

        return response() -> json(['success' => true]);
    }

    function deletePageMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $pageMenu = Page::where('id', $request -> id)->whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        });
        $pageMenu -> delete();

        return response() -> json(['success',true]);
    }

    function fetchPageSubMenu($id){
        $pageSubMenu = Page::where('submenu_id', $id) -> whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        }) -> get();

        return DataTables::of($pageSubMenu)
            ->addColumn('title', function ($data){
                return $data -> title;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-warning" onclick="openPageSubMenuUpdate('.$data -> id.')">Güncelle</button>'.
                    '<button class="btn btn-danger" onclick="delete_smp('.$data -> id.')">Sil</button>';
            })
            ->rawColumns(['detail'])
            ->make();
    }

    function getPageSubMenu(Request $request){
        $page = Page::where('id', $request -> id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();

        return response($page);
    }

    function updatePageSubMenu(Request $request){
        $page = Page::where('id', $request -> id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();

        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $page -> submenu_id = $request -> submenu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;

        $page -> save();

        return response() -> json(['success' => true]);
    }

    function deletePageSubMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $pageSubMenu = Page::where('id', $request -> id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();
        $pageSubMenu -> delete();

        return response() -> json(['success',true]);
    }

    function deleteMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $menu = Menu::where('id',$request -> id)->where('user_id', Auth::id())->first();
        $menu -> delete();

        return response() -> json(['success' => true]);
    }

    /*function deleteSubMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $submenu = SubMenu::where('id', $request -> id)->whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        });
        $submenu -> delete();

        return response() -> json(['success' => true]);
    }*/


//Slider Add-Delete
//Slider Add-Delete
    function sliderIndex(){
        $slider = Slider::where('user_id', Auth::id())->get();
        $countries = Country::all();
        return view('admin.slider.slider', compact('slider','countries'));
    }

    function createSlider(Request $request){
        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg,svg',
            'maintitle' => 'required|string',
            'maindescription' => 'required|string',
            'link' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması
        ]);

        $slider = new Slider();
        $slider->maintitle = $request->maintitle;
        $slider->maindescription = $request->maindescription;
        $slider->link = $request->link;
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->lang = $request->language_code;
        if ($file = $request->file('img')){
            $name = $file->getClientOriginalName();
            $file->move('slider/', $name);
            $slider->img = $name;
        }

        $slider->user_id = Auth::id();
        $slider->save();

        return response()->json(['success' => true]);
    }

    function fetchSlider(){
        $slider = Slider::where('user_id', Auth::id());

        return DataTables::of($slider)
            ->addColumn('img', function ($data){
                return $data->img;
            })
            ->addColumn('imgDetail', function ($data){
                $url = asset('/slider/'.$data->img);
                return '<img src='.$url.' border="0" width="120" align="center" onclick="openImg(this)" />';
            })
            ->addColumn('maintitle', function ($data){
                return $data->maintitle;
            })
            ->addColumn('maindescription', function ($data){
                return $data->maindescription;
            })
            ->addColumn('link', function ($data){
                return $data->link;
            })
            ->addColumn('title', function ($data){
                return $data->link;
            })
            ->addColumn('description', function ($data){
                return $data->link;
            })
            ->addColumn('lang', function ($data){
                return $data->lang;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-danger" onclick="delete_slider('.$data->id.')">Sil</button>';
            })
            ->rawColumns(['detail','imgDetail'])
            ->make();
    }

    function deleteSlider(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $slider = Slider::where('id', $request->id)->where('user_id', Auth::id());
        $slider->delete();

        return response()->json(['success' => true]);
    }






//Card1 için fonksiyonlar
//Card1 Add-Delete
    function Card1Index(){
        $card1 = Card1::where('user_id', Auth::id())->get();
        $countries = Country::all();
        return view('admin.card1.card1', compact('card1','countries'));
    }

    function createCard1(Request $request){
        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg,svg',
            'maintitle' => 'required|string',
            'maindescription' => 'required|string',
            'link' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması
        ]);

        $card1 = new Card1();
        $card1->maintitle = $request->maintitle;
        $card1->maindescription = $request->maindescription;
        $card1->link = $request->link;
        $card1->title = $request->title;
        $card1->description = $request->description;
        $card1->lang = $request->language_code;
        if ($file = $request->file('img')){
            $name = $file->getClientOriginalName();
            $file->move('card1/', $name);
            $card1->img = $name;
        }

        $card1->user_id = Auth::id();
        $card1->save();

        return response()->json(['success' => true]);
    }

    function fetchCard1(){
        $card1 = Card1::where('user_id', Auth::id());

        return DataTables::of($card1)
            ->addColumn('img', function ($data){
                return $data->img;
            })
            ->addColumn('imgDetail', function ($data){
                $url = asset('/card1/'.$data->img);
                return '<img src='.$url.' border="0" width="120" align="center" onclick="openImg(this)" />';
            })
            ->addColumn('maintitle', function ($data){
                return $data->maintitle;
            })
            ->addColumn('maindescription', function ($data){
                return $data->maindescription;
            })
            ->addColumn('link', function ($data){
                return $data->link;
            })
            ->addColumn('title', function ($data){
                return $data->link;
            })
            ->addColumn('description', function ($data){
                return $data->link;
            })
            ->addColumn('lang', function ($data){
                return $data->lang;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-danger" onclick="delete_slider('.$data->id.')">Sil</button>';
            })
            ->rawColumns(['detail','imgDetail'])
            ->make();
    }

    function deleteCard1(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $card1 = Card1::where('id', $request->id)->where('user_id', Auth::id());
        $card1->delete();

        return response()->json(['success' => true]);
    }

//Card2 için fonksiyonlar
//Card2 Add-Delete
    function Card2Index(){
        $card2 = Card2::where('user_id', Auth::id())->get();
        $countries = Country::all();
        return view('admin.card2.card2', compact('card2','countries'));
    }

    function createCard2(Request $request){
        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg,svg',
            'maintitle' => 'required|string',
            'maindescription' => 'required|string',
            'link' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması

        ]);

        $card2 = new Card2();
        $card2->maintitle = $request->maintitle;
        $card2->maindescription = $request->maindescription;
        $card2->link = $request->link;
        $card2->title = $request->title;
        $card2->description = $request->description;
        $card2->lang = $request->language_code;


        if ($file = $request->file('img')){
            $name = $file->getClientOriginalName();
            $file->move('card2/', $name);
            $card2->img = $name;
        }

        $card2->user_id = Auth::id();
        $card2->save();

        return response()->json(['success' => true]);
    }

    function fetchCard2(){
        $card2 = Card2::where('user_id', Auth::id());

        return DataTables::of($card2)
            ->addColumn('img', function ($data){
                return $data->img;
            })
            ->addColumn('imgDetail', function ($data){
                $url = asset('/card2/'.$data->img);
                return '<img src='.$url.' border="0" width="120" align="center" onclick="openImg(this)" />';
            })
            ->addColumn('maintitle', function ($data){
                return $data->maintitle;
            })
            ->addColumn('maindescription', function ($data){
                return $data->maindescription;
            })
            ->addColumn('link', function ($data){
                return $data->link;
            })
            ->addColumn('title', function ($data){
                return $data->link;
            })
            ->addColumn('description', function ($data){
                return $data->link;
            })
            ->addColumn('lang', function ($data){
                return $data->lang;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-danger" onclick="delete_slider('.$data->id.')">Sil</button>';
            })
            ->rawColumns(['detail','imgDetail'])
            ->make();
    }

    function deleteCard2(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $card2 = Card2::where('id', $request->id)->where('user_id', Auth::id());
        $card2->delete();

        return response()->json(['success' => true]);
    }

    //SabitSide alanı
    //SabitSide Add-Delete
    function SabitSideIndex(){
        $SabitSide = SabitSide::where('user_id', Auth::id())->get();
        $countries = Country::all();
        return view('admin.SabitSide.SabitSide', compact('SabitSide','countries'));
    }

    function createSabitSide(Request $request){
        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg,svg',
            'maintitle' => 'required|string',
            'maindescription' => 'required|string',
            'link' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması
        ]);

        $SabitSide = new SabitSide();
        $SabitSide->maintitle = $request->maintitle;
        $SabitSide->maindescription = $request->maindescription;
        $SabitSide->link = $request->link;
        $SabitSide->title = $request->title;
        $SabitSide->description = $request->description;
        $SabitSide->lang = $request->language_code;


        if ($file = $request->file('img')){
            $name = $file->getClientOriginalName();
            $file->move('SabitSide/', $name);
            $SabitSide->img = $name;
        }

        $SabitSide->user_id = Auth::id();
        $SabitSide->save();

        return response()->json(['success' => true]);
    }

    function fetchSabitSide(){
        $SabitSide = SabitSide::where('user_id', Auth::id());

        return DataTables::of($SabitSide)
            ->addColumn('img', function ($data){
                return $data->img;
            })
            ->addColumn('imgDetail', function ($data){
                $url = asset('/SabitSide/'.$data->img);
                return '<img src='.$url.' border="0" width="120" align="center" onclick="openImg(this)" />';
            })
            ->addColumn('maintitle', function ($data){
                return $data->maintitle;
            })
            ->addColumn('maindescription', function ($data){
                return $data->maindescription;
            })
            ->addColumn('link', function ($data){
                return $data->link;
            })
            ->addColumn('title', function ($data){
                return $data->link;
            })
            ->addColumn('description', function ($data){
                return $data->link;
            })
            ->addColumn('lang', function ($data){
                return $data->lang;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-danger" onclick="delete_slider('.$data->id.')">Sil</button>';
            })
            ->rawColumns(['detail','imgDetail'])
            ->make();
    }

    function deleteSabitSide(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $SabitSide = SabitSide::where('id', $request->id)->where('user_id', Auth::id());
        $SabitSide->delete();

        return response()->json(['success' => true]);
    }


    //SabitIcon alanı
    //SabitIcon Add-Delete
    function SabitIconIndex(){
        $SabitIcon = SabitIcon::where('user_id', Auth::id())->get();
        $countries = Country::all();

        return view('admin.SabitIcon.SabitIcon', compact('SabitIcon','countries'));
    }

    function createSabitIcon(Request $request){
        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg,svg',
            'maintitle' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması

        ]);

        $SabitIcon = new SabitIcon();
        $SabitIcon->maintitle = $request->maintitle;
        $SabitIcon->title = $request->title;
        $SabitIcon->description = $request->description;
        $SabitIcon->lang = $request->language_code;


        if ($file = $request->file('img')){
            $name = $file->getClientOriginalName();
            $file->move('SabitIcon/', $name);
            $SabitIcon->img = $name;
        }

        $SabitIcon->user_id = Auth::id();
        $SabitIcon->save();

        return response()->json(['success' => true]);
    }

    function fetchSabitIcon(){
        $SabitIcon = SabitIcon::where('user_id', Auth::id());

        return DataTables::of($SabitIcon)
            ->addColumn('img', function ($data){
                return $data->img;
            })
            ->addColumn('imgDetail', function ($data){
                $url = asset('/SabitIcon/'.$data->img);
                return '<img src='.$url.' border="0" width="120" align="center" onclick="openImg(this)" />';
            })
            ->addColumn('maintitle', function ($data){
                return $data->maintitle;
            })

            ->addColumn('title', function ($data){
                return $data->link;
            })
            ->addColumn('description', function ($data){
                return $data->link;
            })
            ->addColumn('lang', function ($data){
                return $data->lang;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-danger" onclick="delete_slider('.$data->id.')">Sil</button>';
            })
            ->rawColumns(['detail','imgDetail'])
            ->make();
    }

    function deleteSabitIcon(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $SabitIcon = SabitIcon::where('id', $request->id)->where('user_id', Auth::id());
        $SabitIcon->delete();

        return response()->json(['success' => true]);
    }


    //PageCard için fonksiyonlar
//PageCard Add-Delete
    function PageCard(){
        $PageCard = PageCard::where('user_id', Auth::id())->get();
        $countries = Country::all();

        return view('admin.PageCard.PageCard', compact('PageCard','countries'));
    }

    function createPageCard(Request $request){
        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg,svg',
            'maintitle' => 'required|string',
            'maindescription' => 'required|string',
            'link' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması

        ]);

        $PageCard = new PageCard();
        $PageCard->maintitle = $request->maintitle;
        $PageCard->maindescription = $request->maindescription;
        $PageCard->link = $request->link;
        $PageCard->title = $request->title;
        $PageCard->description = $request->description;
        $PageCard->lang = $request->language_code;


        if ($file = $request->file('img')){
            $name = $file->getClientOriginalName();
            $file->move('PageCard/', $name);
            $PageCard->img = $name;
        }

        $PageCard->user_id = Auth::id();
        $PageCard->save();

        return response()->json(['success' => true]);
    }

    function fetchPageCard(){
        $PageCard = PageCard::where('user_id', Auth::id());

        return DataTables::of($PageCard)
            ->addColumn('img', function ($data){
                return $data->img;
            })
            ->addColumn('imgDetail', function ($data){
                $url = asset('/card2/'.$data->img);
                return '<img src='.$url.' border="0" width="120" align="center" onclick="openImg(this)" />';
            })
            ->addColumn('maintitle', function ($data){
                return $data->maintitle;
            })
            ->addColumn('maindescription', function ($data){
                return $data->maindescription;
            })
            ->addColumn('link', function ($data){
                return $data->link;
            })
            ->addColumn('title', function ($data){
                return $data->link;
            })
            ->addColumn('description', function ($data){
                return $data->link;
            })
            ->addColumn('lang', function ($data){
                return $data->lang;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-danger" onclick="delete_slider('.$data->id.')">Sil</button>';
            })
            ->rawColumns(['detail','imgDetail'])
            ->make();
    }

    function deletePageCard(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $PageCard = PageCard::where('id', $request->id)->where('user_id', Auth::id());
        $PageCard->delete();

        return response()->json(['success' => true]);
    }

    // Member List

    function memberIndex(){
        return view('admin.users.users');
    }




    function delete_menu(Request $request){
        $request->validate([
            'menu_id' => 'required|exists:menus,id'
        ]);

        $menu = Menu::where('id', $request->menu_id)->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        if ($menu->delete()){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['errors' => ['Server error.']])->setStatusCode(500);
        }
    }

    function update_menu(Request $request){

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'name' => 'required|string|max:255'
        ]);

        $menu = Menu::where('id', $request->menu_id)->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $menu->name = $request->name;
        $menu->save();

        return response() -> json(['data' => $menu]);

    }



    public function titleIndex()
    {
        $title = Title::first();
        return view('admin.title.title', compact('title'));
    }

    public function createTitle(Request $request)
    {
        $request->validate([
            'description' => 'nullable',
        ]);

        $title = Title::first();
        $title->description = $request->description;
        $title->save();
        return redirect()->back();
    }

    public function fetchTitle()
    {
        $titles = Title::where('user_id', auth()->id())->get();

        return DataTables::of($titles)
            ->addColumn('description', function ($title) {
                return $title->description;
            })
            ->addColumn('detail', function ($title) {
                return '
                <button class="btn btn-warning" onclick="openTitleUpdate('.$title->id.')">Güncelle</button>
                <button class="btn btn-danger" onclick="delete_t('.$title->id.')">Sil</button>
            ';
            })
            ->rawColumns(['detail'])
            ->make(true);
    }

    public function getTitle(Request $request)
    {
        $title = Title::where('id', $request->input('id'))->where('user_id', auth()->id())->first();

        if ($title) {
            return response()->json($title);
        } else {
            return response()->json(['error' => 'Title not found'], 404);
        }
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $title = Title::where('id', $request->input('id'))->where('user_id', auth()->id())->first();

        if ($title) {
            $title->name = $request->input('name');
            $title->description = $request->input('description');
            $title->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Title not found'], 404);
        }
    }


    public function deleteTitle(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $title = Title::where('id', $request->input('id'))->where('user_id', auth()->id())->first();

        if ($title) {
            $title->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Title not found'], 404);
        }
    }



    //Footer menu için
    //Menu-SubMenu Add-Update-Delete-Detail

    function FootermenuIndex(){
        $menu = FooterMenu::where('user_id', Auth::id())->get();
        $countries = Country::all();

        return view('admin.footer.menuCreate',compact('menu','countries'));
    }

    function FootermenuDetail($id){
        $menu = FooterMenu::where('user_id', Auth::id())->where('id',$id)->first();
        $submenu = FooterSubMenu::where('menu_id', $menu -> id) -> first();
        return view('admin.footer.menuDetail', compact('menu','submenu'));
    }

    function FooterpageMenuDetail($id){
        $menu = FooterMenu::where('user_id', Auth::id())->where('id',$id)->first();
        return view('admin.footer.menuPage', compact('menu'));
    }

    function FootersubMenuDetail($id){
        $submenu = FooterSubMenu::where('id',$id)->whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        })->first();
        return view('admin.footer.submenuDetail', compact('submenu'));
    }



    function FootersubMenuCreate(Request $request){

        $menu = FooterMenu::where('id', $request->menu)->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $submenu = new FooterSubMenu();
        $submenu -> menu_id = $request -> menu;
        $submenu -> name = $request -> name;

        $submenu -> save();

        return 'true';
    }

    function FooterpageSubMenuCreate(Request $request){

        $request -> validate([
            'title' => 'required',
            'description' => 'required'

        ]);

        $menu = FooterMenu::whereHas('getSubMenu', function ($q) use ($request){
            $q->where('id', $request->submenu);
        })->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $page = new FooterPage();
        $page -> submenu_id = $request -> submenu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;


        $page -> save();

        return response() -> json(['success' => true]);
    }

    function FooterpageMenuCreate(Request $request){
        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $menu = FooterMenu::where('id', $request->menu)->where('user_id', Auth::id())->first();

        if (!$menu){
            abort(401);
        }

        $page = new FooterPage();
        $page -> menu_id = $request -> menu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;

        $page -> save();

        return response() -> json(['success' => true]);
    }

    function FooterfetchMenu(){
        $menu = FooterMenu::where('user_id', Auth::id());

        return DataTables::of($menu)

            ->addColumn('name', function ($data){
                return $data -> name;
            })
            ->addColumn('detail', function ($data){
                if ($data -> getSubMenu -> count() > 0){
                    return '<a class="btn btn-primary" href="'. route('FootermenuDetail', $data -> id) .'">Detay</a>'.
                        '<button class="btn btn-warning" onclick="openMenuUpdate('.$data -> id.')">Güncelle</button>'.
                        '<button class="btn btn-danger" onclick="delete_m('.$data -> id.')">Sil</button>';
                }
                else{
                    return '<a class="btn btn-primary" href="'. route('FooterpageMenuDetail', $data -> id) .'">Detay</a>'.
                        '<button class="btn btn-warning" onclick="openMenuUpdate('.$data -> id.')">Güncelle</button>'.
                        '<button class="btn btn-danger" onclick="delete_m('.$data -> id.')">Sil</button>';
                }


            })
            ->addColumn('top_menu', function ($data){
                if ($data->getTopmenu){
                    return $data->getTopmenu->name;
                }else{
                    return '';
                }

            })
            ->rawColumns(['detail'])
            ->make();
    }

    function FootergetMenu(Request $request){
        $menu = FooterMenu::where('id', $request -> id)->where('user_id', Auth::id())->first();

        return response($menu);
    }

    function FooterupdateMenu(Request $request){
        $menu = FooterMenu::where('id',$request -> id)->where('user_id', Auth::id())->first();

        $request -> validate([
            'name' => 'required'
        ]);

        $menu -> name = $request -> name;

        $menu -> save();

        return response() -> json(['succes' => true]);

    }

    function FooterfetchSubMenu($id){
        $submenu = FooterSubMenu::where('menu_id', $id)->whereHas('getMenu', function ($q){
            $q->where('user_id',Auth::id());
        })->get();

        return DataTables::of($submenu)

            ->addColumn('name', function ($data){
                return $data -> name;
            })
            ->addColumn('detail', function ($data){
                return '<a class="btn btn-primary" href="'. route('FootersubmenuDetail', $data -> id) .'">Detay</a>'.
                    '<button class="btn btn-warning" onclick="openSubMenuUpdate('.$data -> id.')">Güncelle</button>'.
                    '<button class="btn btn-danger" onclick="delete_sm('.$data -> id.')">Sil</button>';
            })
            ->rawColumns(['detail'])
            ->make();
    }

    function FootergetSubMenu(Request $request){
        $submenu = FooterSubMenu::where('id', $request->id)->whereHas('getMenu', function ($q){
            $q->where('user_id',Auth::id());
        })->first();

        return response($submenu);
    }

    function FooterupdateSubMenu(Request $request){
        $submenu = FooterSubMenu::where('id', $request->id)->whereHas('getMenu', function ($q){
            $q->where('user_id',Auth::id());
        })->first();

        $submenu -> menu_id = $request -> menu_id;
        $submenu -> name = $request -> name;


        $submenu -> save();

        return response() ->json(['success', true]);
    }

    function FooterfetchPageMenu($id){
        $pageMenu = FooterPage::where('menu_id', $id) -> whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        }) -> get();

        return DataTables::of($pageMenu)

            ->addColumn('title', function ($data){
                return $data -> title;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-warning" onclick="openPageMenuUpdate('.$data -> id.')">Güncelle</button>'.
                    '<button class="btn btn-danger" onclick="delete_pm('.$data -> id.')">Sil</button>';
            })
            ->rawColumns(['detail'])
            ->make();
    }

    function FootergetPageMenu(Request $request){
        $pageMenu = FooterPage::where('id', $request->id) -> whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        })->orWhere('id', $request->id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();

        return response($pageMenu);
    }

    function FooterupdatePageMenu(Request $request){
        $page = FooterPage::where('id', $request->id) -> whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        })->first();

        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $page -> menu_id = $request -> menu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;

        $page -> save();

        return response() -> json(['success' => true]);
    }

    function FooterdeletePageMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $pageMenu = FooterPage::where('id', $request -> id)->whereHas('getMenu', function ($q){
            $q->where('user_id', Auth::id());
        });
        $pageMenu -> delete();

        return response() -> json(['success',true]);
    }

    function FooterfetchPageSubMenu($id){
        $pageSubMenu = FooterPage::where('submenu_id', $id) -> whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        }) -> get();

        return DataTables::of($pageSubMenu)
            ->addColumn('title', function ($data){
                return $data -> title;
            })
            ->addColumn('detail', function ($data){
                return '<button class="btn btn-warning" onclick="openPageSubMenuUpdate('.$data -> id.')">Güncelle</button>'.
                    '<button class="btn btn-danger" onclick="delete_smp('.$data -> id.')">Sil</button>';
            })
            ->rawColumns(['detail'])
            ->make();
    }

    function FootergetPageSubMenu(Request $request){
        $page = FooterPage::where('id', $request -> id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();

        return response($page);
    }

    function FooterupdatePageSubMenu(Request $request){
        $page = FooterPage::where('id', $request -> id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();

        $request -> validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $page -> submenu_id = $request -> submenu;
        $page -> title = $request -> title;
        $page -> description = $request -> description;

        $page -> save();

        return response() -> json(['success' => true]);
    }

    function FooterdeletePageSubMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $pageSubMenu = FooterPage::where('id', $request -> id)->whereHas('getSubMenu', function ($q){
            $q->whereHas('getMenu', function ($q){
                $q->where('user_id', Auth::id());
            });
        })->first();
        $pageSubMenu -> delete();

        return response() -> json(['success',true]);
    }

    function FooterdeleteMenu(Request $request){
        $request -> validate([
            'id' => 'required'
        ]);

        $menu = FooterMenu::where('id',$request -> id)->where('user_id', Auth::id())->first();
        $menu -> delete();

        return response() -> json(['success' => true]);
    }
    function FootermenuCreate(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'top_menu_id' => 'nullable|exists:menus,id',
            'language_code' => 'required|exists:countries,code' // Dil kodu doğrulaması



        ]);
        if ($request->top_menu_id){
            $top_menu = FooterMenu::where('id', $request->top_menu_id)->where('user_id', Auth::id())->first();

            if (!$top_menu){
                abort(401);
            }
        }

        $menu = FooterMenu::create([
            'top_menu_id' => $request->top_menu_id,
            'name' => $request->name,
            'lang' => $request->language_code, // Dil kodunu kaydet
            'user_id' => Auth::id()
        ]);

        return response() -> json(['data' => $menu]);
    }

}
