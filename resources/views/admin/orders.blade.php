@extends('layout/app')

@section('title')
    Все заказы
@endsection

@section('content')
    <div class="container" id="allOrders">
        <div :class="message ? 'alert alert-success' : ''">
            @{{ message }}
        </div>
        <h2 class="my-5">Все заказы</h2>
        <div class="col-12">
            <table class="table table-light" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">Номер</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Адрес</th>
                        <th scope="col">Дата начала</th>
                        <th scope="col">Дата окончания</th>
                        <th scope="col">Комментарий</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in allOrders">
                        <th scope="row"><button class="btn">@{{ index + 1 }}</button></th>
                        <td>@{{ order.user.fio }}</td>
                        <td>
                                <p style="font-weight: 500;">@{{ order.filial.title }}</p>
                                <p>@{{ order.filial.address }}</p>
                        </td>
                        <td>
                            <div v-if="order.status == 'Подтверждён' || order.status == 'Получён'">
                                <p v-if="order.date_start">@{{ order.date_start }}</p>
                                <p v-else>Скоро появится</p>
                            </div>
                        </td>
                        <td>
                            <div v-if="order.status == 'Подтверждён' || order.status == 'Получён'">
                                <p v-if="order.date_end">@{{ order.date_end }}</p>
                                <p v-else>Скоро появится</p>
                            </div>
                        </td>
                        <td>
                            <p v-if="order.status == 'Отменён'">
                                @{{ order.comment }}
                            </p>
                        </td>
                        <td>@{{ order.status }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn" data-bs-toggle="modal"
                                :data-bs-target="'#exampleModal' + order.id">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" :id="'exampleModal' + order.id" tabindex="-1"
                                :aria-labelledby="'#exampleModal' + order.id" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Изменение статуса</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form @submit.prevent="editStatus(order.id)" style="text-align: left;"
                                                :id="'edit_' + order.id">
                                                <label style="font-weight: 500;" for="status"
                                                    class="form-label">Статус</label>
                                                <select v-model="selectStatus" name="status"
                                                    :class="errors.status ? 'is-invalid' : ''" id="status"
                                                    class="form-control mb-3">
                                                    <option value="В обработке">В обработке</option>
                                                    <option value="Подтверждён">Подтверждён</option>
                                                    <option value="Получён">Получён</option>
                                                    <option value="Отменён">Отменён</option>
                                                </select>
                                                <div class="invalid-feedback" v-for="error in errors.status">
                                                    @{{ error }}
                                                </div>
                                                <div class="mb-3" v-if="selectStatus ==='Отменён'">
                                                    <label for="comment">Комментарий</label>
                                                    <textarea type="text" class="form-control" name="comment" id="comment"></textarea>
                                                </div>
                                                <div class="mb-3 d-flex gap-3" v-if="selectStatus ==='Подтверждён'">
                                                    <div class="">
                                                        <label for="date_start">Дата начала
                                                            <input type="date" class="form-control" name="date_start"
                                                                id="date_start"></label>
                                                    </div>
                                                    <div class="">
                                                        <label for="date_end">Дата окончания
                                                            <input type="date" class="form-control" name="date_end"
                                                                id="date_end"></label>
                                                    </div>
                                                </div>
                                                <button type="submit" style="text-align: right;"
                                                    class="btn btn-dark">Сохранить изменения</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors: [],
                    message: '',
                    allOrders: [],
                    selectStatus: '',
                }
            },
            methods: {
                async getData() {
                    const responseAllOrders = await fetch('{{ route('getAllOrders') }}');
                    this.allOrders = await responseAllOrders.json();
                    console.log(this.allOrders);
                },
                async editStatus(id) {
                    // console.log(id);
                    let form = document.getElementById('edit_' + id);
                    let form_data = new FormData(form);
                    form_data.append('id', id);
                    const response = await fetch('{{ route('editOrderStatus') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: form_data,
                    });
                    if (response.status == 400) {
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 10000);
                    }
                    if (response.status == 200) {
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.message = '';
                        }, 10000);
                        form.reset();
                        this.getData();
                    }
                    // console.log(form);
                }
            },
            mounted() {
                this.getData();
            }
        }
        Vue.createApp(app).mount('#allOrders');
    </script>
@endsection
