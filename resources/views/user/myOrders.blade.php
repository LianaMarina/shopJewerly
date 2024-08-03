@extends('layout/app')

@section('title')
    Мои заказы
@endsection

@section('content')
    <style>
        a {
            color: black;
        }
    </style>
    <div class="container" id="myOrders">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <h2 class="my-5">Мои заказы</h2>
        <div class="col-12 d-flex gap-3">
            <div class="col-8">
                <table class="table table-light" style="text-align: center;">
                    <thead>
                        <tr>
                            <th scope="col">Номер</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Дата начала</th>
                            <th scope="col">Дата окончания</th>
                            <th scope="col">Сумма</th>
                            <th scope="col">Отмена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders">
                            <th scope="row"><button class="btn"
                                    @click="getListProduct(order.id)">@{{ index + 1 }}</button></th>
                            <td>
                                <p style="font-weight: 500;">@{{ order.filial.title }}</p>
                                <p>@{{ order.filial.address }}</p>
                            </td>
                            <td>
                                <p v-if="order.date_start">@{{ order.date_start }}</p>
                                <p v-else>Скоро появится</p>
                            </td>
                            <td>
                                <p v-if="order.date_end">@{{ order.date_end }}</p>
                                <p v-else>Скоро появится</p>
                            </td>
                            <td style="font-weight:500;">@{{ order.sum }} Р</td>
                            <td>
                                <a :href="`{{ route('cancel_order') }}/${ order.id }`"><i class="bi bi-x-lg"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <table class="table table-light" style="text-align: center;" v-if="showListProduct">
                    <thead>
                        <tr>
                            <th scope="col">Фото</th>
                            <th scope="col">Название</th>
                            <th scope="col">Кол-во</th>
                            <th scope="col">Цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(cart, index) in orderListProduct" :key="index">
                                <th scope="row"><img class="" :src="'/public' + cart.product.images" alt=""
                                        style="width: 50px;">
                                </th>
                            <td><p style="font-weight: 500;">@{{ cart.product.title }}</p></td>
                            <td><p >@{{ cart.count }} шт.</p></td>
                            <td style="font-weight:500;">@{{ cart.price }} Р</td>
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
                    errors: [],
                    message: '',
                    orders: [],
                    orderListProduct: [],
                    showListProduct: false,
                }
            },
            methods: {
                async getData() {
                    const responseOrder = await fetch('{{ route('getMyOrders') }}');
                    this.orders = await responseOrder.json();
                    console.log(this.orders);
                },
                async getListProduct(id) {
                    const responseListProduct = await fetch(`{{ route('getListProductsOrder') }}/${id}`);
                    this.orderListProduct = await responseListProduct.json();
                    this.orderListProduct.forEach(element => {
                        element.product.images = element.product.images.split(";")[0];
                    });
                    this.showListProduct = true;
                    console.log(this.orderListProduct);
                },
            },
            mounted() {
                this.getData();
            }
        }
        Vue.createApp(app).mount('#myOrders');
    </script>
@endsection
