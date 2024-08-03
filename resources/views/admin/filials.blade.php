@extends('layout/app')

@section('title')
    Филиалы
@endsection

@section('content')
    <div class="container" id="filials">
        <div class="row">
            <div :class="message ? 'alert alert-success' : ''">
                @{{ message }}
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="my-3">Филиалы</h2>
            <a href="#" class="btn form-button" type="button" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Создать</a>
        </div>

        {{-- Модалка --}}

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Добавление филиала</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="create_filial" id="create_filial">
                    <div class="modal-body">
                        <div :class="message ? 'alert alert-success':''">
                            @{{ message }}
                        </div>
                            <h3>Основные данные</h3>
                            <div class="mb-3">
                                <label for="title" class="form-label">Ввведите название филиала</label>
                                <input type="text" class="form-control" id="title" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div class="invalid-feedback" v-for="error in errors.title">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Ввведите адрес филиала</label>
                                <input type="text" class="form-control" id="address" name="address" :class="errors.address ? 'is-invalid': ''">
                                <div class="invalid-feedback" v-for="error in errors.address">
                                    @{{ error }}
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn form-button">Создать</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Конец модалки --}}

        <div class="content d-flex gap-5 align-items-top">
            <div class="mt-5 col-8">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Наименование и адрес</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="filial in filials" id="block">
                            <th scope="row" class="select_id">@{{ filial.id }}</th>
                            
                                <td>
                                    <form :id="'edit_filial_'+filial.id" @submit.prevent="edit_filial(filial.id)" class="d-flex gap-3">
                                        <input type="text" name="title" style="border: none;" :value="filial.title" :class="errors.title ? 'is-invalid':''">
                                        <div class="invalid-feedback" v-for="error in errors.title">
                                            @{{ error }}
                                        </div>
                                        <input type="text" name="address" style="border: none;" :value="filial.address" :class="errors.address ? 'is-invalid': ''">
                                        <div class="invalid-feedback" v-for="error in errors.address">
                                            @{{ error }}
                                        </div>
                                        <button type="submit" class="btn btn-success mx-2">Изменить</button>
                                    </form>
                                    
                                </td>
                                <td>
                                    <a :href="`{{ route('deleteFilial') }}/${filial.id}`" class="btn btn-dark">Удалить</a>
                                </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



    </div>

    <script>
        const app = {
            data() {
                return {
                    filials: [],
                    errors: [],
                    message: '',
                }
            },
            methods: {
                async getFilials() {
                    const response = await fetch('{{ route('getFilials') }}');
                    this.filials = await response.json();
                },
                async create_filial() {
                    let form = document.getElementById('create_filial');
                    let form_data = new FormData(form);
                    const response = await fetch('{{ route('createFilial') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: form_data,
                    });
                    if(response.status === 400) {
                        this.errors = await response.json();
                    }
                    if(response.status === 200) {
                        this.message = await response.json();
                        this.getFilials();
                        form.reset();
                    }
                },
                async edit_filial(id) {
                    let form = document.getElementById('edit_filial_'+id);
                    let form_data = new FormData(form);
                    form_data.append('id', id);
                    const response = await fetch('{{ route('editFilial') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: form_data,
                    });
                    if(response.status === 400) {
                        this.errors = await response.json();
                    }
                    if(response.status === 200) {
                        this.message = await response.json();
                        this.getFilials();
                    }
                },
            },
            mounted() {
                this.getFilials();
            }
        }
        Vue.createApp(app).mount('#filials');
    </script>
@endsection
