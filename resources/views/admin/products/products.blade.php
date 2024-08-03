@extends('layout/app')

@section('title')
    Товары
@endsection

@section('content')
    <div class="container" id="products">

        <h5>Поиск</h5>
        <form @submit.prevent="search" class="my-3 d-flex gap-1" id="search_form">
            <input type="text" placeholder="Поиск..." name="search" class="form-control">
            <button class="btn btn-dark" type="submit">Поиск</button>
        </form>
        <h5>Фильтрация</h5>
            <form id="filter" @submit.prevent="filter">
                <div  class="filters d-flex gap-3 flex-wrap">
            <div class="filter">
                    <h6>Тип</h6>
                    <div v-for="type in types">
                        <input type="checkbox" :value="type.id" :id="'type_'+type.id" name="type[]" class="mx-1">
                        <label :for="'type_'+type.id">@{{ type.title }}</label>
                    </div>
            </div>

            <div class="filter">
                <h6>Вставка</h6>
                <div v-for="stone in stones">
                    <input type="checkbox" :value="stone.id" :id="'stone_'+stone.id" name="stone[]" class="mx-1">
                    <label :for="'type_'+stone.id">@{{ stone.title }}</label>
                </div>
            </div>

            <div class="filter">
                <h6>Кому</h6>
                <div v-for="whome in whomes">
                    <input type="checkbox" :value="whome.id" :id="'whome_'+whome.id" name="whome[]" class="mx-1">
                    <label :for="'whome_'+whome.id">@{{ whome.title }}</label>
                </div>
            </div>

            <div class="filter">
                <h6>Огранка</h6>
                <div v-for="cutting in cuttings">
                    <input type="checkbox" :value="cutting.id" :id="'cutting_'+cutting.id" name="cutting[]" class="mx-1">
                    <label :for="'cutting_'+cutting.id">@{{ cutting.title }}</label>
                </div>
            </div>

            <div class="filter">
                <h6>Проба</h6>
                <div v-for="sample in samples">
                    <input type="checkbox" :value="sample.id" :id="'sample_'+sample.id" name="sample[]" class="mx-1">
                    <label :for="'sample_'+sample.id">@{{ sample.title }}</label>
                </div>
            </div>

            <div class="filter">
                <h6>Материал</h6>
                <div v-for="material in materials">
                    <input type="checkbox" :value="material.id" :id="'material_'+material.id" name="material[]" class="mx-1">
                    <label :for="'material_'+material.id">@{{ material.title }}</label>
                </div>
            </div>

            <div class="filter">
                <h6>Бренд</h6>
                <div v-for="brand in brands">
                    <input type="checkbox" :value="brand.id" :id="'brand_'+brand.id" name="brand[]" class="mx-1">
                    <label :for="'brand_'+brand.id">@{{ brand.title }}</label>
                </div>
            </div>
        </div>
        <button class="btn btn-dark" type="submit">Применить</button>
        </form>
        <form @submit.prevent="resetAll" id="resetAll">
            <button type="submit" class="btn m-2" style="text-decoration: underline; padding: 0 !important;">Сбросить все</button>
        </form>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="my-3">Все товары</h2>
            <a href="{{ route('show_add_product_page') }}" class="btn form-button">Создать</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Фото</th>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Характеристики</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products">


                    <th scope="row">@{{ product.id }}</th>
                    <td style="width: 150px">
                        <div :id="'carouselExample' + product.id" class="carousel slide">
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
                    </td>
                    <td>@{{ product.title }}</td>
                    <td>@{{ product.price }}</td>
                    <td>
                        <p v-for="m in materials">
                            <span v-if="m.id === product.material_id">Материал: @{{ m.title }}</span>
                        </p>
                        <p v-for="s in samples">
                            <span v-if="s.id === product.sample_id">Проба: @{{ s.title }}</span>
                        </p>
                        <p v-for="st in stones">
                            <span v-if="st.id === product.stone_id">Камень: @{{ st.title }}</span>
                        </p>
                        <p v-for="cut in cuttings">
                            <span v-if="cut.id === product.cutting_id">Огранка: @{{ cut.title }}</span>
                        </p>
                        <p v-for="w in whomes">
                            <span v-if="w.id === product.whome_id">Кому: @{{ w.title }}</span>
                        </p>
                        <p v-for="type in types">
                            <span v-if="type.id === product.type_id">Тип: @{{ type.title }}</span>
                        </p>
                        <p v-for="subtype in subtypes">
                            <span v-if="subtype.id === product.subtype_id">Подтип: @{{ subtype.title }}</span>
                        </p>
                        <p v-for="brand in brands">
                            <span v-if="brand.id === product.brand_id">Бренд: @{{ brand.title }}</span>
                        </p>
                    </td>
                    <td>
                        {{-- <p>@{{ product.productfilialsizes }}</p> --}}
                        <div v-for="prodfilsize in product.productfilialsizes"> 
                            <p style="font-weight: 500" v-for="filial in filials"><span
                                    v-if="filial.id === prodfilsize.filial_id">@{{ filial.title }}</span>
                            </p>
                            {{-- <p>@{{ prodfilsize.filial_id }}</p> --}}
                            <p v-for="size in sizes"><span
                                    v-if="size.id === prodfilsize.size_id">"@{{ size.number }}"
                                    @{{ prodfilsize.count }} штук</span></p>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                               <!-- Button trigger modal -->
                                <a :href="`{{ route('show_edit_product') }}/${ product.id }`" class="btn btn-success mx-1">Изменить</a>
                                <a :href="`{{ route('deleteProduct') }}/${ product.id }`" class="btn btn-danger mx-1">Удалить</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        const app = {
            data() {
                return {
                    message: '',
                    errors: [],
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

                    const response = await fetch('{{ route('getProducts') }}');
                    this.products = await response.json();
                    this.products.forEach(element => {
                        element.images = element.images.split(";");
                    });
                    this.products.forEach(element => {
                        element.images.pop();
                    });

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
            }, 
            mounted() {
                this.getProducts();
            }
        }
        Vue.createApp(app).mount('#products')
    </script>
@endsection
