<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Admin Panel Login
Route::get('/logins', function () {
    return view('login');
})->name('login.get');

Route::post('/logins', [AuthController::class, 'login'])->name('login.post');

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => '/admin', 'middleware' => 'Admin'], function () {

    Route::get('/app', function () {
        return view('admin.app');
    })->name('admin.dashboard');

    //Menu-SubMenu Route

    Route::get('/menuCreate', [AdminController::class, 'menuIndex'])->name('menuIndex');
    Route::post('/menuCreate', [AdminController::class, 'create_menu'])->name('menuCreate');
    Route::post('/pageSubMenuCreate', [AdminController::class, 'pageSubMenuCreate'])->name('pageSubMenuCreate');
    Route::post('/pageMenuCreate', [AdminController::class, 'pageMenuCreate'])->name('pageMenuCreate');
    Route::get('/fetchMenu', [AdminController::class, 'fetchMenu'])->name('fetchMenu');
    Route::get('/page', [AdminController::class, 'page'])->name('page');
    Route::get('/getMenu', [AdminController::class, 'getMenu'])->name('getMenu');
    Route::post('/updateMenu', [AdminController::class, 'updateMenu'])->name('updateMenu');
    Route::get('/fetchSubMenu/{id}', [AdminController::class, 'fetchSubMenu'])->name('fetchSubMenu');
    Route::post('/getSubMenu', [AdminController::class, 'getSubMenu'])->name('getSubMenu');
    Route::post('/updateSubMenu', [AdminController::class, 'updateSubMenu'])->name('updateSubMenu');
    Route::get('/fetchPageMenu/{id}', [AdminController::class, 'fetchPageMenu'])->name('fetchPageMenu');
    Route::get('/getPageMenu', [AdminController::class, 'getPageMenu'])->name('getPageMenu');
    Route::post('/updatePageMenu', [AdminController::class, 'updatePageMenu'])->name('updatePageMenu');
    Route::post('/deletePageMenu', [AdminController::class, 'deletePageMenu'])->name('deletePageMenu');
    Route::get('/fetchPageSubMenu/{id}', [AdminController::class, 'fetchPageSubMenu'])->name('fetchPageSubMenu');
    Route::get('/getPageSubMenu', [AdminController::class, 'getPageSubMenu'])->name('getPageSubMenu');
    Route::post('/updatePageSubMenu', [AdminController::class, 'updatePageSubMenu'])->name('updatePageSubMenu');
    Route::post('/deletePageSubMenu', [AdminController::class, 'deletePageSubMenu'])->name('deletePageSubMenu');
    Route::get('/detailMenu/{id}', [AdminController::class, 'menuDetail'])->name('menuDetail');
    Route::get('/detailSubMenu/{id}', [AdminController::class, 'subMenuDetail'])->name('submenuDetail');
    Route::get('/detailPageMenu/{id}', [AdminController::class, 'pageMenuDetail'])->name('pageMenuDetail');
    Route::post('/deleteMenu', [AdminController::class, 'deleteMenu'])->name('deleteMenu');
    Route::post('/deleteSubMenu', [AdminController::class, 'deleteSubMenu'])->name('deleteSubMenu');

    Route::post('/submenuCreate', [AdminController::class, 'subMenuCreate'])->name('subMenuCreate');

    //Slider Route
    Route::get('/sliders', [AdminController::class, 'sliderIndex'])->name('sliderIndex');
    Route::post('/createSlider', [AdminController::class, 'createSlider'])->name('createSlider');
    Route::get('/fetchSlider', [AdminController::class, 'fetchSlider'])->name('fetchSlider');
    Route::post('deleteSlider', [AdminController::class, 'deleteSlider'])->name('deleteSlider');
;
    //Card1 Route
    Route::get('/Card1', [AdminController::class, 'Card1Index'])->name('Card1Index');
    Route::post('/createCard1', [AdminController::class, 'createCard1'])->name('createCard1');
    Route::get('/fetchCard1', [AdminController::class, 'fetchCard1'])->name('fetchCard1');
    Route::post('deleteCard1', [AdminController::class, 'deleteCard1'])->name('deleteCard1');

    //Card2 Route
    Route::get('/Card2', [AdminController::class, 'Card2Index'])->name('Card2Index');
    Route::post('/createCard2', [AdminController::class, 'createCard2'])->name('createCard2');
    Route::get('/fetchCard2', [AdminController::class, 'fetchCard2'])->name('fetchCard2');
    Route::post('deleteCard2', [AdminController::class, 'deleteCard2'])->name('deleteCard2');

    //SabitSide Route
    Route::get('/SabitSide', [AdminController::class, 'SabitSideIndex'])->name('SabitSideIndex');
    Route::post('/createSabitSide', [AdminController::class, 'createSabitSide'])->name('createSabitSide');
    Route::get('/fetchSabitSide', [AdminController::class, 'fetchSabitSide'])->name('fetchSabitSide');
    Route::post('deleteSabitSide', [AdminController::class, 'deleteSabitSide'])->name('deleteSabitSide');

    //SabitIcon Route
    Route::get('/SabitIcon', [AdminController::class, 'SabitIconIndex'])->name('SabitIconIndex');
    Route::post('/createSabitIcon', [AdminController::class, 'createSabitIcon'])->name('createSabitIcon');
    Route::get('/fetchSabitIcon', [AdminController::class, 'fetchSabitIcon'])->name('fetchSabitIcon');
    Route::post('deleteSabitIcon', [AdminController::class, 'deleteSabitIcon'])->name('deleteSabitIcon');

    //PageCard Route
    Route::get('/PageCard', [AdminController::class, 'PageCard'])->name('PageCardIndex');
    Route::post('/createPageCard', [AdminController::class, 'createPageCard'])->name('createPageCard');
    Route::get('/fetchPageCard', [AdminController::class, 'fetchPageCard'])->name('fetchPageCard');
    Route::post('deletePageCard', [AdminController::class, 'deletePageCard'])->name('deletePageCard');

    //Title Route

    Route::get('/titles', [AdminController::class, 'titleIndex'])->name('titleIndex');
    Route::post('/createTitle', [AdminController::class, 'createTitle'])->name('createTitle');
    Route::get('/fetchTitle', [AdminController::class, 'fetchTitle'])->name('fetchTitle');
    Route::get('/getTitle', [AdminController::class, 'getTitle'])->name('getTitle');
    Route::post('/updateTitle', [AdminController::class, 'updateTitle'])->name('updateTitle');
    Route::post('/deleteTitle', [AdminController::class, 'deleteTitle'])->name('deleteTitle');

    //Member Route

    Route::get('/members', [AdminController::class, 'memberIndex'])->name('memberIndex');

    //Payment Route

    Route::get('/payments', [AdminController::class, 'paymentIndex'])->name('paymentIndex');
    Route::post('/paymentCreate', [AdminController::class, 'paymentCreate'])->name('paymentCreate');
    Route::get('/paymentFetch', [AdminController::class, 'paymentFetch'])->name('paymentFetch');
    Route::post('/paymentDelete', [AdminController::class, 'paymentDelete'])->name('paymentDelete');
    Route::get('/paymentGet', [AdminController::class, 'paymentGet'])->name('paymentGet');
    Route::post('/paymentUpdate', [AdminController::class, 'paymentUpdate'])->name('paymentUpdate');


    //Offer Route

    Route::get('/offers', [AdminController::class, 'offerIndex'])->name('offerIndex');
    Route::post('/createOffer', [AdminController::class, 'createOffer'])->name('createOffer');
    Route::get('/fetchOffer', [AdminController::class, 'fetchOffer'])->name('fetchOffer');
    Route::post('/deleteOffer', [AdminController::class, 'deleteOffer'])->name('deleteOffer');
    Route::get('/getOffer', [AdminController::class, 'getOffer'])->name('getOffer');
    Route::post('/updateOffer', [AdminController::class, 'updateOffer'])->name('updateOffer');


    //Footer Menu-SubMenu Route

    Route::get('/FootermenuIndex', [AdminController::class, 'FootermenuIndex'])->name('FootermenuIndex');
    Route::post('/FootermenuCreate', [AdminController::class, 'FootermenuCreate'])->name('FootermenuCreate');

    Route::post('/FooterpageSubMenuCreate', [AdminController::class, 'FooterpageSubMenuCreate'])->name('FooterpageSubMenuCreate');
    Route::post('/FooterpageMenuCreate', [AdminController::class, 'FooterpageMenuCreate'])->name('FooterpageMenuCreate');
    Route::get('/FooterfetchMenu', [AdminController::class, 'FooterfetchMenu'])->name('FooterfetchMenu');
    Route::get('/FootergetMenu', [AdminController::class, 'FootergetMenu'])->name('FootergetMenu');
    Route::post('/FooterupdateMenu', [AdminController::class, 'FooterupdateMenu'])->name('FooterupdateMenu');
    Route::get('/FooterfetchSubMenu/{id}', [AdminController::class, 'FooterfetchSubMenu'])->name('FooterfetchSubMenu');
    Route::post('/FootergetSubMenu', [AdminController::class, 'FootergetSubMenu'])->name('FootergetSubMenu');
    Route::post('/FooterupdateSubMenu', [AdminController::class, 'FooterupdateSubMenu'])->name('FooterupdateSubMenu');
    Route::get('/FooterfetchPageMenu/{id}', [AdminController::class, 'FooterfetchPageMenu'])->name('FooterfetchPageMenu');
    Route::get('/FootergetPageMenu', [AdminController::class, 'FootergetPageMenu'])->name('FootergetPageMenu');
    Route::post('/FooterupdatePageMenu', [AdminController::class, 'FooterupdatePageMenu'])->name('FooterupdatePageMenu');
    Route::post('/FooterdeletePageMenu', [AdminController::class, 'FooterdeletePageMenu'])->name('FooterdeletePageMenu');
    Route::get('/FooterfetchPageSubMenu/{id}', [AdminController::class, 'FooterfetchPageSubMenu'])->name('FooterfetchPageSubMenu');
    Route::get('/FootergetPageSubMenu', [AdminController::class, 'FootergetPageSubMenu'])->name('FootergetPageSubMenu');
    Route::post('/FooterupdatePageSubMenu', [AdminController::class, 'FooterupdatePageSubMenu'])->name('FooterupdatePageSubMenu');
    Route::post('/FooterdeletePageSubMenu', [AdminController::class, 'FooterdeletePageSubMenu'])->name('FooterdeletePageSubMenu');
    Route::get('/FooterdetailMenu/{id}', [AdminController::class, 'FootermenuDetail'])->name('FootermenuDetail');
    Route::get('/FooterdetailSubMenu/{id}', [AdminController::class, 'FootersubMenuDetail'])->name('FootersubmenuDetail');
    Route::get('/FooterdetailPageMenu/{id}', [AdminController::class, 'FooterpageMenuDetail'])->name('FooterpageMenuDetail');
    Route::post('/FooterdeleteMenu', [AdminController::class, 'FooterdeleteMenu'])->name('FooterdeleteMenu');
    Route::post('/FooterdeleteSubMenu', [AdminController::class, 'FooterdeleteSubMenu'])->name('FooterdeleteSubMenu');

    Route::post('/FootersubmenuCreate', [AdminController::class, 'FootersubMenuCreate'])->name('FootersubMenuCreate');

});

Route::group(['prefix' => '/'], function () {
    Route::get('/', [FrontController::class, 'appIndex'])->name('appIndex');
   //menü sayfası getirmek için yazılan route
    Route::get('/page/{page_id}', [FrontController::class, 'page'])->name('page');
    //Slider sayfası getirmek için yazılan route
    Route::get('/get-page-by-Slider', [FrontController::class, 'getPageBySlider'])->name('getPageBySlider');
    //Card1 sayfası getirmek için yazılan route
    Route::get('/get-page-by-Card1', [FrontController::class, 'getPageByCard1'])->name('getPageByCard1');
    //Card2 sayfası getirmek için yazılan route
    Route::get('/get-page-by-Card2', [FrontController::class, 'getPageByCard2'])->name('getPageByCard2');
    //SabitSide sayfası getirmek için yazılan route
    Route::get('/get-page-by-SabitSide', [FrontController::class, 'getPageBySabitSide'])->name('getPageBySabitSide');
    //SabitSide sayfası getirmek için yazılan route
    Route::get('/get-page-by-SabitIcon', [FrontController::class, 'getPageBySabitIcon'])->name('getPageBySabitIcon');
    //PageCard sayfası getirmek için yazılan route
    Route::get('/get-page-by-PageCard', [FrontController::class, 'getPageByPageCard'])->name('getPageByPageCard');
    //Footer sayfası getirmek için yazılan route
    Route::get('/page/{page_id}', [FrontController::class, 'pagefooter'])->name('pagefooter');
});
