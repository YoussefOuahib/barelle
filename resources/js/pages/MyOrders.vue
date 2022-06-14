<template>
    <div>
          <div class="breadcumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                My Orders
            </div>
        </div>
    </div>
</div>

<table class="table table-striped">
  <thead>
    <tr>
     
      <th scope="col">Products</th>
      <th scope="col" >Amount</th>
      <th scope="col">Status</th>
      <th scope="col">Date</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="order in orders.data" :key="order.id">
      <th>{{order.product}}</th>
      <td>{{order.total}} MAD</td>
      <td>{{order.status}}</td>
      <td>{{order.date}}</td>
      <td>
          <button type="button" data-toggle="modal" data-target="#exampleModal2" @click="getOrder(order.id)" class="btn btn-primary">
              <i class="fa-solid fa-eye"></i>
              </button>

      </td>
    </tr>
 
    
  </tbody>
</table>
    <div class="pagination">
              <Pagination  :data="orders" @pagination-change-page="getOrders" />
              </div> 
<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table mt-4">
    <thead>
      <tr>
       <th scope="col">Image</th>
        <th scope="col">Product</th>
        <th scope="col">Attributes</th>
        <th scope="col">Price</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(product,index) in order.products" :key="index">
           <td><img height="100px" width="100px" style="border-radius: 20px; margin: 0 auto;" :src="'/products/' + product.image"></td>
           <td>{{product.name}}</td>
           <td>{{order.attributes[index]}}</td>
           <td>{{product.price[index]}} MAD</td>
      </tr>
      
    </tbody>
  </table>
      
        <div class="container ">
    <div class="card">
        <div class="row d-flex justify-content-between top">
            <div class="d-flex">
                <h5>ORDER: <span class="text-primary font-weight-bold">#{{order.number}}</span></h5>
            </div>
            <div class="d-flex flex-column text-sm-right">
                <p class="mb-0">Your order status:  <span>{{order.status}}</span></p>
            </div>
        </div>
        <!-- Add class 'active' to progress -->
        <div class="row d-flex justify-content-center">
            <div class="col-12">
            <ul v-if="order.status != 'Canceled'" id="progressbar" class="text-center">
                <li class="active step0">
                  Processing
                </li>
                <li :class="order.status ==  'Confirmed'  || order.status == 'Shipped' || order.status == 'Delivered' ? 'active' : '' "  class="step0">
                  Confirmed
                </li>
                <li :class="order.status == 'Shipped' || order.status == 'Delivered' ? 'active' : '' " class="step0">
                  Shipped

                </li>
                <li :class="order.status == 'Delivered' ? 'active' : '' " class="step0">
                    Delivered
                </li>
            </ul>
            </div>
        </div>
      
    </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    </div>
</template>
<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
     components: {
        'Pagination': LaravelVuePagination

    },
    data() {
        return {
            orders: {},
            order: {},
            showModal : false,
        }
    },
    methods: {
        getOrders(page = 1) {
          
            axios.get('/api/orders?page=' + page).then(res => {
                this.orders = res.data;
            }).catch(err => console.log(err));
        },
          getOrder(id)
            {
              
                 axios.get('/api/orders/' + id)
                .then(res => {
                  
                    this.order = res.data.data;
                }).catch(error => console.log(error));
            },
    },
    mounted(){
        this.getOrders();
    }
}
</script>

<style scoped>

.card {
    z-index: 0;
    background-color: #ECEFF1;
    padding-bottom: 20px;
    margin-top: 10px;
    margin-bottom: 90px;
    border-radius: 10px;
}

.top {
    padding-top: 40px;
    padding-left: 13% !important;
    padding-right: 13% !important;
}

/*Icon progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: #455A64;
    padding-left: 0px;
    margin-top: 30px;
} 

#progressbar li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
}

#progressbar .step0:before {
    font-size: 20px;
    font-family: FontAwesome;
    content: "\f10c";
    color: #fff;
}

#progressbar li:before {
    width: 40px;
    height: 40px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    background: #C5CAE9;
    border-radius: 50%;
    margin: auto;
    padding: 0px;
}

/*ProgressBar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 12px;
    background: #C5CAE9;
    position: absolute;
    left: 0;
    top: 16px;
    z-index: -1;
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    left: -50%;
}

#progressbar li:nth-child(2):after, #progressbar li:nth-child(3):after {
    left: -50%;
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    position: absolute;
    left: 50%;
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

/*Color number of the step and the connector before it*/
#progressbar li.active:before, #progressbar li.active:after {
    background: #026670;
}

#progressbar li.active:before {
    font-family: FontAwesome;
    content: "\f00c";
}

.icon {
    width: 60px;
    height: 60px;
    margin-right: 15px;
}

.icon-content { 
    padding-bottom: 20px;
}

@media screen and (max-width: 992px) {
    .icon-content {
        width: 50%;
    }
}
/*
.modal-content {
    width: 150%;
    right: 25%;
}
*/
</style>