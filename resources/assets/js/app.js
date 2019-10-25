
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueCurrencyFilter from 'vue-currency-filter';

import VModal from 'vue-js-modal'

Vue.use(VModal, { componentName: "v-modal" })

Vue.use(VueCurrencyFilter,
{
  symbol : '$',
  thousandsSeparator: ',',
  fractionCount: 2,
  fractionSeparator: '.',
  symbolPosition: 'front',
  symbolSpacing: true
})

Vue.component('v-select', VueSelect.VueSelect);

//global registration
import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard)

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
Vue.component('color-card', require('./components/lte/ColorCard.vue'));

Vue.component('add-product', require('./components/AddProductButton.vue'));
Vue.component('p-table', require('./components/ProductsTable.vue'));
Vue.component('p-row', require('./components/ProductRow.vue'));
Vue.component('shopping-list', require('./components/ShoppingList.vue'));
Vue.component('shopping-list-item', require('./components/ShoppingListItem.vue'));
Vue.component('shipping-list', require('./components/ShippingList.vue'));
Vue.component('shipping-item', require('./components/ShippingItem.vue'));
Vue.component('payment-methods', require('./components/PaymentMethods.vue'));
Vue.component('client-select', require('./components/ClientSelect.vue'));
Vue.component('provider-select', require('./components/ProviderSelect.vue'));
Vue.component('money-box', require('./components/MoneyBox.vue'));
Vue.component('sale-products-list', require('./components/SaleProductsList.vue'));

const Bus = new Vue({});

const app = new Vue({
    el: '#app',
    data: {
    	complement: null,
        payment_method: 0,
        is_retained: 1,
        retainer: 0,
        ingress_total: 0,
        is_invoiced: '',
        amount_received: 0,
        product_option: '',
        product_family: '',
        provider: '',
        providers: [],
        rproviders: [],
        mproviders: [],
        mbe: {
            subtotal: 0,
            iva: 0,
            client: '',
            method: ''
        },
        provider_form: {
            group: '',
            deductible: ''
        },
        providers: {
            coffee: {
                general: [],
                register: [],
            },
            mbe: {
               general: [],
               register: [], 
            }
        },
        checkall: false,
        checked: [],
    },
    methods: {
        reset() {
            this.product_option = ''
        },
        submit() {
            this.$refs.cform.submit()
        },
        checkIsInvoiced() {
            return this.is_invoiced != ''
        },
        refresh() {
            const t = this;
            t.provider_id = provider.id

            axios.get('/api/providers').then(({data}) => {
                t.providers = data;
            });
        },
        showModal(modal_name) {
            this.$modal.show(modal_name)
        },
        add(item) {
            this.checked.push(item)
        },
    },
    created() {
        const t = this;

        t.$on('set-total', (total) => {
            t.ingress_total = total
        });

        axios.get('/api/providers/mbe/of').then(({data}) => {
            t.providers.mbe.general = data;
        });

        axios.get('/api/providers/coffee/of').then(({data}) => {
            t.providers.coffee.general = data;
        });

        axios.get('/api/providers/mbe/cc').then(({data}) => {
            t.providers.mbe.register = data;
        });

        axios.get('/api/providers/coffee/cc').then(({data}) => {
            t.providers.coffee.register = data;
        });
    }
});
