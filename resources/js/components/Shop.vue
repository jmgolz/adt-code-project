<template>
    <div class="container-fluid">
        <div class="row">
            <!-- products display -->
            <div class="col-md-6">
                <div>
                    <ul v-for="product in products" :key="product.collectionId" class="list-unstyled">
                        <li class="media">
                            <img 
                                :src="product.artworkUrl60"
                                class="mr-3"
                                :alt="product.collectionName"
                            />

                            <div class="media-body">
                                {{product.artistName}} - {{product.collectionName}}
                                <ul class="list-unstyled">
                                    <li>Tracks: {{product.trackCount}}</li>
                                    <li>Price: <b>{{product.collectionPrice}}</b></li>
                                    <li>{{product.copyright}}</li>
                                    <li>
                                        <button class="btn btn-success" @click.prevent="addToCart(product)">Add to Cart</button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <ul class="list-unstyled" v-for="item in cart" :key="item.collectionId">
                    <li><img :src="item.artworkUrl60" class="mr-3" :alt="item.collectionName" /></li>
                    <li>{{item.collectionName}}</li>
                    <li>{{item.collectionPrice}}</li>
                </ul>
                <div>
                    <p><b>Amount Due:</b> ${{total}}</p>
                    <button class="btn btn-primary" @click.prevent="checkout()">Checkout</button>
                    <button class="btn btn-danger" @click.prevent="clearCart()">Clear cart</button>
                </div>

                <div v-if="readyForCheckout">
                     <form @submit.prevent="placeOrder">
                         <div class="form-group row">
                            <label for="amountDue" class="col-sm-3 col-form-label">Amount Due:</label>
                            <div class="col-sm-6">
                                <input v-model="total" type="text" readonly class="form-control-plaintext" id="amountDue">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment" class="col-sm-4 col-form-label">Payment Amount (in USD):</label>
                            <div class="col-sm-4">
                                <input v-model="amountPaid" type="text" class="form-control" id="payment">
                            </div>
                        </div>

                        <div class="form-group row">
                            <button class="btn btn-primary">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
export default {
    data() {
        return {
            cart: [],
            products: null,
            total: 0.00,
            amountPaid: 0.00,
            readyForCheckout: true
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            return axios.get('/products')
            .then(response => {
                this.products = response.data.results;
            });
        },
        addToCart(product) {
            this.cart.push(product);
            this.total = this.total + product.collectionPrice;
        },
        clearCart() {
            this.cart = []
            this.total = 0.00;
            this.readyForCheckout = false;
        },
        checkout() {
            this.readyForCheckout = true;
        },
        placeOrder() {
            return axios.get('/change', {
                params: {
                    amountPaid: this.amountPaid,
                    orderTotal: this.total
                }
            })
            .then(response => {
                console.log(response);
            })
        }
    }
}
</script>