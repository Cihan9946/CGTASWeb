<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('Front/assets/css/style.css')}}">





</head>
<body>
@php
    $PageCard = \App\Models\PageCard::get();
    $menus = \App\Models\Menu::get();

@endphp
<header >

    <nav style="background-color: white;" class="navbar navbar-expand-lg navbar-light" >
        <div class="container-fluid">
            <a href="{{route('appIndex')}}" class="navbar-brand d-flex mt-1 mx-3 ">

                <img  class="mb-3" src="{{asset('Front/images/shopcgt1.jpg')}}" width="100" height="90" alt="CoolBrand">
                <span class="h2 mt-4"  >Contectus</span>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-5 mx-2 menuler" id="navbarCollapse">
                <div class="navbar-nav mb-5 mx-5 yazi">

                    @foreach($menus->where('top_menu_id', null) as $menu)
                        @if($menu->getSubmenus->count() > 0)
                            <div class="dropdown">
                                <a href="#" class="nav-item nav-link mx-2" id="navbarDropdown{{ $menu->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $menu->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $menu->id }}">
                                    @foreach($menu->getSubmenus as $submenu)
                                        <a href="@if($submenu->getPage) {{ route('pages', $submenu->getPage->id) }} @endif" class="dropdown-item">{{ $submenu->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="@if($menu->getPage) {{ route('page', $menu->getPage->id) }} @endif" class="nav-item nav-link mx-2">{{ $menu->name }}</a>
                        @endif
                    @endforeach


                </div>
            </div>


            <div class="mx-5 yazi">Ara</div>
            <div style="margin-left: -40px;"></div>

            <a class="mx-5" href="#"><img src="{{asset('Front/images/Search.png')}}" alt=""></a>

            <ul class="navbar-nav mr-5  ">


                <!-- Diğer Navbar Öğeleri -->

                <!-- Dil Seçenekleri -->
                <li class="nav-item dropdown h4">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-tr mr-1"></span> <!-- Amerika Bayrağı -->
                    </a>
                    <div class="dropdown-menu" aria-labelledby="languageDropdown">
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-tr  mr-1 h3"></span> Turkish</a>
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-us mr-1 h3"></span> English</a>
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-pl mr-1 h3"></span> Polish</a>
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-cn mr-1 h3"></span> Chinese</a>
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-de mr-1 h3"></span> German</a>
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-fr mr-1 h3"></span> French</a>
                        <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-it mr-1 h3"></span> Italian</a>
                        <!-- Diğer Dil İconları -->
                    </div>
                </li>
            </ul>
        </div>
    </nav>

</header>

@if(isset($page))
<section class="section  d-flex justify-content-center align-items-center  about-text-back">
    <div class="container">
        <h2 class="mt-3 ">{{$page->title}}</h2>
        <div class="row">
            <div  class="col-md bg-white mt-5 p-5 about-text">
                <div  class="h5 p-2 text-dark">
                    {!! $page->description !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif




<section class="section mt-5">
    <div class="row justify-content-center ">
        @foreach($PageCard as $card)
            <div  class="col-lg col-sm-12 col-md d-flex justify-content-center mt-5">
                <div  class="card" style=" width: 40rem; border: 0px">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <img style="min-height:250px; max-height: 250px" src="{{ asset('PageCard/' . $card->img) }}" class="card-img mt-5" alt="...">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body text-center">
                                <h3 class="card-title mt-5">{{ $card->maintitle }}</h3>
                                <p class="card-text mt-5">{{ $card->maindescription }}</p>
                                <a href="{{ route('getPageByPageCard', ['link' => $card->link]) }}" class="btn btn-primary mt-5">{{ $card->link }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>








<!-- middle -->









<!-- above_of_footer -->
<section style="margin-top: 100px" class="section mx-3 "> <!-- mx-3 ile yatay boşluk azaltıldı -->
    <div class="row ">
        <div class="col-md col-sm-12 d-flex flex-wrap mx-3 mt-4"> <!-- flex-wrap ile içeriklerin sıralaması mobilde düzgün olacak -->
            <p class="h5 mr-3 mx-2">Microsoft yeniliklerini takip edin</p> <!-- mr-3 ile yazı ile resimler arasına boşluk eklendi -->
            <a href="#" class="mb-3 mr-3 mx-2"><img class="sosimg" src="{{asset('Front/images/Facebook_1.png')}}" alt=""></a> <!-- mb-3 ile resimler arası boşluk eklendi -->
            <a href="#" class="mb-3 mr-3 mx-2"><img class="sosupimg" src="{{asset('Front/images/LinkedIn.png')}}" alt=""></a>
            <a href="#" class="mb-3 mr-3 mx-2"><img class="sosupimg" src="{{asset('Front/images/TwitterX.png')}}" alt=""></a>
            <a href="#" class="mb-3"><img class="sosimg" src="{{asset('Front/images/YouTube.png')}}" alt=""></a> <!-- Son resimde mr-3 kaldırıldı -->

        </div>
        <div class="col-md col-sm-12 d-flex justify-content-end">
            <button class="basadonback">
                <a  href="#" class="basadonback1 d-flex">
                    <img class="upimg" src="{{asset('Front/images/Up.png')}}" alt="">
                    <h6 class="mt-4 mx-3 text-dark">Başa Dönün</h6> <!-- mx-3 ile resim ile metin arasına boşluk eklendi -->
                </a>
            </button>
        </div>
    </div>
</section>


<!-- above_of_footer -->






<!-- footer -->
<footer class="mt-3">

    <section class="section footerback p-5 ">
        <div class="row mt-5">
            <div class="col-md-2">
                <h4 class="mb-5 headtext">Yenilikler</h4>
                <h6 class="mb-4">Microsoft 365</h6>
                <h6>Windows 11 uygulamaları</h6>
            </div>
            <div class="col-md-2">
                <h4 class="mb-5 headtext">Microsoft Store</h4>
                <h6 class="mb-4">Hesap Profili</h6>
                <h6 class="mb-4">İndirme Merkezi</h6>
                <h6 class="mb-4">Microsoft Store Desteği</h6>
                <h6 class="mb-4">İadeler</h6>
                <h6 class="mb-4">Sipariş İzleme</h6>
            </div>
            <div class="col-md-2">
                <h4 class="mb-5 headtext">Eğitim</h4>
                <h6 class="mb-4">Microsoft Eğitimi</h6>
                <h6 class="mb-4">Eğitim için Microsoft Teams</h6>
                <h6 class="mb-4">Microsoft 365 Eğitim</h6>
                <h6 class="mb-4">Office Eğitim</h6>
                <h6 class="mb-4">Eğitimci eğitimi ve gelişimi</h6>
                <h6 class="mb-4">Öğrenciler için Azure</h6>
            </div>
            <div class="col-md-2">
                <h4 class="mb-5 headtext">İşletme</h4>
                <h6 class="mb-4">Microsoft Cloud</h6>
                <h6 class="mb-4">Microsoft Güvenlik</h6>
                <h6 class="mb-4">Azure</h6>
                <h6 class="mb-4">Dynamics 365</h6>
                <h6 class="mb-4">Microsoft 365</h6>
                <h6 class="mb-4">Microsoft Adversiting </h6>
                <h6 class="mb-4">Microsoft Industry</h6>
                <h6 class="mb-4">Microsoft Teams</h6>
            </div>
            <div class="col-md-2">
                <h4 class="mb-5 headtext">Geliştirici ve BT</h4>
                <h6 class="mb-4">Geliştirici Merkezi</h6>
                <h6 class="mb-4">Belgeler</h6>
                <h6 class="mb-4">Microsoft Learn</h6>
                <h6 class="mb-4">Microsoft Tech Community</h6>
                <h6 class="mb-4">Azure Market</h6>
                <h6 class="mb-4">AppSource</h6>
                <h6 class="mb-4">Microsoft Power Platform</h6>
            </div>
            <div class="col-md-2">
                <h4 class="mb-5 headtext">Şirket</h4>
                <h6 class="mb-4">Kariyer Fırsatları</h6>
                <h6 class="mb-4">Microsoft Hakkında</h6>
                <h6 class="mb-4">Microsoft’ta Gizlilik</h6>
                <h6 class="mb-4">Microsoft 365 Eğitim</h6>
                <h6 class="mb-4">Yatırımcılar</h6>
                <h6 class="mb-4">Sürdürülebilirlik</h6>
            </div>
        </div>
    </section>

    <section class="section footerback p-5 ">
        <div class="row mt-5">
            <div class="col-md-2 d-flex"><img  class="mb-4 eartimage"  src="{{asset('Front/images/Earth Planet.png')}}" alt="">
                <div class="d-flex flex-column mx-5">
                    <h6 class="mb-4">Türkçe(Türkiye)</h6>
                    <h6>Microsoft 2024</h6>
                </div>
            </div>
            <div class="col-md-2">
                <h6 class="mb-4">Gizlilik</h6>
            </div>
            <div class="col-md-2">
                <h6 class="mb-4">Tanımlama bilgilerini </h6>
            </div>
            <div class="col-md-2">
                <h6 class="mb-4">Kulllanım Şartları</h6>
            </div>
            <div class="col-md-2">
                <h6 class="mb-4">Ticari Markalar</h6>
            </div>
            <div class="col-md-2">
                <h6 class="mb-4">Reklamlarımız Hakkında</h6>
            </div>
        </div>
    </section>

</footer>
<!-- footer -->




</body>
</html>
