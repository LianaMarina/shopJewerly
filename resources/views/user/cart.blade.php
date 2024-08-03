@extends('layout/app')

@section('title')
    Моя корзина
@endsection

@section('content')
    <div class="container" id="myCart">
        <div :class="error ? 'alert alert-danger' : ''">
            @{{ error }}
        </div>
        <div :class="message ? 'alert alert-success' : ''">
            @{{ message }}
        </div>
        <form @submit.prevent="orderCheckout" id="checkout">
        <h2 class="my-5">Корзина</h2>
        <div class="cart_product d-flex gap-3 align-items-start">
            <table class="col-9" style="border-color: rgba(0, 0, 0, 0.259) !important;">
                <thead>
                    <tr style="font-size: 18px; font-weight:500; color:rgba(0, 0, 0, 0.259);">
                        <td scope="col">Товар</td>
                        <td scope="col"></td>
                        <td scope="col">Цена</td>
                        <td scope="col">Размер</td>
                        <td scope="col">Кол-во</td>
                        <td scope="col">Удалить</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(cart_product, index) in cart_products" :key="index">
                        <th scope="row"><img class="" :src="'/public' + cart_product.images" alt=""
                                style="width: 50px;">
                        </th>
                        <td style="font-weight: 500;" class="col-4">@{{ cart_product.title }}</td>
                        <td style="font-weight: 500;">@{{ cart_product.sum }} Р</td>
                        <td style="font-weight: 500;">
                            <select name="size[]" id="size" class="form-control" style="max-width: 125px;">
                                <option v-for="filial_size in cart_product.filials_sizes"
                                    v-model="cart_product.filial_size.size_id" :value="filial_size.size_id">
                                    @{{ filial_size.size_title }} (@{{ filial_size.filial_title }})</option>
                            </select>
                        </td>
                        <td class="d-flex mt-3" style="text-align: center !important;">
                            <button @click="minusProduct(cart_product)" class="btn" type="button"><i class="bi bi-dash"></i></button>
                            <input name="count[]" type="text" class="form-control" :min="1"
                                style="max-width: 50px; border: solid 0.5px rgba(0, 0, 0, 0.259) !important;"
                                v-model="cart_product.count" @input="updatePrice(cart_product)">
                            <button @click="plusProduct(cart_product)" class="btn" type="button"><i class="bi bi-plus"></i></button>
                        </td>
                        <td class="text-align-center"><button type="button" class="btn" @click="deleteProduct(cart_product)"><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
            <div class="col-3">
                <div class="shadow p-4">
                        <h5 class="pb-4">Оформление заказа</h5>
                        <p style="font-weight: 500;">Выберите адрес доставки:</p>
                        <div class="" v-for="filial in filials">
                            <div class="d-flex align-items-start gap-1">
                                <input type="radio" name="filial" id="filial" :class="errors.filial ? 'is-invalid':''" :value="filial.id">
                                <label for="filial" class="form-label">@{{ filial.title }}
                                    <span>@{{ filial.address }}</span></label>
                                <div class="invalid-feedback" v-for="error in errors.filial">
                                    @{{ error }}
                                </div>
                            </div>
                        </div>
                        <p class="mt-5" style="font-size: 25px; font-weight:500;"><span>Сумма: </span>@{{ sum }} Р</p>
                        <div class="d-grid col-auto">
                            <button class="btn btn-dark mt-5 mb-3" type="submit">ОФОРМИТЬ ЗАКАЗ</button>
                        </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors: [],
                    message: '',
                    error: '',
                    cart_products: [],
                    filials: [],
                    sizes: [],
                    sum: 0,
                }
            },
            methods: {
                async getData() {
                    const responseProduct = await fetch('{{ route('get_cart_products') }}');
                    this.cart_products = await responseProduct.json();
                    const responseFilials = await fetch('{{ route('getFilials') }}');
                    this.filials = await responseFilials.json();
                    const response_sizes = await fetch('{{ route('getSizes') }}');
                    this.sizes = await response_sizes.json();
                    console.log(this.sizes);
                    this.cart_products.forEach(element => {
                        element.images = element.images.split(";")[0];
                    });
                    console.log(this.cart_products);
                    this.cart_products.forEach(product => {
                        product.filials_sizes.forEach(element => {
                            this.sizes.forEach(item => {
                                if (item.id === element.size_id) {
                                    element.size_title = item.number;
                                }
                            })
                        })
                    })
                    this.cart_products.forEach(product => {
                        product.filials_sizes.forEach(element => {
                            this.filials.forEach(item => {
                                if (item.id === element.filial_id) {
                                    element.filial_title = item.title;
                                }
                            })
                        })
                        product.selectSize = product.filials_sizes[0];
                    })
                    console.log(this.cart_products);
                    this.cart_products.forEach(element => {
                        this.sum += element.sum;
                    });
                },
                updatePrice(cart_product) {
                    if (cart_product.count <= 0) {
                        cart_product.count = 1;
                    }
                    this.cart_products.forEach(element => {
                        this.sum += element.sum * element.count;
                    });
                    console.log(cart_product.count);
                },
                async minusProduct(cart_product) {
                    if (cart_product.count == 1) {
                        //написать запрос на удаление этого продукта из корзины
                        const responseDeleteFromCart = await fetch(
                            `{{ route('deleteProductCart') }}/${cart_product.id}`);
                        if (responseDeleteFromCart.status == 200) {
                            window.location = '{{ route('show_cart_page') }}';
                        }
                    } else {
                        cart_product.count -= 1;
                        cart_product.sum = cart_product.count * cart_product.price;
                        this.sum -= cart_product.price;
                    }

                },
                async deleteProduct(cart_product) {
                    const responseDeleteFromCart = await fetch(
                            `{{ route('deleteProductCart') }}/${cart_product.id}`);
                        if (responseDeleteFromCart.status == 200) {
                            window.location = '{{ route('show_cart_page') }}';
                        }
                },
                plusProduct(cart_product) {
                    console.log(cart_product.selectSize);
                    if (cart_product.count < cart_product.selectSize.count) {
                        cart_product.count += 1;
                        cart_product.sum = cart_product.count * cart_product.price;
                        this.sum += cart_product.price;
                    }
                    // console.log(cart_product.filials_sizes);
                },
                async orderCheckout() {
                    let form = document.getElementById('checkout');
                    console.log(form);
                    let form_data = new FormData(form);
                    const response = await fetch('{{ route('checkout') }}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        body: form_data,
                    });
                    if(response.status == 400) {
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 10000);
                    }
                    if(response.status == 200) {
                        this.message = await response.json();
                        setTimeout(() => {
                            this.message = '';
                        }, 10000);
                        window.location = '{{ route('show_user_profile') }}';
                    }
                    if(response.status == 401) {
                        this.error = await response.json();
                        setTimeout(() => {
                            this.error = '';
                        }, 10000);
                    }
                }
            },
            mounted() {
                this.getData();
            }
        }
        Vue.createApp(app).mount('#myCart')
    </script>
@endsection
