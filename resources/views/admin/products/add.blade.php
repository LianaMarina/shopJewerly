@extends('layout/app')

@section('title')
    Добавление товара
@endsection

@section('content')
    <div class="container" id="addProduct">
        <h2 class="my-5">Добавление товара</h2>
        <div class="col-8 my-5">
            <form enctype="multipart/form-data" id="form_add_product" @submit.prevent="addProduct">
                <div class="mb-3">
                    <label for="title" class="form-label">Введите название товара</label>
                    <input type="text" class="form-control" id="title" name="title" v-model="obj_product.title">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Введите описание товара</label>
                    <textarea class="form-control" id="description" rows="3" name="description" v-model="obj_product.description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Загрузите фото товара</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Введите цену товара</label>
                    <input type="text" class="form-control" id="price" name="price">
                </div>
                {{-- <p>@{{ types }}</p> --}}
                <div class="mb-3">
                    <label for="selectType" class="label-control">Выберите тип товара</label>
                    <select name="type" id="selectType" class="form-control" v-model="selectType">
                        <option v-for="type in types" selected :value="type.id">@{{ type.title }}</option>
                    </select>
                </div>
                {{-- вывод подтипов --}}
                <div class="mb-3">
                    <div v-for="type in types">
                        <div v-for="t in type.subtypes" v-if="type.subtypes">
                            <div v-if="t.type_id===selectType">
                                <input type="radio" name="subtype" :value="t.id"> <span>@{{ t.title }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="selectStone" class="label-control">Выберите вставку товара</label>
                    <select name="stone" id="selectStone" class="form-control">
                        <option v-for="stone in stones" selected :value="stone.id">@{{ stone.title }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectWhom" class="label-control">Выберите для кого товар</label>
                    <select name="whom" id="selectWhom" class="form-control">
                        <option v-for="whom in whomes" selected :value="whom.id">@{{ whom.title }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectCutting" class="label-control">Выберите огранку продукта</label>
                    <select name="cutting" id="selectCutting" class="form-control">
                        <option v-for="cutting in cuttings" selected :value="cutting.id">@{{ cutting.title }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectMaterial" class="label-control">Выберите материал продукта</label>
                    <select name="material" id="selectMaterial" class="form-control">
                        <option v-for="material in materials" selected :value="material.id">@{{ material.title }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectBrand" class="label-control">Выберите бренд продукта</label>
                    <select name="brand" id="selectBrand" class="form-control">
                        <option v-for="brand in brands" selected :value="brand.id">@{{ brand.title }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectBrand" class="label-control">Выберите пробу продукта</label>
                    <select name="sample" id="selectBrand" class="form-control">
                        <option v-for="sample in samples" selected :value="sample.id">@{{ sample.title }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <p>Выберите филиалы, в которые завезут товар</p>
                        <div class="d-flex gap-5" v-for="filial in filials">
                            <label for="filial" class="label-control">
                            <input type="checkbox" id="filials" :name="'filials_size[filials_'+filial.id+'][]'" :value="filial.id" class="form-check-input mx-1">@{{ filial.title }}</label>
                            {{-- вывод размеров --}}
                         <div class="mb-3" v-if="types !== []">
                            <div v-for="type in types">
                                <div v-for="size in type.sizes" v-if="type.sizes">
                                    <div v-if="size.type_id===selectType" class="d-flex gap-3 my-1">
                                        <input type="checkbox" class="form-check-input" :name="'filials_size[filials_'+filial.id+'][sizes][]'" :value="size.id"> <span>@{{ size.number }}</span>
                                        <input type="text" id="count" class="form-control" :name="'filials_size[filials_'+filial.id+'][counts][]'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="" v-if="" v-bind:class="d-none">
                            <div class="d-flex gap-3 my-1">
                                <input type="text" id="count" class="form-control" :name="'filials_size[filials_'+filial.id+'][counts][]'">
                            </div>
                        </div>
                        </div>
                </div>
                <button type="submit" class="btn form-button">Сохранить</button>
            </form>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    message: '',
                    errors: [],

                    //характеристики 
                    types: [],
                    stones: [],
                    whomes: [],
                    cuttings: [],
                    samples: [],
                    materials: [],
                    brands: [],
                    filials: [],
                    selectType: '',

                    obj_product: {
                        title: '', //заголовок продукта
                        description: '', //описание продукта
                        price: 0, //цена товара
                        type: '', //id типа товара
                        subtype: '', //id подтипа товара
                        stone: '', //id камня
                        sample: '',
                        whom: '', //id кому товар
                        cutting: '', //id огранки товара
                        material: '', //id материала товара
                        brand: '', //id бренда товара
                        filials: [
                            // id: '', //id филиала
                            // sizes: [], //размеры для филиала
                            // counts: [], //количества продукта размера
                        ],
                        images: [],
                    }
                }
            },
            methods: {
                async getCharacters() {
                    const response_type = await fetch('{{ route('getTypes') }}');
                    const response_stones = await fetch('{{ route('getStones') }}');
                    const response_whomes = await fetch('{{ route('getWhomes') }}');
                    const response_cuttings = await fetch('{{ route('getCuttings') }}');
                    const response_samples = await fetch('{{ route('getSamples') }}');
                    const response_materials = await fetch('{{ route('getMaterials') }}');
                    const response_brands = await fetch('{{ route('getBrands') }}');
                    const response_filials = await fetch('{{ route('getFilials') }}');

                    this.types = await response_type.json();
                    this.stones = await response_stones.json();
                    this.whomes = await response_whomes.json();
                    this.cuttings = await response_cuttings.json();
                    this.samples = await response_samples.json();
                    this.materials = await response_materials.json();
                    this.brands = await response_brands.json();
                    this.filials = await response_filials.json();
                },
                async addProduct() {
                    // console.log(this.obj_product);
                    let form = document.getElementById('form_add_product');
                    let form_data = new FormData(form);
                    // console.log(title);
                    const response = await fetch('{{ route('addProduct') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: form_data,
                    });
                    // console.log(response);
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        form.reset();
                    }
                    if (response.status === 500) {
                        console.log('ошибка');
                    }
                },
            },
            mounted() {
                this.getCharacters();
            }
        }
        Vue.createApp(app).mount('#addProduct')
    </script>
@endsection
