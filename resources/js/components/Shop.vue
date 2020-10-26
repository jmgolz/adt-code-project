<template>
    <!-- <div class="container-fluid">
        <div class="row">
            

        </div>
    </div> -->
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
</template>

<script>
export default {
    data() {
        return {
            cart: [],
            products: null,
            total: 0.00,
            amountPaid: 0.00,
            baseUrl: 'https://itunes.apple.com/search'
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            return axios.get(
                this.baseUrl,
                {params: {
                    term: 'bts', // Look, their music is catchy, OKAY?
                    limit: 10,
                    entity: 'album'
                }}
            ).then(response => {
                console.log(response.data.results);
                this.products = response.data.results;
            });
        },
        addToCart(product) {
            this.cart.push(product);
            console.log(this.cart);
        },
        clearCart() {
            this.cart = []
        }
    }
}
</script>