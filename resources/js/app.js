require('./bootstrap');
window.Vue = require('vue');

import App from './components/App';

const app = new Vue({
    el: '#app',
    components : {
        App
    },
    render: h => h(App),
});