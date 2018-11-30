
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('v-select', VueSelect.VueSelect);

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
Vue.component('shopping-list', require('./components/ShoppingList.vue'));

const Bus = new Vue({});

const app = new Vue({
    el: '#app',
    data: {
    	pmethod: '',
    	complement: null,
        payment_method: 0,
        is_retained: 1,
        retainer: 0,
        amount_received: 0,
        product_option: '',
        product_family: '',
    },
    methods: {
        reset() {
            this.product_option = ''
        }
    }
});
