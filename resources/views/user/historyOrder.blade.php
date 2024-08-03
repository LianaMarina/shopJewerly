@extends('layout/app')

@section('title')
    История заказов
@endsection

@section('content')
    <div class="container" id="historyOrder">
        <h2 class="my-5">История заказов</h2>
        <div class="col-12 d-flex gap-3">
            <div class="col-8">
                <table class="table table-light" style="text-align: center;">
                    <thead>
                        <tr>
                            <th scope="col">Номер</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Сумма</th>
                            <th scope="col">Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in historyOrders">
                            <th scope="row"><button class="btn">@{{ index + 1 }}</button></th>
                            <td>
                                <p style="font-weight: 500;">@{{ order.filial.title }}</p>
                                <p>@{{ order.filial.address }}</p>
                            </td>
                            <td style="font-weight:500;">@{{ order.sum }} Р</td>
                            <td style="font-weight:500;">@{{ order.status }}</td>
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
                    historyOrders: [],
                }
            },
            methods: {
                async getData() {
                    const responseHistoryOrder = await fetch('{{ route('getMyHistoryOrder') }}');
                    this.historyOrders = await responseHistoryOrder.json();
                    console.log(this.historyOrders);
                },
            },
            mounted() {
                this.getData();
            }
        }
        Vue.createApp(app).mount('#historyOrder');
    </script>
@endsection