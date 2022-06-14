import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from './pages/Auth/Login.vue'
import Register from './pages/Auth/Register.vue'
import Home from './pages/Home.vue'
import Product from './pages/Product.vue'
import Verify from './pages/Auth/Verify.vue'
import Checkout from './pages/Checkout.vue'
import Store from './pages/Store.vue'
import MyOrders from './pages/MyOrders.vue'
import browseByCategory from './pages/Store/browseByCategory'
import browseBySubcategory from './pages/Store/browseBySubcategory'
import About from './pages/About'



Vue.use(VueRouter);



const router = new VueRouter({
    mode: 'history',

    
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login 
        },
       
        
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/myorders',
            name: 'myorders',
            component: MyOrders
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
     
        {
            path: '/verify',
            name: 'verify',
            component: Verify
        },
        {
            path: '/product/:slug',
            name: 'product',
            component: Product
    
        },
        {
            path: '/checkout',
            name: 'checkout',
            component: Checkout
    
        },
        {
            path: '/store',
            name: 'store',
            component: Store
    
        },
        {
            path: '/store/:category',
            name: 'browseByCategory',
            component: browseByCategory
    
        },
        
        {
            path: '/store/subcategory/:subcategory',
            name: 'browseBySubcategory',
            component: browseBySubcategory
    
        },
        {
            path: '/about',
            name: 'About',
            component: About
        }
        
       
      
       
      
       
        
    ]
});

export default router;
