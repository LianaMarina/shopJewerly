@extends('layout/app')
@section('title')
    Авторизация
@endsection

@section('content')
    <div id="Authent">
        <div class="container">
            <div :class="message ? 'alert alert-success' : ''">
                @{{ message }}
            </div>
            <div :class="error ? 'alert alert-danger' : ''">
                @{{ error }}
            </div>
        </div>
        <div class="container" style="display: flex; justify-content:center;">
            <form class="mt-3 mb-5 col-5 p-5 shadow" method="post" id="form_auth" @submit.prevent="Auth">
            <h3 style="font-weight:400" class="my-4">Вход</h3>
                <div class="mb-3">
                    <label for="email" class="form-label">Почта</label>
                    <input type="email" :class="errors.email ? 'is-invalid' : ''" class="form-control" id="email"
                        name="email">
                    <div class="invalid-feedback" v-for="error in errors.email">
                        @{{ error }}
                    </div>
                </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" :class="errors.password ? 'is-invalid' : ''" class="form-control"
                            id="password" name="password">
                        <div class="invalid-feedback" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn form-button">Войти</button>
            </form>
        </div>
    </div>

    <script>
        const app = {
            data() {
                return {
                    errors: [],
                    message: '',
                    error: '',
                }
            },
            methods: {
                async Auth() {
                    let form = document.getElementById('form_auth');
                    let form_data = new FormData(form);
                    const response = await fetch('{{ route('auth') }}', {
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
                        setTimeout(()=>{
                            this.message = '';
                        }, 10000);
                        window.location = '{{ route('show_user_profile') }}';
                        // if(auth()->user()->role == 0) {
                        //     
                        // } else {
                        //     window.location = '{{ route('show_admin_profile') }}';
                        // }
                    }
                    if(response.status == 401) {
                        this.error = await response.json();
                        setTimeout(()=>{
                            this.error = '';
                        }, 10000);
                    }
                }
            }
        }
        Vue.createApp(app).mount('#Authent');
    </script>
@endsection
