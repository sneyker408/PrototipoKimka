/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



 
window.Vue = require('vue').default;
 import vue from 'vue';
 
 import Vuetify from 'vuetify'
 Vue.use(Vuetify);
 
 import VueSweetalert2 from 'vue-sweetalert2';
 
 import 'sweetalert2/dist/sweetalert2.min.css';
 Vue.use(VueSweetalert2);
 import Vue from 'vue';
 
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

Vue.use(DatePicker);


//import 'material-icons/iconfont/material-icons.css';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Categorias', require('./components/Categorias.vue').default);
Vue.component('Clientes', require('./components/Clientes.vue').default);
Vue.component('Articulos', require('./components/Articulos.vue').default);
Vue.component('Colores', require('./components/Colores.vue').default);
Vue.component('Compras', require('./components/Compras.vue').default);
Vue.component('Creaciones', require('./components/Creaciones.vue').default);
Vue.component('Pedidos', require('./components/Pedidos.vue').default);
Vue.component('Proveedores', require('./components/Proveedores.vue').default);
Vue.component('Ventas', require('./components/Ventas.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify()
});
