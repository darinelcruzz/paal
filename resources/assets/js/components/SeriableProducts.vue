<template>
    <div id="products_table">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button @click="fetch(pagination.first_page_url)" :disabled="!pagination.first_page_url" :class="btnClass">
                        <i class="fa fa-angle-double-left"></i>
                    </button>
                    <button @click="fetch(pagination.prev_page_url)" :disabled="!pagination.prev_page_url" :class="btnClass">
                        <i class="fa fa-angle-left"></i>
                    </button>
                    <button class="btn btn-default btn-sm">Página {{ pagination.current_page }} de {{ pagination.last_page }}</button>
                    <button @click="fetch(pagination.next_page_url)" :disabled="!pagination.next_page_url" :class="btnClass">
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <button @click="fetch(pagination.last_page_url)" :disabled="!pagination.last_page_url" :class="btnClass">
                        <i class="fa fa-angle-double-right"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-6 pull-right">
                <div class="input-group input-group-sm">
                    <input type="text" v-model="keyword" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" :class="'btn btn-' + color + ' btn-flat'">
                          <i class="fa fa-search"></i>
                      </button>
                    </span>
                </div>
            </div>
        </div>
        <hr>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;"><i class="fa fa-plus-square"></i></th>
                    <th style="width: 60%"><small>DESCRIPCIÓN</small></th>
                    <th style="width: 15%"><small>CÓDIGO</small></th>
                    <th style="width: 15%; text-align: right;"><small>PRECIO</small></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(item, index) in items" :key="index" is="seriable-product" :product="item"></tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['company', 'color'],
        data() {
            return {
                items: [],
                pagination: {},
                keyword: '',
            }
        },
        computed: {
            pageUrl() {
                return '/api/products/seriable/' + this.company + '/' + this.keyword;
            },
            btnClass() {
                return 'btn btn-' + this.color + ' btn-sm';
            }
        },
        watch: {
            keyword(value) {
                this.fetch();
            }
        },
        methods: {
            fetch(page_url) {
                page_url = page_url || this.pageUrl;
                console.log(page_url);
                axios.get(page_url).then((response) => {
                    this.items = response.data.data.map((product) => product)

                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        next_page_url: response.data.next_page_url,
                        prev_page_url: response.data.prev_page_url,
                        last_page_url: response.data.last_page_url,
                        first_page_url: response.data.first_page_url,
                    }
                })
            },
        },
        created() {
            this.fetch();
        }
    };
</script>
