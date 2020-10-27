<template>
    <div class="container">
        <div class="row">
            <!-- products display -->
            <div class="col">                
                    <ul class="unstyled-list">
                        <li v-for="product in products" :key="product.collectionId" class="media rounded border border-secondary product-media-card">
                            <img 
                                :src="product.artworkUrl100"
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
                                        <button class="btn btn-success btn-sm" @click.prevent="addToCart(product)">Add to Cart</button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            

            <div class="col">
                <!-- Cart display -->
                <div v-if="cart.length">
                    <ul class="list-unstyled">
                        <li v-for="item in cart" :key="item.collectionId" class="media rounded border border-secondary product-media-card">
                            <img :src="item.artworkUrl60" class="mr-3" :alt="item.collectionName" />

                            <div class="media-body">
                                {{item.artistName}} - {{item.collectionName}}
                                <ul class="list-unstyled">
                                    <li>Tracks: {{item.trackCount}}</li>
                                    <li>Price: <b>{{item.collectionPrice}}</b></li>
                                    <li>{{item.copyright}}</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div v-else>
                    <ul class="list-unstyled">
                        <li class="media rounded border border-secondary product-media-card">
                            <div class="media-body">
                                Oh my, your cart is empty!
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Checkout display -->
                <div v-if="readyForCheckout">
                     <form @submit.prevent="placeOrder">
                         <div class="form-group row">
                            <label for="amountDue" class="col col-form-label">Amount Due:</label>
                            <div class="col">
                                <input v-model="total" type="text" readonly class="form-control-plaintext" id="amountDue">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment" class="col col-form-label">Payment Amount (in USD):</label>
                            <div class="col">
                                <input v-model="amountPaid" type="text" class="form-control" id="payment" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <button class="btn btn-danger" @click.prevent="clearCart()">Clear cart</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change owed -->
                <div v-if="changeOwed" class="jumbotron jumbotron-padding-fix">
                    <h5>Change Owed</h5>
                    <ul class="list-unstyled">
                        <li>Dollars</li>
                        <li v-if="changeOwed.dollars" v-for="(value, key) in changeOwed.dollars">
                            {{key}} dollar(s): {{value}}
                        </li>
                        <li v-else>None</li>
                    </ul>

                    <ul class="list-unstyled">
                        <li>Cents</li>
                        <li v-if="changeOwed.cents" v-for="(value, key) in changeOwed.cents">
                            {{key}} cent(s): {{value}}
                        </li>
                        <li v-else>None</li>
                    </ul>
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
            amountPaid: null,
            readyForCheckout: false,
            changeOwed: null
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
            this.readyForCheckout = true;
        },
        clearCart() {
            this.cart = []
            this.total = 0.00;
            this.amountPaid = null,
            this.readyForCheckout = false;
        },
        placeOrder() {
            return axios.get('/change', {
                params: {
                    amountPaid: this.amountPaid,
                    orderTotal: this.total
                }
            })
            .then(response => {
                this.changeOwed = response.data;
                this.amountPaid = null,
                console.log(this.changeOwed);
            })
        }
    }
}
</script>