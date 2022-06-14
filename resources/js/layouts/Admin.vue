<template>
<div>
     <div class="container">
            <aside :class="seen == true ? 'seen' : 'unseen'" > 
                <div class="top">
                    <div class="logo">
                        <img src="" alt="logo">
                        <h2>PA<span class="danger">PPY </span></h2>
                    </div>
                    <div id="close-btn" @click="seen = false" class="close">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>
                <div class="sidebar">
                    <router-link  :class="this.$route.name == 'dashbord' ? 'active': ''" :to="{ name: 'dashbord' }">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3>Dashbord</h3>
                    </router-link>
                    
                <router-link  :class="this.$route.name == 'sliders' ? 'active': ''" :to="{ name: 'sliders' }">

                        <span class="material-icons-sharp">home</span>
                        <h3>Sliders</h3>
                   </router-link>
                   <router-link  :class="this.$route.name == 'banners' ? 'active': ''" :to="{ name: 'banners' }">

                        <span class="material-icons-sharp">perm_media</span>
                        <h3>Banners</h3>
                   </router-link>
                    <router-link :class="this.$route.name == 'categories' ? 'active': ''" :to="{ name: 'categories' }">
                        <span class="material-icons-sharp">category</span>
                        <h3>Categories</h3>
                    </router-link>

                       <router-link :class="this.$route.name == 'subcategories' ? 'active': ''" :to="{ name: 'subcategories' }">
                        <span class="material-icons-sharp">list_alt</span>
                        <h3>Subcategories</h3>
                    </router-link>
                     <router-link :class="this.$route.name == 'products' ? 'active': ''" :to="{ name: 'products' }">
                        <span class="material-icons-sharp">inventory</span>
                        <h3>Products</h3>
                    </router-link>
                    <router-link :class="this.$route.name == 'attributes' ? 'active': ''" :to="{ name: 'attributes' }">
                        <span class="material-icons-sharp">tune</span>
                        <h3>Attributes</h3>
                    </router-link>
                    
                  <router-link :class="this.$route.name == 'users' ? 'active': ''" :to="{ name: 'users' }">

                        <span class="material-icons-sharp">people_alt</span>
                        <h3>Customers</h3>
                  </router-link>
                     <router-link :class="this.$route.name == 'orders' ? 'active': ''" :to="{ name: 'orders' }">

                        <span class="material-icons-sharp">receipt_long</span>
                        <h3>Orders</h3>
                   </router-link>
                    <router-link :class="this.$route.name == 'analytics' ? 'active': ''" :to="{ name: 'analytics' }">
                        <span class="material-icons-sharp">insights</span>
                        <h3>Analytics</h3>
                    </router-link>
                    <router-link :class="this.$route.name == 'notifications' ? 'active': ''" :to="{ name: 'notifications' }">
                        <span class="material-icons-sharp">inbox</span>
                        <h3>Notifications</h3>
                    </router-link>
                   
                    <router-link :class="this.$route.name == 'settings' ? 'active': ''" :to="{ name: 'settings' }">
                        <span class="material-icons-sharp">settings</span>
                        <h3>Settings</h3>
                    </router-link>
                   
                    <a href="#">
                        <span class="material-icons-sharp">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>
        
        <!-- end of sidebar-->
<router-view></router-view>  
          <div class="right">
            <div class="top">
                <button @click="seen = true" id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span @click="setTheme('light')" :class="this.themeMode == 'light' ? 'active' : ''" class="material-icons-sharp">light_mode</span>
                    <span @click="setTheme('dark')" :class="this.themeMode == 'dark' ? 'active' : ''" class="material-icons-sharp">dark_mode</span>

                </div>
                
                <div class="notifications">
                    <span style="cursor:pointer"  @click="showNotifications">
                           <i  style="font-size: 20px" class="fa-solid fa-bell"></i>
                           <b>{{this.unreadNotifications.length}}</b>
                       </span>
                        <div class="recent-notifications" v-show="showNotif" >
                    <div v-for="notification in unreadNotifications" class="notification">
                        
                        <div class="message">
                            <router-link  :to="{ name: notification.data.link}">
                        
                            <p>{{notification.data.label}}</p>
                            <small class="text-muted">{{  notification.data.order.created_at }}</small>
                            </router-link>
                        </div>
                    </div>
                   
            </div>
                </div>
               
                <div class="profile">
                    
                    <div class="info">
                        <p>Hey, <b>Daniel</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    
                </div>
            </div>
            <div class="recent-updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update"  v-for="(update,index) in unreadNotifications" :key="index">
                        <div class="profile-photo">
                            <img src="" alt="">
                        </div>
                        <div class="message" v-if="index < 2">
                            <p><b>{{update.data.link}} : </b> {{update.data.label}}</p>
                            <small class="text-muted">{{update.data.order.created_at}}</small>
                        </div>
                    </div>
                  
                </div>
            </div>
            <!-- end of recent updates-->
            <div class="sales-analytics">
                <h2>Sales Analytics</h2>
                <div class="item completed">
                    <div class="icon">
                        <span class="material-icons-sharp">shopping_cart</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Completed Orders</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="success">+{{this.completed}}</h5>
                        <h3>{{this.all_completed}}</h3>
                    </div>
                </div>
                <div class="item pending">
                    <div class="icon">
                        <span class="material-icons-sharp">pending</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Pending Orders</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="danger">+{{this.pending}}</h5>
                        <h3>{{this.all_pending}}</h3>
                    </div>
                </div>
                <div class="item customers">
                    <div class="icon">
                        <span class="material-icons-sharp">person</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>New Customers</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="success">+{{this.customers}}</h5>
                        <h3>{{all_customers}}</h3>
                    </div>
                </div>
              
            </div>
        </div>
</div>
</div>

</template>
<script>

export default {
  name: 'admin',
  
 data() {
   return {
     unreadNotifications : {},
     all_completed: 0,
     completed: 0,
     pending: 0,
     all_pending: 0,
     customers: 0,
     all_customers: 0,
     showNotif: false,

     themeMode : localStorage.getItem('userTheme') || 'light',
     seen: true,
   };
   
 },
  
    
    
    
   methods: {
    
      setTheme(theme) {
        
   
    localStorage.setItem("userTheme", theme);
    this.themeMode = theme;
    document.documentElement.className = theme;
    console.log(this.themeMode);
  },
  showNotifications() {
      if(this.showNotif == false) {
      this.showNotif = true;
      }
      else {
          this.showNotif = false;
      }
  },
  data() {
      axios.get('/api/admin/data').then(res => {
          this.completed = res.data.completed;
          this.all_completed = res.data.all_completed;
          this.pending = res.data.pending;
          this.all_pending = res.data.all_pending;
          this.customers = res.data.customers;
          this.all_customers = res.data.all_customers;
      }).catch(err => console.log(err))
  },
  getNotifications() {
      axios.get('/api/dashbord/notifications').then(res => {
          this.unreadNotifications = res.data;
       
      }).catch(err => console.log(err));
  }
   },
   mounted() {
         document.documentElement.className = this.themeMode;
         this.data();
         this.getNotifications();
         

   }
}
</script>
<style scoped>
.seen {
  display: block;
}
.unseen {
  display: none;
}
.recent-notifications {
    background: #202528;
    position: absolute;
    top: 50px;
    float: left;
}
.notification {
    padding: 10px;
}
.notification:hover {
    background: #181a1e;
}
</style>