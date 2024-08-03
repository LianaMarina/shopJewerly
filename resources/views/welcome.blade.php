@extends('layout/app')

@section('title')
    ShopJewerlyMarina
@endsection

@section('content')
<style>
    .main_block {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
    .main_block:before {
        content: '';
        display: block;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color:rgba(0, 0, 0, .3);
}
.hide_block2 {
  overflow: hidden;
  animation: showDiv 5.5s forwards;
}
@keyframes showDiv {
  0%, 99% {
    height: 0px;
  }
  100% {
    height: 600px;
  }
}
</style>
<div class="container" id="welcome">
  <div class="main_block" id="main_block" style="width: 100%; height: 600px; background: url(https://i.pinimg.com/564x/8d/39/78/8d39788572ebfb3a031e0a7cc7733a73.jpg) no-repeat; background-size: cover;">
    <div class="block_title" style="padding: 100px; border: 2px solid white; width: 500px;">
      <p style="color: white; text-align: center; font-size: 20px;">NEW COLLECTION</p>
  </div>
  </div>
  <div id="carouselExampleIndicators" class="carousel slide hide_block2" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item" style="solid border: 1px black" :class="index == 0 ? 'active' : ''" v-for="(new_product, index) in new_products">
        <div class=" d-flex col-12 justify-content-between shadow" style="border: solid 1px black !important; border-radius: 15px;">
          <div style="background-color: #ebe7dd;" class="col-6" style="position: relative;">
            <h5 style="width: 500px !important; color: black !important; position:absolute; top: 40%; left: 5%; font-size: 25px; text-transform:uppercase; height: 100%; lime-height: 100%;">@{{ new_product.title }}</h5>
          </div>
          <img class="col-6 d-flex justify-content-center" :src="'/public'+new_product.images" alt="..."  style="object-fit: cover !important; height: 550px;">
        </div>
      </div>
    </div>
    
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  <div class="text-align-center my-5" id="popular_block">
      <h4 style="font-size: 35px; font-family: 'Oswald'; font-weight: 300;" class="d-flex justify-content-center my-5">Наши Популярные Товары</h4>
      <div class="cards d-flex gap-3 flex-wrap justify-content-center mb-5">
        <div class="card" style="width: 18rem; border: 0.5px solid black; border-radius: 15px;"
            v-for="product in popularProducts">
            <div :id="'carouselExample' + product.id" class="carousel slide card-img-top">
                <div class="carousel-inner">
                    <div class="carousel-item" :class="index == 0 ? 'active' : ''" style="width: 100%; height: 300px;"
                        v-for="(img, index) in product.images">
                        <img :src="'/public' + img" class="d-block w-100" alt="" class="mb-1">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" :data-bs-target="'#carouselExample' + product.id"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" :data-bs-target="'#carouselExample' + product.id"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="card-body" style="background-color: #ebe7dd !important; position: relative;">
                <h5 class="card-title mb-4" style="min-height: 80px;">@{{ product.title }}</h5>
                <p class="mb-4" style="text-align:right; font-weight: 700; font-size: 20px; color: rgb(151, 0, 0);">
                    @{{ product.price }} Р</p>
                <a :href="`{{ route('show_more_details_product') }}/${product.id}`"
                    style="text-decoration: underline; position:absolute; bottom: 10px; right: 15px; color:rgb(15, 11, 11);">Подробнее</a>
            </div>
        </div>
    </div>
    </div>
  <div class="my-5 d-flex col-12 gap-5" style="height: 300px; overflow:hidden;">
    <div class="col-7">
      <img src="https://i.pinimg.com/564x/65/60/dc/6560dc392876240cfb8f4266ba0a4222.jpg" alt="" class="w-100">
    </div>
    <div class="col-4">
       <h3 class="display-6 pb-3" style="font-size: 35px; font-family: 'Oswald';">Контакты</h3>
     <div class="" style="font-size: 20px;">
        <p><i class="bi bi-telephone"></i> +7(934) 375-30-21</p>
        <p><i class="bi bi-envelope"></i> jewerly_marina_@gmail.com</p>
        <p><i class="bi bi-building"></i> г. Нижний Новгород, ул. Изумрудная, д.13</p>
     </div>
    </div>
  </div>
</div>
<script>
    const app = {
        data() {
            return {
                message: '',
                errors: [],
                new_products: [],
                popularProducts: [],
            }
        },
        methods: {
            async getData() {
                const responseNew = await fetch('{{ route('getNewProducts') }}');
                this.new_products = await responseNew.json();
                this.new_products.forEach(element => {
                    element.images = element.images.split(";").shift();
                });
                console.log(this.new_products);
                let slider = document.getElementById('main_block');
                setTimeout(() => {
                  slider.style.display = 'none';
                }, 5000);
                const responsePopular = await fetch('{{ route('getPopularProducts') }}');
                this.popularProducts = await responsePopular.json();
                this.popularProducts.forEach(element => {
                        element.images = element.images.split(";");
                    });
                this.popularProducts.forEach(element => {
                  element.images.pop();
                });
                console.log(this.popularProducts);
            }
        },
        mounted() {
            this.getData();
        }
    }
    Vue.createApp(app).mount('#welcome');
    </script>
@endsection