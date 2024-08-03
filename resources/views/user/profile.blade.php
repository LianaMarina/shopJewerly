@extends('layout/app')

@section('title')
    Профиль usera
@endsection

@section('content')
<style>
    .info_user {

    }
    a {
        color: black;
    }
    span {
        font-weight: 500;
    }
</style> 
<div class="container" id="profile">
    <div :class="message ? 'alert alert-success' : ''">
        @{{ message }}
    </div>
    <div class="info_user shadow p-5">
        <h4 class="mb-5">Добро пожаловать, @{{ user.fio }}</h4>
        <div class="d-flex justify-content-between">
            <div class="col-6 py-3">
                <p><span>Почта: </span>@{{ user.email }}</p>
                <p><span>Телефон: </span>@{{ user.phone }}</p>
                <p v-if="user.birthday"><span>День рождения: </span>@{{ user.birthday.split('-').reverse().join('.') }}</p>
            </div>
            <div class="col-6">
                <hr>
                    <a style="padding-left: 35px;" href="{{ route('show_my_active_orders') }}">Мои заказы</a>
                <hr> 
                    <a style="padding-left: 35px;" href="{{ route('show_my_history_orders') }}">История заказов</a>
                <hr>
            </div>
        </div>
        <div class="col-12 d-flex gap-5">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item mt-4">
                  <h2 class="accordion-header" id="headingOne">
                    <button style="background-color: black; color: white;" class="accordion-button btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      Редактировать информацию
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body" style="background-color: #ebe7dd;">
                        <form class="mt-3 mb-5 p-2" method="post" id="form_edit" @submit.prevent="EditInf">
                            <div class="mb-3">
                                <label for="fio" class="form-label">ФИО</label>
                                <input type="text" :class="errors.fio ? 'is-invalid' : ''" class="form-control" :value="user.fio"
                                    id="fio" name="fio">
                                <div class="invalid-feedback" v-for="error in errors.fio">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">email</label>
                                <input type="email" :class="errors.email ? 'is-invalid' : ''" class="form-control" id="email"
                                    name="email" :value="user.email">
                                <div class="invalid-feedback" v-for="error in errors.email">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль:</label>
                                <input type="password" :class="errors.password ? 'is-invalid' : ''" class="form-control" id="password"
                                    name="password">
                                <div class="invalid-feedback" v-for="error in errors.password">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmed" class="form-label">Введите пароль еще раз:</label>
                                <input type="password" :class="errors.password ? 'is-invalid' : ''" class="form-control"
                                    id="password_confirmation" name="password_confirmation">
                                <div class="invalid-feedback" v-for="error in errors.password">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Номер телефона:</label>
                                <input type="phone" :class="errors.phone ? 'is-invalid' : ''" class="form-control" id="phone"
                                    name="phone" :value="user.phone">
                                <div class="invalid-feedback" v-for="error in errors.phone">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Ваш день рождения:</label>
                                <input type="date" :class="errors.birthday ? 'is-invalid' : ''" class="form-control" id="birthday"
                                    name="birthday" :value="user.birthday">
                                <div class="invalid-feedback" v-for="error in errors.birthday">
                                    @{{ error }}
                                </div>
                            </div>
                            <button type="submit" class="btn form-button">Сохранить</button>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
              <a style="margin-top: 35px; color: rgb(151, 0, 0);" href="{{ route('delete_my_accaunt') }}">Удалить аккаунт</a>
        </div>
    </div> 
 </div>
 <script>
    const app = {
        data() {
            return {
                errors: [],
                message: '',
                user: [],
            }
        },
        methods: {
            async getData() {
                const response = await fetch('{{ route('getUserInf') }}');
                this.user = await response.json();
                console.log(this.user);
            },
            async EditInf() {
                let form = document.getElementById('form_edit');
                    let form_data = new FormData(form);
                    form_data.append('id', this.user.id);
                    const response = await fetch(`{{ route('editUserInf') }}`, {
                        method: 'put',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: form_data,
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 10000);
                    }
                    if (response.status === 200) {
                        this.message = await response.json();
                        form.reset();
                        setTimeout(() => {
                            this.message = '';
                        }, 10000);
                        this.getData();
                    }
            }
        },
        mounted() {
            this.getData();
        }
    }
    Vue.createApp(app).mount('#profile');
 </script>
@endsection