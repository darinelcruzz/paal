<template>
	<div id="products_table">
        <div class="row">
            <div class="col-md-4 pull-right">
                <div class="input-group input-group-sm">
                    <input type="text" v-model="keyword" class="form-control" @change="search">
                    <span class="input-group-btn">
                      <button type="button" :class="'btn btn-' + color + ' btn-flat'">
                          <i class="fa fa-search"></i>
                      </button>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="btn-group">
                    <button @click="fetchProducts(pagination.first_page_url)" :disabled="!pagination.first_page_url" :class="'btn btn-' + color + ' btn-sm'">
                        <i class="fa fa-angle-double-left"></i>
                    </button>
                    <button @click="fetchProducts(pagination.prev_page_url)" :disabled="!pagination.prev_page_url" :class="'btn btn-' + color + ' btn-sm'">
                        <i class="fa fa-angle-left"></i>
                    </button>
                    <button class="btn btn-default btn-sm">Página {{ pagination.current_page }} de {{ pagination.last_page }}</button>
                    <button @click="fetchProducts(pagination.next_page_url)" :disabled="!pagination.next_page_url" :class="'btn btn-' + color + ' btn-sm'">
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <button @click="fetchProducts(pagination.last_page_url)" :disabled="!pagination.last_page_url" :class="'btn btn-' + color + ' btn-sm'">
                        <i class="fa fa-angle-double-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fa fa-plus"></i></th>
                    <th>Producto</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(product, index) in products" :key="index" is="p-row" :exchange="exchange"
                    :product="product" :color="color" @add-element="addProduct(index)">
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
	export default {
		props: ['color', 'exchange'],
		data() {
			return {
                products: [],
				pagination: {},
                keyword: '',
			}
		},
		methods: {
			fetchProducts(page_url) {
                page_url = page_url || '/api/products'
                axios.get(page_url)
                    .then((response) => {
                        var productsReady = response.data.data.map((product) => {
                            return product
                        })

                        var pagination = {
                            current_page: response.data.current_page,
                            last_page: response.data.last_page,
                            next_page_url: response.data.next_page_url,
                            prev_page_url: response.data.prev_page_url,
                            last_page_url: response.data.last_page_url,
                            first_page_url: response.data.first_page_url,
                        }

                        this.products = productsReady
                        this.pagination = pagination
                    })
            },
            searchProducts(page_url, keyword) {
                page_url = '/api/products/' + keyword
                axios.get(page_url)
                    .then((response) => {
                        var productsReady = response.data.data.map((product) => {
                            return product
                        })

                        var pagination = {
                            current_page: response.data.current_page,
                            last_page: response.data.last_page,
                            next_page_url: response.data.next_page_url,
                            prev_page_url: response.data.prev_page_url,
                            last_page_url: response.data.last_page_url,
                            first_page_url: response.data.first_page_url,
                        }

                        this.products = productsReady
                        this.pagination = pagination
                    })
            },
            search() {
                this.searchProducts(this.pagination.current_page, this.keyword)
            },
            addProduct(index) {
                const product = this.products[index]
                this.$emit('added', product);
            }
		},
		created() {
			this.fetchProducts()
		}
	};
</script>
