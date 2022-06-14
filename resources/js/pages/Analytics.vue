<template>
<div>
      <main>
            <!-- end of insights-->
            <div class="recent-orders">
                <h1>Analytics</h1>
                <div>
            <div style="margin-top: 40px">

                <h2>Orders Tracking:</h2>
                        </div>

<line-chart loading="Loading..." suffix=" MAD" :data="this.orderData" :curve="false" ytitle="Total" xtitle="Time">

</line-chart>
</div>
 
  <div>
            <div style="margin-top: 40px">

                <h2>Orders Status:</h2>
                        </div>

                        <pie-chart  :colors="['#8E1111', '#118D8E', '#228E11']" :data="this.statusData"></pie-chart>


</div>
  <div >
            <div style="margin-top: 40px">

                <h2>Most Popular Products:</h2>
                        </div>

                        <bar-chart :data="this.productsData"></bar-chart>


</div>

 



</div>
</main>
</div>
</template>

<script>
import moment from "moment";
export default {
    name: 'analytics',

    data() {
        return {
            orders : {},
            orderData: {},
          
            status: [],
            statusData: [],
            products : {},
            productsData: [],
            customers: {},
        }
    },
    methods : {
        getAnalytics() {
            console.log('hello mtf');
            axios.get('/api/analytics').then(res => {
                /* start of tracking orders*/
                let arr1 = [];
                let arr2 = [];
                this.orders = res.data.orders;
               for (const x in this.orders) {
                
                  arr1.push(this.orders[x].created_at);
                  arr2.push(this.orders[x].total);
                   
               }
               this.orderData = arr1.reduce((accumulator, element, index) => {
  return {...accumulator, [element]: arr2[index]};
}, {});
/* end of tracking orders */
/* start of order status */

    this.status = res.data.status;

let stt1 = [];
    for(const x in this.status) {
        stt1.push(this.status[x].status, this.status[x].number_of_orders);
        
        
    }
    while (stt1.length) {
        this.statusData.push(stt1.splice(0,2))
    }
    /* end of order status */
/* start of products */
this.products = res.data.products;
console.log(this.products);
let prr1 = [];
    for(const x in this.status) {
        prr1.push(this.products[x].name, this.products[x].order_count);
        
        
    }
    while (prr1.length) {
        this.productsData.push(prr1.splice(0,2))
    }
    /* end of products */



             
            }).catch(err => console.log(err));
        }
    },
    mounted() {
        this.getAnalytics();
    }
}
</script>

<style>
.chart-half {
    width: 50%;
    float: left;
}
</style>