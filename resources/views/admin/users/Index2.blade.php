<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTECTUS</title>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('Front/assets/css/style.css')}}">

</head>

<body>
@php
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
                                        <a href="@if($submenu->getPage) {{ route('page', $submenu->getPage->id) }} @endif" class="dropdown-item">{{ $submenu->name }}</a>
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


<!-- slider -->



<div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">

        @foreach($images as $key => $image)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner" style="background: #f2f2f2;">
        @foreach($images as $key => $image)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="row">
                    <div class="col-md-7 p-5">
                        <div class="offset-2">
                            <h1 class="">{{ $image->maintitle }}</h1>
                            <p class="">{{ $image->maindescription }}</p>
                            <a href="{{ route('getPageBySlider', ['link' => $image->link]) }}" class="btn btn-primary" onclick="getPageData('{{ $image->link }}')">{{ $image->link }}</a>
                        </div>
                    </div>
                    <div style="min-height:400px; max-height: 400px" class="img-fluid col-md-5 "><img src="{{ asset('slider/' . $image->img) }}" class="d-block w-100 h-100 "  alt="...">
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>



<!-- 2. kısım  -->

<section class="section1 mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            @foreach ($SabitIcon as $item)
                <div class="col-md-2 col-sm-12 mb-4 d-flex flex-column align-items-center justify-content-center text-center">
                    <a href="{{ route('getPageBySabitIcon', ['maintitle' => $item->maintitle]) }}">
                        <img  class="d-block img-xbox mx-5" src="{{ asset('SabitIcon/'. $item->img) }}" alt="">
                    </a>
                    <a href="{{ route('getPageBySabitIcon', ['maintitle' => $item->maintitle]) }}" class="text-dark d-block mt-3">{{ $item->maintitle }}</a>
                </div>

            @endforeach
        </div>
    </div>
</section>



<!-- 2. kısım  -->
<!-- card_slider -->

<section class="section p-5">
    <div class="row p-5">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach(array_chunk($card1->all(), 4) as $key => $chunk)
                        <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $card)
                                    <div class="col-md-3 mb-3">
                                        <div class="card cardborder">
                                            <img style="min-height:250px; max-height: 250px" class="img-fluid cardimgw" alt="100%x280" src="{{ asset('card1/' . $card->img) }}">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $card->maintitle }}</h4>
                                                <p class="card-text mt-4">{{ $card->maindescription }}</p>
                                                <a class="cardlink" href="{{ route('getPageByCard1', ['link' => $card->link]) }}">
                                                    <h5 class="mt-4">{{ $card->link }}></h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Centered next and prev buttons -->
        <div class="col-12 d-flex justify-content-center mt-5">
            <a class="btn btn-dark mb-3 mr-1 mx-5" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="btn btn-dark mb-3" href="#carouselExampleIndicators2" role="button" data-slide="next">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>


<!-- card_slider -->
<!-- sabitkısım -->

@foreach ($SabitSide as $item)
<section class="section p-5 ">

    <div   class="row  sabitback ">
        <div class="col-md-7 mt-5   ">
            <div class="offset-2 mt-5">
                <h1 class="mt-5">{{($item->maintitle)}}</h1>
                <p class="mt-5">{{($item->maindescription)}}</p>
                <a href="{{ route('getPageBySabitSide', ['link' => $item->link]) }}" class="btn btn-primary mt-5">{{ $item->link }}</a>

            </div>
        </div>
        <div class="col-md-5"><img src="{{ asset('SabitSide/'. $item->img) }}" class="d-block w-100" alt="..z.">

        </div>
    </div>
</section>
@endforeach
<!-- sabitkısım -->


<!-- card2_slider -->

<section class="section p-5">
    <div class="row p-5">
        <div class="col-12">
            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach(array_chunk($card2->all(), 4) as $key => $chunk)
                        <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $card)
                                    <div class="col-md-3 mb-3">
                                        <div class="card cardborder">
                                            <img style="min-height:250px; max-height: 250px" class="img-fluid cardimgw" alt="100%x280" src="{{ asset('card2/' . $card->img) }}">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $card->maintitle }}</h4>
                                                <p class="card-text mt-4">{{ $card->maindescription }}</p>
                                                <a class="cardlink" href="{{ route('getPageByCard2', ['link' => $card->link]) }}">
                                                    <h5 class="mt-4">{{ $card->link }}></h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-12 d-flex justify-content-center mt-5">
                    <a class="btn btn-dark mb-3 mr-1 mx-5" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a class="btn btn-dark mb-3" href="#carouselExampleIndicators2" role="button" data-slide="next">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- card2_slider -->




<!-- above_of_footer -->
<section class="section mx-3 mt-5"> <!-- mx-3 ile yatay boşluk azaltıldı -->
    <div class="row">
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
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script src="{{asset("Front/assets/scripts/slider.js")}}"></script>
<script src="{{asset("Front/assets/scripts/card_script.js")}}"></script>
<script src="{{asset("Front/assets/scripts/script.js")}}"></script>
<script src="{{asset("Front/assets/scripts/swiper-bundle.min.js")}}"></script>
<!-- HTML içerisinde Slider'ı başlatan JavaScript kodu -->

<!-- Template Main JS File -->
</body>
</html>
