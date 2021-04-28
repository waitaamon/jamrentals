require('./bootstrap');

import Vue from "vue";
import VueModal from '@kouts/vue-modal';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.component('Modal', VueModal);
Vue.component('multiselect', Multiselect)
Vue.component('calendar', Calendar)
Vue.component('date-picker', DatePicker)


Vue.use(VueToast, {
    position: 'top-right'
});

Vue.component('buildings-list', require('./app/buildings/BuildingsList.vue').default)

const app = new Vue({
    el: '#app',
});