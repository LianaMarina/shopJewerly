<style>
  #logo::after{
    width: 100%;
    display: block;
    height: 1px;
    content: "";
    background-color: #686451;
  }
  li {
    padding-right: 15px;
  }
</style>
<div class="container">
  <div class="d-flex w-100 justify-content-center">
      <a id="logo" class="navbar-brand mt-3" href="{{ route('welcome') }}" style="font-size: 30px; font-family: 'DM Serif Display'">JewerlyMarina</a>
  </div>
    <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @guest
               <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('show_registration') }}">РЕГИСТРАЦИЯ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('login') }}">АВТОРИЗАЦИЯ</a>
          </li> 
            @endguest
          @auth
          @if (auth()->user()->role == 1)
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('show_characters') }}">ХАРАКТЕРИСТИКИ</a>
          </li> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('show_filials') }}">ФИЛИАЛЫ</a>
          </li> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('show_products_page') }}">ТОВАРЫ</a>
          </li> 
          <li class="nav-item" style="position: relative;">
            <a class="nav-link active position-relative" aria-current="page" href="{{ route('show_all_orders_page') }}">ЗАКАЗЫ </a>
            <span class="position-absolute top-0 start-50 mx-4 translate-middle badge rounded-pill bg-danger">
              {{ app('App\Http\Controllers\OrderController')->getCurrentOrdersCount() }}
              <span class="visually-hidden">unread messages</span>
          </li> 
          @endif
          @endauth
          <a class="nav-link active" aria-current="page" href="{{ route('show_catalog_page') }}">КАТАЛОГ</a>
          
        </ul>
        @auth
        <a class="nav-link active" aria-current="page" href="{{ route('show_cart_page') }}"><i class="bi bi-cart"></i></a>
        <li class="nav-item mx-3" style="list-style-type:none;">
          <a class="nav-link active" aria-current="page" href="{{ route('show_user_favorite') }}"><i class="bi bi-heart"></i></a>
        </li> 
          <li class="nav-item mx-3" style="list-style-type:none;">
          <a class="nav-link active" aria-current="page" href="{{ route('show_user_profile') }}">ПРОФИЛЬ</a>
        </li> 
          <li class="nav-item" style="list-style-type:none;">
          <a class="nav-link active" aria-current="page" href="{{ route('exit') }}">ВЫХОД</a>
        </li> 
        @endauth
      </div>
    </div>
  </nav>
</div>