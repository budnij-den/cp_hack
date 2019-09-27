/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueChatScroll from 'vue-chat-scroll-top-scroll'
Vue.use(VueChatScroll);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('chat', require('./components/ChatMessages.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
   el: '#app',
    methods: {
       openNav() {
           var vm = this;
           vm.$refs.mySidenav.style.width = "280px";
           vm.$refs.main.style.opacity = "0";
       },
       closeNav() {
           var vm = this;
           vm.$refs.mySidenav.style.width = "0";
           vm.$refs.main.style.opacity = "1";
       },
        updateProjectTime() {
           var id = document.querySelectorAll('.expireAt');
           id.forEach(function(item, i) {
               if(item.getAttribute('title') == 'play') {
                   let expireAt = item.getAttribute('id');
                   item.innerHTML = moment(expireAt).endOf('minutes').fromNow();
               }
               else {
                   item.innerHTML = 'Завершён';
               }
           });
        },
        updateLastSeenTime() {
           var getTeg = document.querySelector('.lastSeen');
           var lastSeenTimeFromDatabase = getTeg.getAttribute('id');
           var lastSeenInUnix = moment(lastSeenTimeFromDatabase).unix();
           var nowInUnix = moment().unix();
           var minutesLastSeenFromNow = Math.ceil((nowInUnix - lastSeenInUnix) / 60);
           var lastSeen = moment(lastSeenTimeFromDatabase).startOf('minutes').fromNow();
           if(minutesLastSeenFromNow >= 5) {
               getTeg.innerHTML = 'Был ' + lastSeen;
           }
           else {
               getTeg.innerHTML = 'Здесь';
           }
        },
    },
    created() {
        moment.locale('ru');
        setInterval(() => this.updateProjectTime(),1000);
        setInterval(() => this.updateLastSeenTime(),1000);
        var currentDate = moment().format('Y-MM-DD');
        var currentTime =  moment().format('LTS');
        var now = currentDate + ' ' + currentTime;
        window.onbeforeunload = axios.post('/onlineOrGone', {lastSeen_at: now});
    }
});