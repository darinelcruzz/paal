
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('v-select', VueSelect.VueSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('solid-box', require('./components/lte/SolidBox.vue'));
Vue.component('simple-box', require('./components/lte/SimpleBox.vue'));
Vue.component('accordion', require('./components/lte/Accordion.vue'));
Vue.component('accordion-item', require('./components/lte/AccordionItem.vue'));
Vue.component('tab', require('./components/lte/TabPane.vue'));
Vue.component('tabs', require('./components/lte/CustomTabs.vue'));
Vue.component('carousel', require('./components/lte/Carousel.vue'));
Vue.component('carousel-item', require('./components/lte/CarouselItem.vue'));
Vue.component('data-table', require('./components/lte/DataTable.vue'));
Vue.component('thumbnail', require('./components/lte/Thumbnail.vue'));
Vue.component('tl-item', require('./components/lte/TimelineItem.vue'));
Vue.component('tl-label', require('./components/lte/TimelineLabel.vue'));
Vue.component('timeline', require('./components/lte/Timeline.vue'));
Vue.component('profile', require('./components/lte/UserProfile.vue'));
Vue.component('pitem', require('./components/lte/UserProfileItem.vue'));
Vue.component('modal', require('./components/lte/Modal.vue'));
Vue.component('modal-button', require('./components/lte/ModalButton.vue'));
Vue.component('ptable', require('./components/lte/ProductTable.vue'));
Vue.component('prow', require('./components/lte/ProductRow.vue'));
Vue.component('dropdown', require('./components/lte/DropdownButton.vue'));
Vue.component('ddi', require('./components/lte/DropdownItem.vue'));
Vue.component('file-upload', require('./components/lte/FileUploadInput.vue'));
Vue.component('pdf-button', require('./components/lte/FileUploadButton.vue'));
Vue.component('dynamic-inputs', require('./components/lte/DynamicInputs.vue'));

Vue.component('add-product', require('./components/AddProductButton.vue'));
Vue.component('p-table', require('./components/ProductsTable.vue'));
Vue.component('p-row', require('./components/ProductRow.vue'));

const app = new Vue({
    el: '#app',
    data: {
    	pmethod: '',
    	complement: null,
        payment_method: 0,
        is_retained: 1,
        retainer: 0,
        amount_received: 0,
    	inputs: [],
        product_option: '',
    },
    methods: {
        addRow(product) {
            product.quantity = 1
            product.discount = 0
            product.total = 1 * product.retail_price
            this.inputs.push(product)
        },
        deleteRow(index) {
            this.inputs.splice(index, 1)
        },
        changeQuantity(index) {
            var product = this.inputs[index]

        	if (product.wholesale_quantity > 0 && product.quantity >= product.wholesale_quantity) {
        		product.total = (product.wholesale_price * product.quantity) - product.discount
        	} else {
        		product.total = (product.retail_price * product.quantity) - product.discount
            }
            console.log("total", product.total);
        }
    },
    computed: {
        subtotal() {
            console.log("products", this.inputs);
            return this.inputs.reduce((total, input) => total + input.total, 0)
        },
        iva() {
            products = this.inputs
            // return products.reduce((iva, input) => iva + input.total, 0)
            return 0
        },
    },
});
