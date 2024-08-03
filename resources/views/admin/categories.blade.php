@extends('layout/app')

@section('title')
    Характеристики
@endsection

@section('content')
<style>
    a {
        color: black;
    }
</style>
    <div class="container" id="categories">
        <div class="row">
            <div :class="message? 'alert alert-success':''">
                @{{ message }}
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
           <h2 class="my-3">Все характеристики</h2> 
           <a href="#" class="btn form-button" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Создать</a>
        </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Создание новой характеристики</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="post" @submit.prevent="save" id="form">
            <div class="row">
                <div :class="message? 'alert alert-success':''">
                    @{{ message }}
                </div>
            </div>
          <h3>Основные данные</h3>
          <label for="selectCategories" class="label-control">Выберите вид характеристики</label>
          <select name="select" id="select" class="form-control" v-model="select_character" :change="check_character_select">
          <option value="0">Тип</option>
          <option value="1">Вставки</option>
          <option value="2">Огранка</option>
          <option value="3">Проба</option>
          <option value="4">Кому</option>
          <option value="5">Материал</option>
          <option value="6">Бренд</option>
        </select>
        <div class="mb-3">
            <label for="title" class="form-label">Ввведите название характеристики</label>
            <input type="text" class="form-control" id="title" name="title" :class="errors.title ? 'is-invalid':''">
            <div class="invalid-feedback" v-for="error in errors.title">
                @{{ error }}
            </div>
          </div>
          <div class="row">
            <h4>Связанные характеристики (если есть)</h4>
          </div>
          <div class="row">
            <div class="col-6">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="status" v-model="yes_subtypes" :change="add_subtypes">
                    <label for="status" class="form-check-label">Есть подтип?</label>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="size"  v-model="yes_sizes" :change="add_sizes">
                    <label for="size" class="form-check-label">Есть размерный ряд?</label>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
                <div class="d-none" id="inputs_subtypes">
                    <button type="button" class="btn form-button" @click="add_subtype_input">+ добавить подтип</button>
                    <label for="subtype" class="form-check-label">Введите подкатегорию</label>
                    <input type="text" class="form-control my-2" id="subtype" v-for="subtype in subtypes_new" name="subtypes[]">
                </div>
            </div>
            <div class="col-6">
                <div class="d-none" id="inputs_sizes">
                    <button type="button" class="btn form-button" @click="add_size_input">+ добавить размер</button>
                    <label for="size_enter" class="form-check-label">Введите размеры</label>
                    <input type="text" class="form-control my-2" id="size_enter" v-for="size in sizes_new" name="sizes[]">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn form-button" @click="save">Создать</button>
        </div>
    </form>
      </div>
    </div>
  </div>

{{-- Страница --}}
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('type')">Тип</button>
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('stone')">Вставки</button>
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('cutting')">Огранка</button>
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('sample')">Проба</button>
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('whome')">Кому</button>
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('material')">Материал</button>
            <button class="btn btn-dark col-1 btn-category" @click="setCharacter('brand')">Бренд</button>
        </div>
        <div class="content d-flex gap-5 align-items-top">
        <div class="mt-5 col-8">
            <table class="table table-light">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Наименования</th>
                    <th scope="col">Доп.характеристики</th>
                    <th scope="col">Действия</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="char in data" id="block">
                    <th scope="row" class="select_id">@{{ char.id }}</th>
                    <td>
                        <form @submit.prevent="update_char(char.id)" :id="'change_char'+char.id">
                        <input type="text" name="title" style="border: none;" :value="char.title" :class="errors.title ? 'is-invalid':''">
                        <div class="invalid-feedback" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                        <button type="submit" class="btn btn-success mx-2">Изменить</button>
                        </form>
                    </td>
                    {{-- <td class="select_type">@{{ char.title }}</td> --}}
                    <td v-if="(char.subtypes && char.subtypes.length > 0) || (char.sizes && char.sizes.length > 0)" class="find">
                        {{-- <p>@{{ char.subtypes }}</p> --}}
                        <a class="sub_dop mx-2" href="#" @click="show_dop_sub($event.target, char.id, char.title, char.subtypes)" v-if="char.subtypes.length != 0">Подтип</a>
                        <a href="#" class="size_dop mx-2" @click="show_dop_sizes($event.target, char.id, char.title, char.sizes)" v-if="char.sizes.length != 0">Размер</a>
                    </td>
                    <td v-else class="d-flex align-items-center gap-2">
                        <p>Нет</p>
                        <button v-if="select_character === 'type'" class="btn btn-dark" @click="show_dop_sub($event.target, char.id, char.title, char.subtypes)" style="text-decoration: none;" class="size_dop">+</button>
                    </td>
                    <td>
                        <a :href="`{{route('deleteCharacters')}}/${ char.id }/${select_character}`" class="btn btn-dark">Удалить</a>
                    </td>
                  </tr>
                </tbody>
              </table>
        </div>
        <div class="show_subtypes d-none col-4 mt-5 p-3" style="background: rgb(247, 247, 247); position: relative;">
            <h5 class="mb-3">Подтипы</h5>
            <div v-for="char in data">
                <button @click="close_show_dop_sub" type="button" class="btn-close" data-bs-dismiss="show_subtypes" aria-label="Close" style="position: absolute; top:10px; right:10px;"></button>
                <div class="d-flex gap-5 my-2" v-for="sub in char.subtypes">
                    <div class="d-flex gap-3" v-if="char.title == obj_char.title">
                        @{{ select_type }}
                        <form @submit.prevent="update_subtype(sub.id)" class="d-flex gap-1" :id="'change_sub_'+sub.id">
                        <input type="text" name="title" style="border: none;" :value="sub.title" :class="errors.title ? 'is-invalid':''">
                        <div class="invalid-feedback" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                        <button type="submit" class="btn btn-success">Изменить</button>
                    </form>
                    <form @submit.prevent="delete_sub(sub.id)" id="del_sub">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-secondary" @click="open_form_create_new_subchar_subtype">Создать</button>
            <div>
                <div class="row mt-5 d-none" id="form_create_newSubchar_for_subtype">
                    <div class="col-12">
                        <div class="row" style="position: relative;">
                            <div class="col-10"><h5>Создание новой подхарактеристики</h5></div>
                            <div class="col-2" style="position: absolute; top: 0px; right: 3px;">
                                <button @click="close_form_create_new_subchar_subtype" type="button" class="btn-close"  style="position: absolute; top:10px; right:10px;"></button>
                            </div>
                        </div>
                        <form id="form_new_subcharacter_subtype" method="post" class="row mt-2" @submit.prevent="savaNewSubtypeOrSize_subtype(obj_char.id_char)">
                            <div class="row mb-1">
                                <div class="col-12">
                                    <select name="what_create_subtype" id="what_create_subtype" class="form-select">
                                        <option value="subtype">Подтип</option>
                                        <option value="size">Размер</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8"><input type="text" name="name" class="form-control" placeholder="Введите новое значение"></div>
                                <div class="col-4"><button class="btn col-12 btn-success" type="submit">Сохранить</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="show_sizes d-none col-4 mt-5 p-3" style="background: rgb(247, 247, 247); position: relative;">
            <h5 class="mb-3">Размеры</h5>
            <div v-for="char in data">
                <button @click="close_show_dop_size" type="button" class="btn-close" data-bs-dismiss="show_subtypes" aria-label="Close" style="position: absolute; top:10px; right:10px;"></button>
                <div class="d-flex gap-5 my-2" v-for="sub in char.sizes">
                    <div class="d-flex gap-3" v-if="char.title == obj_char.title">
                        <form class="d-flex gap-1" @submit.prevent="update_size(sub.id)" :id="'change_size_'+sub.id">
                            <input type="text" name="number" style="border: none;" :value="sub.number" :class="errors.number ? 'is-invalid':''">
                            <div class="invalid-feedback" v-for="error in errors.number">
                                @{{ error }}
                            </div>
                        <button type="submit" class="btn btn-success">Изменить</button>
                    </form>
                    <form @submit.prevent="delete_size(sub.id)" id="del_size">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                    </div>
                    
                </div>
            </div>
            <button class="btn btn-outline-secondary" @click="open_form_create_new_subchar_size">Создать</button>
            <div class="row mt-5 d-none" id="form_create_newSubchar_for_size">
                <div class="col-12">
                    <div class="row" style="position: relative;">
                        <div class="col-10"><h5>Создание новой подхарактеристики</h5></div>
                        <div class="col-2" style="position: absolute; top: 0px; right: 3px;">
                            <button @click="close_form_create_new_subchar_size" type="button" class="btn-close"  style="position: absolute; top:10px; right:10px;"></button>
                        </div>
                    </div>
                    <form id="form_new_subcharacter_size" method="post" class="row mt-2" @submit.prevent="savaNewSubtypeOrSize_size(obj_char.id_char)">
                        <div class="row mb-1">
                            <div class="col-12">
                                <select name="what_create_size" id="what_create_size" class="form-select">
                                    <option value="subtype">Подтип</option>
                                    <option value="size">Размер</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8"><input type="text" name="name" class="form-control" placeholder="Введите новое значение"></div>
                            <div class="col-4"><button class="btn col-12 btn-success" type="submit">Сохранить</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        const app = {
            data() {
                return {

                    types: [],
                    stones: [],
                    whoms: [],
                    cuttings: [],
                    samples: [],
                    materials: [],
                    brands: [],


                    errors: [], 
                    message: '',

                    select_character: 0,

                    yes_subtypes: 0, //чекбокс, есть ли подтип
                    yes_sizes: 0, //чекбокс, есть ли размер

                    subtypes_new: [],
                    sizes_new: [],  

                    data: [],

                    show_subtypes: false,
                    show_sizes: false,

                    select_type: '', //для какого типа выводить данные

                    obj_char: {
                        id_char: 0, //id типа
                        title: '', //название типа
                        relation: [], // подтипы и размеры
                    }
                }
            },
            methods: {
                async getCategories() {
                    const response_type = await fetch('{{ route('getTypes') }}');
                    const response_stones = await fetch('{{ route('getStones') }}');
                    const response_whomes = await fetch('{{ route('getWhomes') }}');
                    const response_cuttings = await fetch('{{ route('getCuttings') }}');
                    const response_samples = await fetch('{{ route('getSamples') }}');
                    const response_materials = await fetch('{{ route('getMaterials') }}');
                    const response_brands = await fetch('{{ route('getBrands') }}');

                    this.types = await response_type.json();
                    this.stones = await response_stones.json();
                    this.whomes = await response_whomes.json();
                    this.cuttings = await response_cuttings.json();
                    this.samples = await response_samples.json();
                    this.materials = await response_materials.json();
                    this.brands = await response_brands.json();

                    this.data = this.types;
                    this.select_character = 'type';
                },
                close_form_create_new_subchar_subtype() {
                    let form = document.getElementById('form_create_newSubchar_for_subtype');
                    form.classList.add('d-none');
                },
                open_form_create_new_subchar_subtype() {
                    let form = document.getElementById('form_create_newSubchar_for_subtype');
                    form.classList.remove('d-none');
                },
                close_form_create_new_subchar_size() {
                    let form = document.getElementById('form_create_newSubchar_for_size');
                    form.classList.add('d-none');
                },
                open_form_create_new_subchar_size() {
                    let form = document.getElementById('form_create_newSubchar_for_size');
                    form.classList.remove('d-none');
                },
                setCharacter(preset) {
                    switch(preset) {
                        case 'type':
                            this.data = this.types;
                            this.select_character = 'type';
                            return this.data;
                        case 'stone':
                            this.data = this.stones;
                            this.select_character = 'stone';
                            return this.data;
                        case 'whome': 
                            this.data = this.whomes;
                            this.select_character = 'whome';
                            return this.data;
                        case 'cutting': 
                            this.data = this.cuttings;
                            this.select_character = 'cutting';
                            return this.data;
                        case 'sample': 
                            this.data = this.samples;
                            this.select_character = 'sample';
                            return this.data;
                        case 'material': 
                            this.data = this.materials;
                            this.select_character = 'material';
                            return this.data;
                        case 'brand': 
                            this.data = this.brands;
                            this.select_character = 'brand';
                            return this.data;
                    }
                },
                add_subtype_input() {
                    this.subtypes_new.push('');
                },
                add_size_input() {
                    this.sizes_new.push('');
                },
                async save() {
                    console.log(this.check_character_select);
                    let form = document.getElementById('form');
                    let data = new FormData(form);
                    const response = await fetch(this.check_character_select, {
                        method: 'post', 
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        form.reset();
                        this.subtypes_new = [];
                        this.sizes_new = [];
                        this.getCategories();
                    }
                },
                close_show_dop_sub() {
                    let show_sub = document.querySelector('.show_subtypes');
                    show_sub.classList.add('d-none');
                },
                close_show_dop_size() {
                    let show_size = document.querySelector('.show_sizes');
                    show_size.classList.add('d-none');
                },
                show_dop_sub(event, id, title, subtypes) {
                    this.obj_char.id_char = id;
                    this.obj_char.title = title;
                    this.obj_char.relation = subtypes;
                    let show_sub = document.querySelector('.show_subtypes');
                    show_sub.classList.toggle('d-none');
                    let show_size = document.querySelector('.show_sizes');
                    if(!show_size.classList.contains('d-none')) {
                        show_size.classList.add('d-none');
                    }
                    let form = document.getElementById('form_create_newSubchar_for_subtype');
                    form.classList.add('d-none');
                    // let find = event.closest('.find').closest('#block');
                    // this.select_type = find.querySelector('.select_type').textContent;
                    // console.log(this.select_type);

                },
                show_dop_sizes(event, id, title, sizes) {
                    this.obj_char.id_char = id;
                    this.obj_char.title = title;
                    this.obj_char.relation = sizes;
                    let show_size = document.querySelector('.show_sizes');
                    show_size.classList.toggle('d-none');
                    let show_sub = document.querySelector('.show_subtypes');
                    if(!show_sub.classList.contains('d-none')) {
                        show_sub.classList.add('d-none');
                    }
                    // let find = event.closest('.find').closest('#block');
                    // this.select_type = find.querySelector('.select_type').textContent;
                    // console.log(this.select_type);
                },

                async update_subtype(sub) {
                    let form = document.getElementById('change_sub_'+sub);

                    let form_data = new FormData(form);
                    form_data.append('id', sub);
                    console.log(form);
                    const response = await fetch('{{ route('edit_subtype') }}', {
                        method: 'post', 
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        this.getCategories();
                        setTimeout(()=>{
                            let global_type = this.types.find(elem=>elem.id===this.obj_char.id_char);
                            this.types = global_type;
                        }, 1500);
                    }
                    if (response.status === 500) {
                        console.log('ошибка');
                    }
                }, 
                async update_size(size) {
                    let form = document.getElementById('change_size_'+size);

                    let form_data = new FormData(form);
                    form_data.append('id', size);
                    const response = await fetch('{{ route('edit_size') }}', {
                        method: 'post', 
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        this.getCategories();
                        setTimeout(()=>{
                            let global_type = this.types.find(elem=>elem.id===this.obj_char.id_char);
                            this.types = global_type;
                        }, 1500);
                    }
                    if (response.status === 500) {
                        console.log('ошибка');
                    }
                }, 
                //Изменение глобальной характеристики
                async update_char(id) {
                    let form = document.getElementById('change_char'+id);
                    let form_data = new FormData(form);
                    form_data.append('id', id);
                    let route = '';
                    // console.log(this.select_character);
                    switch (this.select_character) {
                        case 'type':
                            route = '{{ route('editType') }}';
                            break;
                        case 'stone':
                            route = '{{ route('editStone') }}';
                            break;
                        case 'cutting':
                            route = '{{ route('editCutting') }}';
                            break;
                        case 'sample':
                            route = '{{ route('editSample') }}';
                            break;
                        case 'whome':
                            route = '{{ route('editWhome') }}';
                            break;
                        case 'material':
                            route = '{{ route('editMaterial') }}';
                            break;
                        case 'brand':
                            route = '{{ route('editBrand') }}';
                            break;
                    }
                    console.log(route);
                    const response = await fetch(route, {
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
                        this.message = await response.json();
                        this.getCategories();
                        setTimeout(()=>{
                            let global_type = this.types.find(elem=>elem.id===this.obj_char.id_char);
                            this.types = global_type;
                        }, 1500);
                    }
                },
// Добавление подхарактеристики в окне с подтипами
                async savaNewSubtypeOrSize_subtype(id) {
                    console.log(id);
                    let form = document.getElementById('form_new_subcharacter_subtype');
                    console.log(form);
                    let select = document.getElementById('what_create_subtype');
                    let data = new FormData(form);
                    data.append('id', id);
                    let route = '';
                    if(select.value==='subtype') {
                        route = '{{ route('saveSubtype') }}';
                    } else if(select.value==='size') {
                        route = '{{ route('saveSize') }}';
                    }
                    const response = await fetch(route, {
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: data,
                    });
                    if(response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors=[];
                        }, 10000);
                    }
                    if(response.status === 200) {
                        this.message = await response.json();
                        this.getCategories();
                        setTimeout(()=>{
                            this.message = '';
                        }, 10000);
                        setTimeout(()=>{
                            let global_type = this.types.find(elem=>elem.id===this.obj_char.id_char);
                            this.types = global_type;
                        }, 1500);
                        form.reset();
                    }
                },
//создание подхарактеристики в окне с размерами
                async savaNewSubtypeOrSize_size(id) {
                    console.log(id);
                    let form = document.getElementById('form_new_subcharacter_size');
                    console.log(form);
                    let select = document.getElementById('what_create_size');
                    let data = new FormData(form);
                    data.append('id', id);
                    let route = '';
                    if(select.value==='subtype') {
                        route = '{{ route('saveSubtype') }}';
                    } else if(select.value==='size') {
                        route = '{{ route('saveSize') }}';
                    }
                    const response = await fetch(route, {
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: data,
                    });
                    if(response.status === 400) {
                        this.message = await response.json();
                        setTimeout(()=>{
                            this.errors=[];
                        }, 10000);
                    }
                    if(response.status === 200) {
                        this.message = await response.json();
                        this.getCategories();
                        setTimeout(()=>{
                            this.message = '';
                        }, 10000);
                        setTimeout(()=>{
                            let global_type = this.types.find(elem=>elem.id===this.obj_char.id_char);
                            this.types = global_type;
                        }, 1500);
                        form.reset();
                    }
                },

                async delete_sub(sub) {
                    let form = document.getElementById('del_sub');
                    let form_data = new FormData(form);
                    form_data.append('id', sub);
                    console.log(sub);
                    const response = await fetch('{{ route('delete_sub') }}', {
                        method: 'post', 
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}' 
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        this.getCategories();
                    }
                    if (response.status === 500) {
                        console.log('ошибка');
                    }
                },
                
                async delete_size(size) {
                    let form = document.getElementById('del_size');
                    let form_data = new FormData(form);
                    form_data.append('id', size);
                    console.log(size);
                    const response = await fetch('{{ route('del_size') }}', {
                        method: 'post', 
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}' 
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        this.getCategories();
                    }
                    if (response.status === 500) {
                        console.log('ошибка');
                    }
                }
            },
            computed: {
                check_character_select() {
                    switch (parseInt(this.select_character)) {
                        case 0:
                            return '{{ route('typesSave') }}'
                        case 1:
                            return '{{ route('stonesSave') }}'
                        case 2:
                            return '{{ route('cuttingsSave') }}'
                        case 3:
                            return '{{ route('samplesSave') }}'
                        case 4: 
                            return '{{ route('whomsSave') }}'
                        case 5:
                            return '{{ route('materialsSave') }}'
                        case 6:
                            return '{{ route('brandsSave') }}'
                    }
                }, 
                add_subtypes() {
                    if(this.yes_subtypes===true) {
                        document.getElementById('inputs_subtypes').classList.remove('d-none');
                        this.subtypes_new.push('');
                    }
                    if(this.yes_subtypes===false) {
                        document.getElementById('inputs_subtypes').classList.add('d-none');
                        this.subtypes_new = [];
                    }
                },
                add_sizes() {
                    if(this.yes_sizes===true) {
                        document.getElementById('inputs_sizes').classList.remove('d-none');
                        this.sizes_new.push('');
                    }
                    if(this.yes_sizes===false) {
                        document.getElementById('inputs_sizes').classList.add('d-none');
                        this.sizes_new=[];
                    }
                },
            },
            mounted() {
                this.getCategories();
            }
        }
        Vue.createApp(app).mount('#categories')
    </script>
@endsection