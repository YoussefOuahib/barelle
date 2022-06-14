import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashbord from './components/Dashbord.vue'
import Subcategories from './pages/Subcategories.vue'
import Categories from './pages/Categories.vue'
import Products from './pages/Products.vue'
import Attributes from './pages/Attributes.vue'
import Sliders from './pages/Sliders.vue'
import Banners from './pages/Banners.vue'
import Settings from './pages/Settings.vue'
import Admin from './layouts/Admin.vue'
import Orders from './pages/Orders.vue'
import Users from './pages/Users.vue'
import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'
import Analytics from './pages/Analytics.vue'
import Notifications from './pages/Notifications.vue'

Vue.use(Chartkick.use(Chart))

Vue.use(VueRouter)

function auth(to, from, next){
    if(JSON.parse(localStorage.getItem('admin')) == true) {
        next()
    }
    else{
    next('/')
    }
}

require('./bootstrap');
require('../js/assets/admin/sidebar');

window.Vue = Vue
const routes = [
    {
        path: '/dashbord/',
        name: 'dashbord',
        component: Dashbord
    },
    
    {
        path: '/dashbord/categories',
        name: 'categories',
        component: Categories
    },
    {
        path: '/dashbord/subcategories',
        name: 'subcategories',
        component: Subcategories
    },
    {
        path: '/dashbord/products',
        name: 'products',
        component: Products
    },
    {
        path: '/dashbord/attributes',
        name: 'attributes',
        component: Attributes
    },
    {
        path: '/dashbord/sliders',
        name: 'sliders',
        component: Sliders
    },
    {
        path: '/dashbord/banners',
        name: 'banners',
        component: Banners
    },
    {
        path: '/dashbord/settings',
        name: 'settings',
        component: Settings,
    },
    {
        path: '/dashbord/orders',
        name: 'orders',
        component: Orders,
    },
    {
        path: '/dashbord/users',
        name: 'users',
        component: Users,
    },
    {
        path: '/dashbord/analytics',
        name: 'analytics',
        component: Analytics
    },
    {
        path: '/dashbord/notifications',
        name: 'notifications',
        component: Notifications
    },
    
    
    
]

const router = new VueRouter({
    beforeEnter: auth,
    mode: 'history',
    routes
})

const app = new Vue({
    router,
    
    el: '#admin',
    render: h => h(Admin)
});