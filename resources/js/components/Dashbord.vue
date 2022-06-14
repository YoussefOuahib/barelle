<template>
    <div>
            <main>
            <h1>Dashbord</h1>
            
<!-- start of insights-->
            <div class="insights">
                  <!-- start of sales-->
                  <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Sales</h3>
                            <h2>{{this.sales}}MAD</h2>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p>{{this.sales_count}} Order</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of sales-->
                <!-- start of expenses-->
                <div class="expenses">
                    <span class="material-icons-sharp">bar_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Pending Orders</h3>
                            <h2>{{this.pending}}MAD</h2>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p>{{this.pending_count}} Order</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of expenses-->
                  <!-- start of income-->
                  <div class="income">
                    <span class="material-icons-sharp">stacked_line_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Paid Orders</h3>
                            <h2>{{this.paid}}MAD</h2>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p>{{this.paid_count}} Order</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of income-->
                
            </div>
            <!-- end of insights-->
            <div class="recent-orders">
                <h2>Recent Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Payment</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Paid ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td>{{order.product}} </td>
                            <td>{{order.payment}}</td>
                            <td>{{order.total}} MAD</td>
                            <td>{{order.status}}</td>
                            <td>{{order.is_paid}}</td>
                        </tr>
                       
                    </tbody>
                </table>
                 <router-link :class="this.$route.name == 'orders' ? 'active': ''" :to="{ name: 'orders' }">
                 Show all 
                 </router-link>
            </div>

            <div class="recent-orders">
                <h2>New Customers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                      
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers" :key="customer.id">
                            <td>{{customer.name}} </td>
                            <td>{{customer.phone}}</td>
                            <td>{{customer.email}} </td>
                           
                        </tr>
                       
                    </tbody>
                </table>
                 <router-link :class="this.$route.name == 'users' ? 'active': ''" :to="{ name: 'users' }">
                 Show all 
                 </router-link>
            </div>
        </main>
        <!-- end of main -->     


    </div>
</template>
<script>

export default {
    name: "Dashbord",
    data() {
        return {
            pending_count: '',
            pending: '',
            sales_count: '',
            sales: '',
            paid_count : '',
            paid: '',
            orders: {},
            customers: {},
        }
    },
        methods: {
         getAnalytics() {
             axios.get('/api/dashbord/analytics').then(res => {
                 this.paid_count = res.data.paid_count;
                 this.paid = res.data.paid;
                 this.sales_count = res.data.sales_count;
                 this.sales = res.data.sales;
                 this.pending_count = res.data.pending_count;
                 this.pending = res.data.pending;
                 this.orders = res.data.orders;
                 this.customers = res.data.customers;
                 console.log(this.orders);

             }).catch(err => console.log(err))
         },
         
        },

        mounted() {
            this.getAnalytics();
        }
    }

    
    
    

</script>