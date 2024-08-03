@extends('layout/app')

@section('title')
    Каталог
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
    <div class="container" id="catalog">
        {{-- <p>
        @{{ products }}
    </p> --}}
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

        <h5>Поиск</h5>
        <form class="my-3 d-flex gap-1" id="search_form" @submit.prevent="search">
            <input type="text" placeholder="Поиск..." name="search" class="form-control">
            <button class="btn btn-dark" type="submit">Поиск</button>
        </form>

        <h5>Фильтрация</h5>
        <form id="filter" @submit.prevent="filter">
            <div class="filters d-flex gap-3 flex-wrap">
                <div class="filter">
                    <h6>Тип</h6>
                    <div v-for="type in types">
                        <input type="checkbox" :value="type.id" :id="'type_' + type.id" name="type[]" class="mx-1">
                        <label :for="'type_' + type.id">@{{ type.title }}</label>
                    </div>
                </div>

                <div class="filter">
                    <h6>Вставка</h6>
                    <div v-for="stone in stones">
                        <input type="checkbox" :value="stone.id" :id="'stone_' + stone.id" name="stone[]"
                            class="mx-1">
                        <label :for="'type_' + stone.id">@{{ stone.title }}</label>
                    </div>
                </div>

                <div class="filter">
                    <h6>Кому</h6>
                    <div v-for="whome in whomes">
                        <input type="checkbox" :value="whome.id" :id="'whome_' + whome.id" name="whome[]"
                            class="mx-1">
                        <label :for="'whome_' + whome.id">@{{ whome.title }}</label>
                    </div>
                </div>

                <div class="filter">
                    <h6>Огранка</h6>
                    <div v-for="cutting in cuttings">
                        <input type="checkbox" :value="cutting.id" :id="'cutting_' + cutting.id" name="cutting[]"
                            class="mx-1">
                        <label :for="'cutting_' + cutting.id">@{{ cutting.title }}</label>
                    </div>
                </div>

                <div class="filter">
                    <h6>Проба</h6>
                    <div v-for="sample in samples">
                        <input type="checkbox" :value="sample.id" :id="'sample_' + sample.id" name="sample[]"
                            class="mx-1">
                        <label :for="'sample_' + sample.id">@{{ sample.title }}</label>
                    </div>
                </div>

                <div class="filter">
                    <h6>Материал</h6>
                    <div v-for="material in materials">
                        <input type="checkbox" :value="material.id" :id="'material_' + material.id" name="material[]"
                            class="mx-1">
                        <label :for="'material_' + material.id">@{{ material.title }}</label>
                    </div>
                </div>

                <div class="filter">
                    <h6>Бренд</h6>
                    <div v-for="brand in brands">
                        <input type="checkbox" :value="brand.id" :id="'brand_' + brand.id" name="brand[]"
                            class="mx-1">
                        <label :for="'brand_' + brand.id">@{{ brand.title }}</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-dark" type="submit">Применить</button>
        </form>
        <form @submit.prevent="resetAll" id="resetAll">
            <button type="submit" class="btn m-2" style="text-decoration: underline; padding: 0 !important;">Сбросить
                все</button>
        </form>

        <h2 class="my-3">Каталог</h2>
        <div class="cards d-flex gap-3 flex-wrap mb-5">
            <div class="card" style="width: 18rem; border: solid 0.5px black; border-radius: 15px;"
                v-for="product in products">
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
                    @auth
                        <div class="d-flex gap-1">
                            <a :href="`{{ route('add_product_cart') }}/${ product.id }`" style="border-radius: 0px;" class="btn btn-in-cart">В корзину <i
                                    class="bi bi-cart"></i></a>
                            <div class="">
                                <a v-if="favorites_id.includes(product.id)"
                                    :href="`{{ route('add_product_favorite') }}/${ product.id }`" class="btn btn-in-fav"><i
                                        class="bi bi-heart"></i></a>
                                <a :href="`{{ route('add_product_favorite') }}/${ product.id }`" v-else class="btn"><i
                                        class="bi bi-heart"></i></a>
                            </div>
                        </div>
                    @endauth
                    <a :href="`{{ route('show_more_details_product') }}/${product.id}`"
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
                    products: [],

                    types: [],
                    stones: [],
                    whomes: [],
                    cuttings: [],
                    samples: [],
                    materials: [],
                    brands: [],
                    subtypes: [],

                    filials: [],
                    sizes: [],

                    favorites: [],
                    favorites_id: [],
                }
            },
            methods: {
                async getProducts() {
                    const response_type = await fetch('{{ route('getTypes') }}');
                    const response_stones = await fetch('{{ route('getStones') }}');
                    const response_whomes = await fetch('{{ route('getWhomes') }}');
                    const response_cuttings = await fetch('{{ route('getCuttings') }}');
                    const response_samples = await fetch('{{ route('getSamples') }}');
                    const response_materials = await fetch('{{ route('getMaterials') }}');
                    const response_brands = await fetch('{{ route('getBrands') }}');
                    const response_subtypes = await fetch('{{ route('getSubtypes') }}');
                    const response_filials = await fetch('{{ route('getFilials') }}');
                    const response_sizes = await fetch('{{ route('getSizes') }}');


                    this.types = await response_type.json();
                    this.stones = await response_stones.json();
                    this.whomes = await response_whomes.json();
                    this.cuttings = await response_cuttings.json();
                    this.samples = await response_samples.json();
                    this.materials = await response_materials.json();
                    this.brands = await response_brands.json();
                    this.subtypes = await response_subtypes.json();
                    this.filials = await response_filials.json();
                    this.sizes = await response_sizes.json();


                    const responseProducts = await fetch('{{ route('getProducts') }}');
                    this.products = await responseProducts.json();
                    console.log(this.products);
                    this.products.forEach(element => {
                        element.images = element.images.split(";");
                    });
                    this.products.forEach(element => {
                        element.images.pop();
                    });
                },
                async search() {
                    let form = document.getElementById('search_form');
                    let form_data = new FormData(form);
                    const response = await fetch('{{ route('search') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.products = await response.json();
                        // console.log(this.products);
                        this.products.forEach(element => {
                            element.images = element.images.split(";");
                        });
                        this.products.forEach(element => {
                            element.images.pop();
                        });
                    }
                },
                async filter() {
                    let form = document.getElementById('filter');
                    let form_data = new FormData(form);
                    const response = await fetch('{{ route('filter') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.products = await response.json();
                        this.products.forEach(element => {
                            element.images = element.images.split(";");
                        });
                        this.products.forEach(element => {
                            element.images.pop();
                        });
                    }
                },
                async resetAll() {
                    let form1 = document.getElementById('filter');
                    let form2 = document.getElementById('search_form');
                    const response = await fetch('{{ route('getProducts') }}');
                    this.products = await response.json();
                    this.products.forEach(element => {
                        element.images = element.images.split(";");
                    });
                    this.products.forEach(element => {
                        element.images.pop();
                    });
                    form1.reset();
                    form2.reset();
                },
                async getFavorites() {
                            const responseFav = await fetch('{{ route('getUserFavorites') }}');
                            this.favorites = await responseFav.json();
                            // console.log(this.favorites);
                            this.favorites.forEach(element => {
                                this.favorites_id.push(element.product_id);
                            });
                            console.log(this.favorites_id);
                }

            },
            mounted() {
                this.getProducts();
                this.getFavorites();
            }
        }
        Vue.createApp(app).mount('#catalog');
    </script>
@endsection
