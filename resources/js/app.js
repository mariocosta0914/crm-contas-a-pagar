/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('topo', require('./components/header/Topo.vue').default);
Vue.component('topo-autenticado', require('./components/header/TopoAutenticado.vue').default);
Vue.component('menu-supervisor', require('./components/header/MenuSupervisor.vue').default);
Vue.component('card-generico', require('./components/CardGenerico.vue').default);
Vue.component('cliente-informacoes', require('./components/cliente/InformacoesCliente.vue').default);
Vue.component('cliente-informacoes-financeiras', require('./components/cliente/InformacoesFinanceiras.vue').default);
Vue.component('receptivo', require('./components/cliente/Receptivo.vue').default);
Vue.component('tabela-titulos', require('./components/cliente/TabelaTitulos.vue').default);
Vue.component('historico-tratativas', require('./components/cliente/HistoricoTratativas.vue').default);
Vue.component('tabela-usuarios', require('./components/adm/usuarios/TabelaUsuarios.vue').default);
Vue.component('excluir-usuario', require('./components/adm/usuarios/FormExcluirUsuario.vue').default);
Vue.component('mensagens', require('./components/Mensagens.vue').default);
Vue.component('multipla-selecao', require('./components/adm/usuarios/Select.vue').default);
Vue.component('select-operador', require('./components/adm/relatorios/SelectOperador.vue').default);
Vue.component('cliente-tratativa', require('./components/tratativas/ClienteTratativa.vue').default);
Vue.component('configuracao', require('./components/adm/configuracao/Configuracao.vue').default);
Vue.component('relatorio', require('./components/adm/relatorios/Relatorio.vue').default);
Vue.component('modal-contatos', require('./components/cliente/ModalContatos.vue').default);
Vue.component('modal-envio-titulo-nota', require('./components/cliente/ModalEnvioTituloNota.vue').default);
Vue.component('modal-envio-lembrete', require('./components/cliente/ModalEnvioLembrete.vue').default);
Vue.component('modal-tratativas', require('./components/tratativas/ModalTratativas.vue').default);
Vue.component('tabela-clientes-envio-diario', require('./components/adm/envioDiario/TabelaClientesEnvioDiario.vue').default);
Vue.component('modal-selecao-tratativas', require('./components/tratativas/ModalSelecaoTratativas.vue').default);
Vue.component('fila-vazia', require('./components/FilaVazia.vue').default);


import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);

import DualListBox from "dual-listbox-vue";
Vue.component('dual-list', DualListBox);

import { SweetModal, SweetModalTab } from "sweet-modal-vue";
Vue.component('sweet-modal', SweetModal);
Vue.component('sweet-tab', SweetModalTab);

import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask);

import Datepicker from 'vuejs-datepicker';
Vue.component('Datepicker', Datepicker)

import Vuesax from 'vuesax';
Vue.use(Vuesax);

import JwPagination from 'jw-vue-pagination';
Vue.component('jw-pagination', JwPagination);

import vSelect from "vue-select";
Vue.component("v-select", vSelect);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
