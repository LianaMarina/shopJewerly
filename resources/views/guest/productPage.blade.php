@extends('layout/app')

@section('title')
    Страница подробнее о товаре
@endsection

@section('content')
    <style>
        .carousel-indicators img {
            width: 70px;
            display: block;
        }

        .carousel-indicators button {
            width: max-content !important;
        }

        .carousel-indicators {
            position: unset;
        }

        .btn-in-cart {
            border: solid 1px rgb(102, 86, 53);
            color: white;
            padding: 10px 0;
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
    <div class="container my-5" id="more_details_product">
        @if (session()->has('success_add_cart'))
            <div class="alert alert-success" id="success-message">
                {{ session('success_add_cart') }}
            </div>
        @endif
        <div :class="message ? 'alert alert-success' : ''">
            @{{ message }}
        </div>
        <div class="d-flex gap-5">
            <div class="col-5">
                <div class="carousel slide" id="carouselProductPhoto" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item" :class="index == 0 ? 'active' : ''"
                            v-for="(img, index) in product.images">
                            <img :src="'/public' + img" alt="" class="w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductPhoto"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProductPhoto"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <div class="carousel-indicators">
                        <button v-for="(image, index) in product.images" :key="index"
                            :data-bs-target="'#carouselProductPhoto'" :data-bs-slide-to="index"
                            :class="index === 0 ? 'active' : ''">
                            <img :src="'/public' + product.images[index]" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <h4 style="font-family: 'Oswald'; font-size: 35px; font-weight:300;">@{{ product.product_title }}</h4>
                <p style="color: #6e6b64; font-weight:800;" class="pt-2 pb-2">@{{ product.type }}</p>
                <div>
                    <p style="color: #000000; font-weight:500; font-size: 23px;" class="pt-2 pb-3">@{{ product.price }} Р
                    </p>
                    <div class="">
                        @auth
                            <div class="d-flex gap-2 align-items-center">
                                <a :href="`{{ route('add_product_cart') }}/${ product.product_id }`" style="border-radius: 0px;"
                                    class="btn btn-in-cart px-5">В корзину <i class="bi bi-cart"></i></a>
                                <a v-if="product.isFavorite===true"
                                    :href="`{{ route('add_product_favorite') }}/${ product.product_id }`"
                                    class="btn btn-in-fav"><i class="bi bi-heart"></i></a>
                                <a :href="`{{ route('add_product_favorite') }}/${ product.product_id }`" v-else
                                    class="btn"><i class="bi bi-heart"></i></a>
                            </div>
                        @endauth
                    </div>
                    <div class="mt-5 col-12">
                        <h5 style="font-family: 'Oswald';">Наличие</h5>
                        <hr>
                        <div class="d-flex jsutify-content-between col-12" v-for="prod_fil_size in product.filial_sizes">
                            <div>
                                <p class="px-2" style="font-weight: 500;"><i class="bi bi-brightness-low"></i>
                                    @{{ prod_fil_size.filial_name }}</p>
                            </div>
                            <p v-if="prod_fil_size.size_title" class="px-2"> <span>Размер: </span> @{{ prod_fil_size.size_title }}
                            </p>
                        </div>
                        <hr>
                    </div>
                    <div class="p-5 my-5 shadow " style="font-family: 'Oswald;'">
                        <div class="d-flex gap-5">
                            <h5 style="font-family: 'Oswald';">Характеристики</h5>
                            <div class="">
                                <p><span style="font-weight: 500;">Материал: </span>@{{ product.material }}</p>
                                <p><span style="font-weight: 500;">Проба: </span>@{{ product.sample }}</p>
                                <p><span style="font-weight: 500;">Вставка: </span>@{{ product.stone }}</p>
                            </div>
                            <div class="">
                                <p><span style="font-weight: 500;">Огранка: </span>@{{ product.cutting }}</p>
                                <p><span style="font-weight: 500;">Кому: </span>@{{ product.whome }}</p>
                                <p><span style="font-weight: 500;">Бренд: </span>@{{ product.brand }}</p>
                                <p v-if="product.subtype"><span style="font-weight: 500;">Подтип:
                                    </span>@{{ product.subtype }}</p>
                            </div>
                        </div>
                        <p class="d-inline-flex gap-1" style="background-color:#ebe7dd !important;">
                            <a class="btn" data-bs-toggle="collapse" href="#collapseExample"
                                style="font-weight: 500; font-size: 20px; text-decoration:underline;" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                Описание
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="">
                                @{{ product.product_description }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="review" style="">
            <div class="col-12 d-flex align-items-center gap-5">
                <h4>Отзывы</h4>
                <a v-if="product.isOrder" href="#" class="btn btn-in-cart px-3 py-1" data-bs-toggle="modal" data-bs-target="#exampleModal" style="border: none;">Создать <i
                        class="bi bi-plus"></i></a>
                <!-- Button trigger modal -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Создание отзыва</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addReview" @submit.prevent="addReview" method="post">
                                    <div class="mb-3">
                                      <label for="pluses" class="form-label">Плюсы</label>
                                      <textarea type="text" class="form-control" id="pluses" name="positive"></textarea>
                                    </div>
                                    <div class="mb-3">
                                      <label for="minuses" class="form-label">Минусы</label>
                                      <textarea type="text" class="form-control" id="minuses" name="negative"></textarea>
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-check-label" for="text">Ваш отзыв</label>
                                      <textarea type="text" class="form-control" id="text" name="text"></textarea>
                                    </div>
                                <button type="submit" class="btn" style="border: solid 1px black;">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="reviews_card" v-for="review in reviews">
                    <hr>
                    <div class="my-2 p-4" style="background-color: #ebe7dd; position: relative;">
                        <p style="font-weight: 500; font-size: 20px;">@{{ review.user_name }}</p>
                        <p v-if="review.positive"><span style="font-weight: 500;">Плюсы: </span>@{{ review.positive }}</p>
                        <p v-if="review.negative"><span style="font-weight: 500;">Минусы: </span>@{{ review.positive }}</p>
                        <p v-if="review.text">@{{ review.text }}</p>
                        <a v-if="review.my" :href="`{{ route('delete_my_review') }}/${review.id}`" class="btn" style="background-color:#c3b091; position:absolute; top: 10px; right: 20px;"> <i class="bi bi-trash"></i></a>
                    </div>
                    <hr>
                </div>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors: [],
                    message: '',
                    id: {{ $id }},
                    product: [],
                    filials: [],
                    subtypes: [],
                    sizes: [],
                    reviews: [],
                    reviews_user: [],
                }
            },
            methods: {
                async getData() {
                    console.log(this.user);
                    const response = await fetch(`{{ route('get_more_details_product') }}/${this.id}`);
                    this.product = await response.json();
                    this.product.images = this.product.images.split(";");
                    this.product.images.pop();

                    const response_filials = await fetch('{{ route('getFilials') }}');
                    this.filials = await response_filials.json();
                    console.log(this.filials);

                    this.product.filial_sizes.forEach(element => {
                        this.filials.forEach(item => {
                            if (item.id === element.filial_id) {
                                element.filial_name = item.title;
                            }
                        })
                    });
                    const response_sizes = await fetch('{{ route('getSizes') }}');
                    this.sizes = await response_sizes.json();
                    console.log(this.sizes);
                    this.product.filial_sizes.forEach(element => {
                        this.sizes.forEach(item => {
                            if (item.id === element.size_id) {
                                element.size_title = item.number;
                            }
                        })
                    });
                    // console.log(this.product);
                    // Получить все отзывы для данного продукты
                    console.log(this.product.product_id);
                    const responseReviews = await fetch(`{{ route('getReviews') }}/${this.id}`);
                    this.reviews = await responseReviews.json();

                    const responseReviewsUser = await fetch(`{{ route('getReviewsUser') }}/${this.id}`);
                    this.reviews_user = await responseReviewsUser.json();
                    this.reviews.forEach(element => {
                        this.reviews_user.forEach(item => {
                            if (item.user_id === element.user_id) {
                                element.my = 'true';
                            }
                        })
                    });
                    console.log(this.reviews);
                    console.log(this.product);
                },
                async addReview() {
                    let form = document.getElementById('addReview');
                    let form_data = new FormData(form);
                    form_data.append('id', this.product.product_id);
                    const responseAddReview = await fetch('{{ route('addReview') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: form_data,
                    });
                    if(responseAddReview.status == 400) {
                        this.errors = await responseAddReview.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 10000);
                    }
                    if(responseAddReview.status == 200) {
                        this.message = await responseAddReview.json();
                        setTimeout(() => {
                            this.message = '';
                        });
                        form.reset();
                    }
                },
            },
            mounted() {
                this.getData();
            }
        }
        Vue.createApp(app).mount('#more_details_product');

        let successMessage = document.getElementById('success-message');

        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 5000);
    </script>
@endsection
