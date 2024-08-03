@extends('layout/app')
@section('title')
    Регистрация
@endsection

@section('content')
    <div id="Registration">
        <div class="container">
            <div :class="message ? 'alert alert-success' : ''">
                @{{ message }}
            </div>
        </div>

        <div class="container" style="display: flex; justify-content:center;">
            <form class="mt-3 mb-5 col-8 p-5 shadow" method="post" id="form_reg" @submit.prevent="Reg">
                <h3 style="font-weight:400" class="my-4">Регистрация</h3>
                <div class="mb-3">
                    <label for="fio" class="form-label">ФИО</label>
                    <input type="text" :class="errors.fio ? 'is-invalid' : ''" class="form-control" value=""
                        id="fio" name="fio">
                    <div class="invalid-feedback" v-for="error in errors.fio">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="email" :class="errors.email ? 'is-invalid' : ''" class="form-control" id="email"
                        name="email">
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
                        name="phone">
                    <div class="invalid-feedback" v-for="error in errors.phone">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Ваш день рождения:</label>
                    <input type="date" :class="errors.birthday ? 'is-invalid' : ''" class="form-control" id="birthday"
                        name="birthday">
                    <div class="invalid-feedback" v-for="error in errors.birthday">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" :class="errors.rule ? 'is-invalid' : ''" class="form-check-input"
                        id="exampleCheck1" name="rule">
                    <label class="form-check-label" for="exampleCheck1">Согласие на обработку данных</label>
                    <div class="invalid-feedback" v-for="error in errors.rule">
                        @{{ error }}
                    </div>
                </div>
                <button type="submit" class="btn form-button">Зарегистрироваться</button>
            </form>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors: [],
                    message: '',
                }
            },
            methods: {
                async Reg() {
                    let form = document.getElementById('form_reg');
                    let form_data = new FormData(form);
                    const response = await fetch('{{ route('registration') }}', {
                        method: 'post',
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
                    }
                    if (response.status == 500) {
                        console.log("Ошибка 500")
                    }
                }
            },
        };
        Vue.createApp(app).mount('#Registration');
    </script>
@endsection
