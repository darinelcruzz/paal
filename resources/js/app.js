
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import VueCurrencyFilter from 'vue-currency-filter';

import VModal from 'vue-js-modal'

Vue.use(VModal, { componentName: "v-modal" })

Vue.use(VueCurrencyFilter,
{
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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('solid-box', require('./components/lte/SolidBox.vue').default);
Vue.component('simple-box', require('./components/lte/SimpleBox.vue').default);
Vue.component('accordion', require('./components/lte/Accordion.vue').default);
Vue.component('accordion-item', require('./components/lte/AccordionItem.vue').default);
Vue.component('tab', require('./components/lte/TabPane.vue').default);
Vue.component('tabs', require('./components/lte/CustomTabs.vue').default);
Vue.component('carousel', require('./components/lte/Carousel.vue').default);
Vue.component('carousel-item', require('./components/lte/CarouselItem.vue').default);
Vue.component('data-table', require('./components/lte/DataTable.vue').default);
Vue.component('thumbnail', require('./components/lte/Thumbnail.vue').default);
Vue.component('tl-item', require('./components/lte/TimelineItem.vue').default);
Vue.component('tl-label', require('./components/lte/TimelineLabel.vue').default);
Vue.component('timeline', require('./components/lte/Timeline.vue').default);
Vue.component('profile', require('./components/lte/UserProfile.vue').default);
Vue.component('pitem', require('./components/lte/UserProfileItem.vue').default);
Vue.component('modal', require('./components/lte/Modal.vue').default);
Vue.component('modal-button', require('./components/lte/ModalButton.vue').default);
Vue.component('ptable', require('./components/lte/ProductTable.vue').default);
Vue.component('prow', require('./components/lte/ProductRow.vue').default);
Vue.component('dropdown', require('./components/lte/DropdownButton.vue').default);
Vue.component('ddi', require('./components/lte/DropdownItem.vue').default);
Vue.component('file-upload', require('./components/lte/FileUploadInput.vue').default);
Vue.component('pdf-button', require('./components/lte/FileUploadButton.vue').default);
Vue.component('dynamic-inputs', require('./components/lte/DynamicInputs.vue').default);
Vue.component('color-card', require('./components/lte/ColorCard.vue').default);
Vue.component('multiple-inputs', require('./components/lte/MultipleInputs.vue').default);
Vue.component('notifications', require('./components/lte/Notifications.vue').default);

Vue.component('add-product', require('./components/AddProductButton.vue').default);
Vue.component('p-table', require('./components/ProductsTable.vue').default);
Vue.component('seriable-products-list', require('./components/SeriableProductsList.vue').default);
Vue.component('seriable-products', require('./components/SeriableProducts.vue').default);
Vue.component('seriable-product', require('./components/SeriableProduct.vue').default);
Vue.component('p-row', require('./components/ProductRow.vue').default);
Vue.component('shopping-list', require('./components/ShoppingList.vue').default);
Vue.component('shopping-list-item', require('./components/ShoppingListItemTwo.vue').default);
Vue.component('shipping-list', require('./components/ShippingList.vue').default);
Vue.component('shipping-item', require('./components/ShippingItem.vue').default);
Vue.component('payment-methods', require('./components/PaymentMethods.vue').default);
Vue.component('payment-inputs', require('./components/PaymentInputs.vue').default);
Vue.component('client-select', require('./components/ClientSelect.vue').default);
Vue.component('provider-select', require('./components/ProviderSelect.vue').default);
Vue.component('money-box', require('./components/MoneyBox.vue').default);
Vue.component('movements', require('./components/Movements.vue').default);
Vue.component('sale-products-list', require('./components/SaleProductsList.vue').default);
Vue.component('info-box', require('./components/InfoBox.vue').default);
Vue.component('icon-box', require('./components/IconBox.vue').default);
Vue.component('conditioned-select', require('./components/ConditionedSelect.vue').default);
Vue.component('product-quantity-and-amount', require('./components/ProductQuantityAndAmount.vue').default);
Vue.component('categories-and-families-table', require('./components/CategoriesAndFamiliesTable.vue').default);

// NEW ONES FOR SANSON
Vue.component('shopping-cart', require('./components/ShoppingCart.vue').default);
Vue.component('shopping-cart-item', require('./components/ShoppingCartItem.vue').default);

const Bus = new Vue({});

const app = new Vue({
    el: '#app',
    data: {
    	complement: null,
        payment_method: 0,
        payment_total: 0,
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
            method: '',
            check: false,
            checked: [],
            phpChecked: [],
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
            sanson: {
                general: [],
                register: [],
            },
            mbe: {
               general: [],
               register: [], 
            }
        },
        checkall: false,
        formSubmitted: false,
        checked: [],
        model: {},
    },
    methods: {
        upmodel(object) {
            this.model = object
        },
        reset() {
            this.product_option = ''
        },
        submit(type) {
            if (type == 'venta') {
                if (this.payment_total > 0) {
                    this.formSubmitted = true;
                    this.$refs.cform.submit();
                } else {
                    alert('Falta importe según el método de pago');
                }
            } else {
                this.formSubmitted = true;
                this.$refs.cform.submit();
            }
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
        checkAll(items) {
            this.mbe.check = !this.mbe.check
            if(this.mbe.check) {
                console.log('Todas seleccionadas')
                for (let [key, item] of Object.entries(items)) {
                    this.mbe.checked.push({
                        id: item.id, iva: item.iva, amount: item.amount, folio: item.folio
                    });
                }
            } else {
                console.log('Todas deseleccionadas')
                this.mbe.checked = []
            }

            this.updateCheckall(items)
        },
        updateCheckall(items){

          if(Object.keys(items).length == this.mbe.checked.length){
             this.mbe.check = true;
          }else{
             this.mbe.check = false;
          }

          this.mbe.phpChecked = []

          for (let item of this.mbe.checked) {
                this.mbe.phpChecked.push(item.id);
            }
        },
    },
    created() {
        const t = this;

        t.$on('set-total', (total) => {
            t.ingress_total = total
        });

        t.$on('update-payment', (amount) => {
            t.payment_total = amount
        });

        axios.get('/api/providers/mbe/of').then(({data}) => {
            t.providers.mbe.general = data;
        });

        axios.get('/api/providers/coffee/of').then(({data}) => {
            t.providers.coffee.general = data;
        });

        axios.get('/api/providers/sanson/of').then(({data}) => {
            t.providers.sanson.general = data;
        });

        axios.get('/api/providers/mbe/cc').then(({data}) => {
            t.providers.mbe.register = data;
        });

        axios.get('/api/providers/coffee/cc').then(({data}) => {
            t.providers.coffee.register = data;
        });

        axios.get('/api/providers/sanson/cc').then(({data}) => {
            t.providers.sanson.register = data;
        });
    }
});
