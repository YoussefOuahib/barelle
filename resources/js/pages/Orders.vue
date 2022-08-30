<template>
  <div>
    <main>
      <!-- end of insights-->
      <div class="recent-orders">
        <h2>Orders</h2>

        <div class="control-panel">
          <div>
            <label for="payment">Payment:</label>
            <select v-model="payment" name="payment" class="selectform">
              <option value="">All</option>
              <option value="cod">Cash on delivery</option>
              <option value="direct_bank_transfert">Direct Bank Transfert</option>
              <option value="paypal">PAYPAL</option>

            </select>
            <label for="status">Status:</label>
            <select v-model="status" name="status" class="selectform">
              <option value="">All</option>
              <option value="pending">Pending</option>
              <option value="confirmed">Confirmed</option>
              <option value="shipped">Shipped</option>
              <option value="delivered">Delivered</option>
              <option value="canceled">Canceled</option>

            </select>
          </div>
          <table>
            <thead>
              <tr>
                <th></th>
                <th @click="filterByTotal" style="cursor: pointer">Total
                  <span v-if="this.filterTotalDown == true">
                    <i class="fa-solid fa-chevron-up"></i> </span>
                  <span v-if="this.filterTotalUp == true">
                    <i class="fa-solid fa-chevron-down"></i> </span>
                </th>
                <th>Qty</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th></th>

              </tr>
            </thead>

            <tbody>
              <tr v-for="order in orders.data" :key="order.id">

                <td>#{{ order.number }}</td>
                <td>{{ order.total }}</td>
                <td>{{ order.qty }}</td>
                <td>{{ order.status }}</td>
                <td>{{ order.payment }}</td>
                <td>{{ order.date }}</td>



                <td style="cursor: pointer; color: #209cf0;" @click="getOrder(order.id)">
                  Details


                </td>


              </tr>

            </tbody>
          </table>
        </div>
        <div class="pagination">
        </div>
      </div>
    </main>
    <div class="modal-vue">


      <!-- overlay -->
      <div class="overlay" v-if="showModal" @click="showModal = false"></div>

      <!-- modal -->
      <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showModal">
        <button class="close" @click="showModal = false"><span style="cursor: pointer"
            class="danger material-icons-sharp">clear</span></button>
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Order</h3>
          </div>
          <div class="modal-body">
            <table class="table mt-4">
              <thead>
                <tr>
                  <th scope="col">Customer</th>

                  <th scope="col">Address</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone</th>

                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ order.customer }}</td>

                  <td>{{ order.address }}</td>
                  <td>{{ order.email }}</td>
                  <td>{{ order.phone }}</td>
                </tr>

              </tbody>
            </table>

            <div class="myform">
              <label for="status">Status:</label>
              <div>
                <select required v-model="order.status" class="inputform">
                  <option :selected="order.status == 'Pending' ? 'selected' : ''" value="Pending">Pending</option>
                  <option :selected="order.status == 'Confirmed' ? 'selected' : ''" value="Confirmed">Confirmed</option>
                  <option :selected="order.status == 'Shipped' ? 'selected' : ''" value="Shipped">Shipped</option>
                  <option :selected="order.status == 'Delivered' ? 'selected' : ''" value="Delivered">Delivered</option>
                  <option :selected="order.status == 'Canceled' ? 'selected' : ''" value="Canceled">Canceled</option>


                </select>
              </div>
            </div>
            <div class="myform">
              <label for="is_paid">Paid ?</label>
              <div>
                <select required name="is_paid" v-model="order.is_paid" class="inputform">
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>


                </select>
              </div>
            </div>
            <div>
            </div>
            <br>
            <table class="table mt-4">
              <thead>
                <tr>
                  <th scope="col">Image</th>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Attributes</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in order.products" :key="index">
                  <td><img height="100px" width="100px" style="border-radius: 20px; margin: 0 auto;"
                      :src="'/storage/images/' + product.image"></td>
                  <td>{{ product.name }}</td>
                  <td>{{ product.price[index] }}</td>
                  <td>{{ product.attributes[index] }}</td>
                </tr>

              </tbody>
            </table>

          </div>
          <div class="modal-footer">
            <button type="button" @click="updateOrder()" class="btn btn-primary"> <i
                class="fa-light fa-plus"></i>Update</button>
            <button type="button" @click="showModal = false" class="btn btn-danger"> <i
                class="fa-solid fa-xmark"></i>Close</button>

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
  name: "order",
  data() {
    return {
      message: '',
      orders: {},
      order: { id: '', status: '', is_paid: '' },
      showModal: false,
      status: '',
      payment: '',
      filterTotalUp: null,
      filterTotalDown: null,
      filterTotal: 2,


    }
  },
  methods: {
    filterByTotal() {
      if (!this.filterTotalUp && !this.filterTotalDown) {
        this.filterTotalUp = true;
        this.filterTotalDown = null;
        this.filterTotal = 0;
      }
      else if (this.filterTotalUp) {
        this.filterTotalUp = null;
        this.filterTotalDown = true;
        this.filterTotal = 1;
      }
      else if (this.filterTotalDown) {
        this.filterTotalUp = null;
        this.filterTotalDown = null;
        this.filterTotal = 2;
      }
      this.getOrders();
    },
    getOrders(page = 1) {
      
      axios.get('/api/admin/orders?page=' + page
        + '&status=' + this.status
        + '&payment=' + this.payment
        + '&filterTotal=' + this.filterTotal
      ).then(res => {
        this.orders = res.data;
      }).catch(err => console.log(err));
    },
    getOrder(id) {
      this.showModal = true;
      axios.get('/api/admin/orders/' + id)
        .then(res => {

          this.order = res.data.data;
        }).catch(error => console.log(error));
    },
    updateOrder() {
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }
      let formData = new FormData();
      formData.append('status', this.order.status);
      formData.append('is_paid', this.order.is_paid);
      formData.append("_method", "put");

      axios.post(`/api/admin/orders/${this.order.id}`, formData, config).then(res => {
        if (res.data.status == 201) {
          Swal.fire(
            'Done',
            'order has been Successfully updated',
            'success'
          )
          this.getOrders();
          this.order = {};
        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something is wrong here !',

          });
        }

      }).catch(err => console.log(err))
    },



  },
  watch: {
    payment: function () {
      this.getOrders()
    },
    status: function () {
      this.getOrders()
    },
  },
  mounted() {

    this.getOrders();
  }
}
</script>

<style scoped>
th span i {
  color: #209cf0;
}
</style>