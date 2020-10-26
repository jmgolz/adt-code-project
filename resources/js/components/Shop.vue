<template>
    <div>
        <h1>This thing on?</h1>
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
        },
        clearCart() {
            this.cart = []
        }
    }
}
</script>