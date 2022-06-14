
<template>
<div>
  <section class="top">
        <div class="subnavbar">
            <div class="container">
                <div class="left-side">
                    <h3>{{this.settings.header_text}}</h3>
                </div>
                <div class="right-side">
                <ul class="pulp-list">
                    <span v-if="!isLoggedIn" class="material-icons-sharp ml-2">person_add</span> <li v-if="!isLoggedIn" class="pulp-list-group"><router-link :to="{ name: 'register' }">Register</router-link> |</li>
                    <span v-if="!isLoggedIn" class="material-icons-sharp ml-2">person_outline</span> <li v-if="!isLoggedIn" class="pulp-list-group"> <router-link :to="{ name: 'login' }">Login</router-link> </li>
                    <span v-if="isLoggedIn"  class="material-icons-sharp ml-2">inventory</span> <li style="cursor:pointer" v-if="isLoggedIn"  class="pulp-list-group"> <router-link :to="{ name: 'myorders' }">Orders</router-link> </li>

                    <span v-if="isLoggedIn"  class="material-icons-sharp ml-2">logout</span> <li style="cursor:pointer" v-if="isLoggedIn" @click="logout" class="pulp-list-group">Logout</li>
                    

                </ul>
                </div>
            </div>
        </div>
        <div class="mid-navbar">
            <div class="container">
            <div class="row">
                <div class="col-3">
            <div class="brand">
              <router-link :to="{name: 'home'}">
                <img :src="'/storage/products/' + this.settings.logo" width="150px" height="80px" >
              </router-link>
            </div>
            </div>
            <div class="col-6">
            <div class="search-box">
                <input type="text" v-model="searching" placeholder="Search ...">
                <div v-if="searching" class="search-autocomplete">
                  <ul v-for="product in products" :key="product.id">
                    <li>
                      <router-link :to="{ name: 'product', params: { slug: product.slug }}">{{product.name}}</router-link>
                      </li>
                  </ul>
                </div>
            </div>
            </div>

            <div class="col-3">
            <div class="account">
              <!--
                <small class="account-button"><span class="material-icons-sharp ml-2">person_outline </span></small> 
                <ul class="account-dropdown">
                   <li><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</li>
                   <li ><i class="fa-solid fa-user-plus"></i> Register</li>
                </ul>
                -->
                <a data-toggle="modal" data-target="#exampleModal" style="color: #363949; cursor: pointer"><span class="material-icons-sharp ml-2">shopping_cart</span>{{this.badge }}</a>
            </div>
            </div>
            </div>
            </div>

        </div>

    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shopping Cart </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
  <thead>
    <tr>
      
      <th scope="col">Product</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
      <th scope="col"> </th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="item in cart" :key="item.id">
      
      <td>{{item.product}}</td>
      <td>{{item.quantity}}</td>
      <td>{{item.price}}</td>
      <td><button @click="removeCart(item.id)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button></td>
    </tr>
    
<hr>
    <h5 class="text-center">Subtotal: {{this.subtotal}}MAD</h5>
  </tbody>
</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" @click="Checkout" data-dismiss="modal" class="btn btn-primary">Checkout</button>
      </div>
    </div>
  </div>
</div>
    <section class="top-mobile">
      <nav class="navbar navbar-light bg-light">
        <div class="navbar-brand" @click="sidebarSeen">
          <span id="sidebarCollapse"  style="cursor: pointer;">
            <i class="fa-solid fa-bars"></i>
          </span>
          <img src="images/logo.png" width="70" height="70" >
        </div>
        <div class="account float-right mr-4">
          <span style="cursor: pointer" data-toggle="modal" data-target="#exampleModal5" class="material-icons-sharp">search</span>
          <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
         <input type="text" v-model="searching" placeholder="Search ...">
                <div v-if="searching" class="search-autocomplete">
                  <ul v-for="prod in prods" :key="prod.id">
                    <li  data-dismiss="modal">
                      <router-link :to="{ name: 'product', params: { slug: prod.slug }}">{{prod.name}}</router-link>
                      </li>
                  </ul>
                </div>
      </div>
    
    </div>
  </div>
</div>
          <small class="account-button"><span class="material-icons-sharp ml-2">person_outline </span></small> 
          <ul class="account-dropdown-mobile" style="z-index: 99999999;">
            <li v-if="isLoggedIn" ><i class="fa-solid fa-truck-fast"></i> Orders </li>

             <li v-if="!isLoggedIn" ><i class="fa-solid fa-arrow-right-to-bracket"></i> <router-link :to="{ name: 'login' }">Login</router-link> </li>
             <li v-if="!isLoggedIn" ><i class="fa-solid fa-user-plus"></i> <router-link :to="{ name: 'register' }">Register</router-link> </li>
            <li v-if="isLoggedIn" style="cursor:pointer" @click="logout" ><i class="fa-solid fa-right-from-bracket"></i> Logout</li>

          </ul>
           <a href="#" data-toggle="modal" data-target="#exampleModal" style="color: #363949;"><span class="material-icons-sharp ml-2">shopping_cart</span>{{this.badge }}</a>

      </div>
      </nav>
      
      <div class="wrapper" v-show="this.sidebar">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4 class="text-center">All Departments</h4>
                <hr>
            </div>
            <ul class="list-unstyled components">
                <li v-for="(category,index) in categories" :key="index"> 
                  <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">{{category.name}}</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                      <br>
                        <li v-for="(subcategory,index) in category.subcategories" :key="index" >
                          <router-link :to="{ name: 'browseBySubcategory', params: { subcategory: subcategory.id }}" >{{subcategory.name}}</router-link> </li>
                 
                    </ul>
                </li>
               
               
            </ul>
                                                                                                                                 
        </nav>
      </div>
    </section>
    <main>
      
        <div class="under-navbar">
    
              <div class="cm-e-menu">
            <ul>
                <li class="topmenu">
            <button class="btn  font-weight-bold" type="button">
              <i class="fa-solid fa-list"></i> All Departments
            </button>
                    <ul class="submenu">
                       
                     
                        <li v-for="(category,index) in categories" :key="index">
                            <router-link :to="{ name: 'browseByCategory', params: {category: category.id} }" >{{category.name}}</router-link>
                            <ul class="submenu">
                                <li v-for="(subcategory,ind) in category.subcategories" :key="ind" >
                                  <router-link :to="{ name: 'browseBySubcategory', params: { subcategory: subcategory.id }}" >{{subcategory.name }}</router-link></li>
                              
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
             </div>
              <div class="pages">
                  <router-link :to="{name: 'store'}">Store</router-link>
                  <router-link :to="{name: 'contact'}">Contact</router-link>
                  <router-link :to="{name: 'about'}"> About us</router-link>

              </div>
            </div>

    </main>
    
      <router-view @cart="getCart" ></router-view>
     <div class="newsletter-subscribe mt-5 container">
    <div class="container">
        <div class="intro">
            <h2 class="text-center newsletter">{{this.settings.newsletter_header}}</h2>
            <p class="text-center">{{this.settings.newsletter_text}}</p>
        </div>
        <form class="form-inline" method="post">
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Your Email"></div>
            <div class="form-group"><button class="btn btn-primary" type="button">Subscribe </button></div>
        </form>
    </div>
</div>

<footer class="text-center text-lg-start bg-light text-muted">
  <!-- Section: Social media -->
 
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="links">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>{{this.settings.name}}
          </h6>
          <p>
            {{this.settings.footer_description}}
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Products
          </h6>
          <p>
            <a href="#!">Angular</a>
          </p>
          <p>
            <a href="#!">React</a>
          </p>
          <p>
            <a href="#!">Vue</a>
          </p>
          <p>
            <a href="#!">Laravel</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Useful links
          </h6>
          <p>
            <a href="#!">Pricing</a>
          </p>
          <p>
            <a href="#!">Settings</a>
          </p>
          <p>
            <a href="#!">Orders</a>
          </p>
          <p>
            <a href="#!">Help</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Contact
          </h6>
          <p><i class="fas fa-home me-3"></i> {{this.settings.address}}</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            {{this.settings.email}}
          </p>
          <p><i class="fas fa-phone me-3"></i>{{this.settings.phone_number}}</p>
        
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    
    <a class="text-reset fw-bold">Developped By YOUSSEF OUAHIB</a>
  </div>
  <!-- Copyright -->
</footer>
</div>
</template>

<script>
import logo from '../assets/images/logo.png'
import Login from '../pages/Auth/Login.vue'
import Register from '../pages/Auth/Register.vue'


export default {
  
  components: {Login, Register},
  
  data () {
    return {
      name: JSON.parse(localStorage.getItem('name')) || '' ,
      subcategories: {},
      settings: { name: '', address: '', phone_number: '', email: '',logo: '',footer_description: '',map: '',header_text:'',newsletter_header:'',newsletter_text:'' },
      sidebar: false,
      categories: {},
      searching : '',
      products: {},
      prods: {},
      cart: JSON.parse(localStorage.getItem('cart')) || '' ,
      total_price : 0,
      carts : {},
      isLoggedIn: JSON.parse(localStorage.getItem('logged')) || false,
      isAdmin: JSON.parse(localStorage.getItem('admin')) || false,
      logo : logo,
      badge: 0,
    }
  },

computed: {
  subtotal: function(){
    if(localStorage.getItem('cart')) {
          return this.cart.reduce((price,item) => {
            return price + item.quantity * item.price
                }, 0);
        
        
        }
  },
},
  methods: {
    sidebarSeen() {
      if(this.sidebar == false){
      this.sidebar = true;
      }
      else {
        this.sidebar = false;
      }
    },
   
    getSettings() {
         axios.get('/api/settings')
                .then(res => {
            
              
                    this.settings = res.data.settings;
                    this.previewImg = this.settings.logo;

                   


                    
                   

                }).catch(error => console.log(error));
    },
    search() {
         axios.get('/api/search/products?searching=' + this.searching)
                .then(res => {
            
              
                    this.products = res.data.products;
                    this.prods = res.data.products;
                    console.log(this.products);
                    

                   


                    
                   

                }).catch(error => console.log(error));
    },
    getCategories() {
            axios.get('/api/browse/categories').then(res => {
             
                this.categories = res.data.categories;
                console.log('hello categories');
                console.log(this.categories);
            }).catch(err => console.log(err));
        },
    removeCart(item){
     for (var i =0; i< this.cart.length; i++) {
   
    if (this.cart[i].id == item) {
        this.cart.splice(i, 1);
    }

}
this.badge = this.cart.length;

var ss = JSON.stringify(this.cart);
localStorage.setItem("cart", ss);
      
    },
    viewCart()
    {
      if(localStorage.getItem('cart')) {
          this.total_price = this.cart.reduce((price,item) => {
            return price + item.quantity * item.price
                }, 0);
        
        this.badge = this.cart.length;
        }
        },
     getCart(cart)
     {
       this.cart = cart;
       this.badge = cart.length;
       },
      Checkout(){
        this.$router.push({name: "checkout"});
      },
          
    
  
    logout() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/api/logout').then(res => {
                        if (res.data.message) {
                          this.isLoggedIn = false;
                            localStorage.removeItem('logged');
                              localStorage.removeItem('admin');


                          this.$router.go('/');

                        } else {
                            console.log(res);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
    });
    }
  },
     mounted() {
        this.getCategories();
        this.getSettings();
       
    },
    watch : {
      searching: function() {
        this.search();
      },
     
    },
    created() {
      this.viewCart();
    }
}
</script>
<style scoped>
@import '../assets/navbar/style.css';

</style>