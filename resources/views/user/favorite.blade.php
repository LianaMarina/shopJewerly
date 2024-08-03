@extends('layout/app')

@section('title')
    Моё избранное
@endsection

@section('content')
<style>
    .btn-in-cart {
            border: solid 1px rgb(102, 86, 53);
            color: white;
            font-weight: 500;
            border-radius: 5px !important;
            background-color: #c3b091;
        }

        .btn-in-cart:hover {
            background-color: #c3b091;
            color: white;
        }

        .btn-in-fav {
            border: solid 1px rgb(151, 0, 0);
            color: white;
            background-color: rgb(151, 0, 0);
        }
</style>
<div class="container" id="favorites">
    @if (session()->has('success_add_cart'))
            <div class="alert alert-success">
                {{ session('success_add_cart') }}
            </div>
        @endif
        @if (session()->has('error_add_fav'))
            <div class="alert alert-danger" id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>
                {{ session('error_add_fav') }}
            </div>
        @endif
    <h2 class="my-5">Избранное</h2>
    <div class="favorites d-flex gap-3 flex-wrap mb-5">
        <div class="card" style="width: 18rem; border: solid 0.5px black; border-radius: 15px;"
                v-for="favorite in favorites">
                <div :id="'carouselExample' + favorite.favorite_id" class="carousel slide card-img-top">
                    <div class="carousel-inner">
                        <div class="carousel-item" :class="index == 0 ? 'active' : ''" style="width: 100%; height: 300px;"
                            v-for="(img, index) in favorite.product_images">
                            <img :src="'/public' + img" class="d-block w-100" alt="" class="mb-1">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" :data-bs-target="'#carouselExample' + favorite.favorite_id"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" :data-bs-target="'#carouselExample' + favorite.favorite_id"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card-body" style="background-color: #ebe7dd !important; position: relative;">
                    <h5 class="card-title mb-4" style="min-height: 80px;">@{{ favorite.product_title }}</h5>
                    <p class="mb-4" style="text-align:right; font-weight: 700; font-size: 20px; color: rgb(151, 0, 0);">
                        @{{ favorite.product_price }} Р</p>
                    @auth
                        <div class="d-flex gap-1">
                            <a :href="`{{ route('add_product_cart') }}/${ favorite.product_id }`" style="border-radius: 0px;" class="btn btn-in-cart">В корзину <i
                                    class="bi bi-cart"></i></a>
                            <div class="">
                                <a :href="`{{ route('add_product_favorite') }}/${ favorite.product_id }`" class="btn btn-in-fav"><i
                                        class="bi bi-heart"></i></a>
                            </div>
                        </div>
                    @endauth
                    <a :href="`{{ route('show_more_details_product') }}/${favorite.product_id}`"
                        style="text-decoration: underline; position:absolute; bottom: 10px; right: 15px; color:rgb(15, 11, 11);">Подробнее</a>
                </div>
            </div>
    </div>
</div>
<script>
    const app = {
        data() {
            return {
                errors: [],
                message: '',
                favorites: [],
            }
        },
        methods: {
            async getData() {
                const responseFavorite = await fetch('{{ route('get_user_favorites_products') }}');
                this.favorites = await responseFavorite.json();
                this.favorites.forEach(element => {
                        element.product_images = element.product_images.split(";");
                    });
                    this.favorites.forEach(element => {
                        element.product_images.pop();
                    });
                console.log(this.favorites);
            }
        },
        mounted() {
            this.getData();
        }
    }
    Vue.createApp(app).mount('#favorites');
</script>
@endsection