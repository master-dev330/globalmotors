<!DOCTYPE html>
<html lang="">

<?php
$currentMethod =Route::getCurrentRoute()->getActionMethod();
$seo = get_seo('0');

?>

<head>

    <meta charset="utf-8">
    <title>{{isset($seo->site_name)?$seo->site_name:''}} </title>
    <meta name="description" content="{{$seo->meta_desc}}"/>
    <meta name="keywords" content="{{$seo->keywords}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$seo->title}}"/>
    <meta property="og:description" content="{{$seo->meta_desc}}"/>
    <meta property="og:url" content="{{url('/')}}"/>
    <meta property="og:site_name" content="{{$seo->site_name}}"/>
    <meta property="og:image" content="{{url('/')}}{{$seo->image}}"/>
    <meta name="viewport" content="width=device-width">
    <link rel="icon" href="{{asset('/frontend/images/favicon-gmh1x.png')}}">
    <meta property="og:image" content="img/dest/preview.jpg">
     @include('frontend.layout.css')
     @yield('css')
   <style>
#loader {
background: #4183D7 url(http://hello-site.ru//main/images/preloads/spinning-circles.svg) center center no-repeat;
background-size: 6%;
height: 100vh;
width: 100%;
position: fixed;
z-index: 100;

}

#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:block;
}

@-webkit-keyframes spin {
    from {-webkit-transform:rotate(0deg);}
    to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
    from {transform:rotate(0deg);}
    to {transform:rotate(360deg);}
}

#cover-spin::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
</style>
</head>

<body>
    {{-- <div id="loader"></div> --}}
    <div id="cover-spin"></div>

<header class="header">
        <div class="header-row">
            <div class="header-logo">
                <a href="{{url('/')}}"><img  src="{{asset('/frontend/images/src/globalmotorslogo.png')}}" alt=""></a>
            </div>
            @php
            $searchQuery="";
            @endphp
            @if(Session::has('searchQuery'))
             @php
            $searchQuery=Session::get('searchQuery');
            @endphp
            @endif
            <div class="header-nav-center">
                <div class="header-nav-form">
                    <form class="form-inline header-form-search my-2 my-lg-0" action="{{url(app()->getLocale().'/searchbar')}}" method="post">
                        {{csrf_field()}}
                        <input class="form-control mr-sm-2" placeholder="@lang('header.placeholder')" name="search" value="{{$searchQuery}}">
                        <button class="btn searchbutton" type="submit"><img src="{{asset('/frontend/images/icon-new/search.svg')}}" alt=""></button>
                    </form>
                </div>
                <div class="header-nav-link">
                    <ul>
                        {{-- <li><a href="search-catalog-NEW.html">Поиск</a></li> --}}
                        <li><a >@lang('header.check') VIN</a></li>
                        <li><a href="{{url(app()->getLocale().'/lotsearch')}}">@lang('header.cars')</a></li>
                    </ul>
                </div>
            </div>
            <div class="header-nav-right">
                
                        @if(Auth::check())
                 
                  <div class="header-cabinet-wrap dropdown">
                    <a href="" class="btn-cabinet dropdown-toggle" data-toggle="dropdown">
                        <span class="icon"><img src="{{asset('/frontend/images/icon-new/person.svg')}}" alt=""></span>
                        <div class="cabinet2">
                            <p>{{Auth::user()->name}}</p>
                            <span>$ <strong>{{bid_amount_limit(Auth::user()->id);}}</strong>USD</span>
                        </div>
                        <span class="arrow-icon"></span>
                    </a>
                    <div class="cabinet-group-link dropdown-menu">
                        <a href="{{url(app()->getLocale().'/usersettings/'.Auth::user()->id).'?'."type=Account"}}" class="link-item">
                            <span class="link-item-icon"><img src="{{asset('/frontend/images/icon-new/person.svg')}}" alt=""></span>
                            <div class="link-item-info">
                                <p>{{Auth::user()->email}}</p>
                                <p class="color-blue">@lang('header.profile')</p>
                            </div>
                        </a>
                        <a href="" class="link-item">
                            <span class="link-item-icon"><img src="{{asset('/frontend/images/icon-new/icon-center.svg')}}" alt=""></span>
                            <div class="link-item-info">
                                <p>@lang('header.bidsize')</p>
                                <span>$ <strong>{{bid_amount_limit(Auth::user()->id)}}</strong>USD</span>
                            </div>
                        </a> 
                        <a href="{{ url(app()->getLocale().'/userdashboard') }}" class="link-item">
                            <span class="link-item-icon"><img src="{{asset('/frontend/images/icon-new/icon-center.svg')}}" alt=""></span>
                            <div class="link-item-info">
                                <p>@lang('header.dashboard')</p>
                               
                            </div>
                        </a>
                        <a href="{{url(app()->getLocale().'/userlogout')}}" class="link-item">
                            <span class="link-item-icon"><img src="{{asset('/frontend/images/icon-new/person.svg')}}" alt=""></span>
                            <div class="link-item-info">
                                <p>@lang('header.logout')</p>
                            </div>
                        </a>
                    </div>
                </div>
                @else
                 <div class="header-nav-btn">
                     <a href="{{url(app()->getLocale().'/login')}}" class="btn btn-login-mobile"><img src="{{ asset('/frontend/images/icon/box-arrow.svg') }}"></a>
                    <a href="{{url(app()->getLocale().'/login')}}" class="btn btn-login">@lang('header.login')</a>
                    <a href="{{url(app()->getLocale().'/userregister')}}" class="btn btn-register btn-dark-blue">@lang('header.registration')</a>
                    <div class="mobile-icon-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                @endif 
                <div class="dropdown btn-lang">
                    <a class="nav-link dropdown-toggle languagetest " id="navbarDropdown"  data-toggle="dropdown" aria-haspopup="true" data-lang='en'>
                        @php
                           $lang='EN';
                            if(Session::has('locale')){
                                $lang=Session::get('locale');
                            }
                            // dd(Session::get('locale'));
                        @endphp
                        @if ($lang=="en")
                            EN
                        @elseif($lang=="ru")  
                          RU
                        @elseif($lang=="uk")
                          UK    
                        @endif
                        <span class="arrow-icon"></span>
                    </a>
                      @php
                          $parameter=last(request()->segments());
                          if(is_numeric($parameter)){
                            $parameter=last(request()->segments());
                          }else{
                            $parameter='';
                          }
                      @endphp
                    <div class="dropdown-menu dropdown-menu-lang" aria-labelledby="navbarDropdown">
                         @foreach (config('app.available_locales') as $key=>$locale)
                      
                        <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $locale) }}/{{$parameter}}" class="dropdown-item language" data-lang='{{$locale}}' data-value="RU">{{ strtoupper($locale) }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class='d-none' id="google_translate_element"></div>
{{--         <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ Config::get('languages')[App::getLocale()] }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
    @foreach (Config::get('languages') as $lang => $language)
        @if ($lang != App::getLocale())
                <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a>
        @endif
    @endforeach
    </div>
</li> --}}

<div class="mobile-menu" id="menu-mobile">
        <div class="mobile-menu-wrap">
            <ul>
                <li><a href="{{url(app()->getLocale().'/lotsearch')}}">@lang('header.search')</a></li>
                <li><a >@lang('header.check') VIN</a></li>
                <li><a href="{{url(app()->getLocale().'/lotsearch')}}">@lang('header.cars')</a></li>
            </ul>
        </div>
        
    </div>


{{-- @php
    dd(Session::get('applocale'));
@endphp --}}
</header>

@yield('content')

@include('frontend.layout.footer')
@include("frontend.layout.js")
@yield('js')

</body>
</html>
