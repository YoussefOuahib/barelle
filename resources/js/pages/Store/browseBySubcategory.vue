<template>
  <div>
    <div class="breadcumb">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            Browse
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <!-- container -->
      <div class="container">
        <!-- row -->
        <div class="row">

          <!-- /ASIDE -->

          <!-- STORE -->
          <div id="store" class="col-md-12">
            <!-- store top filter -->
            <div class="store-filter clearfix">
              <div class="store-sort">
                <label>
                  Sort By:
                  <select v-model="sortby" class="input-select">
                    <option :value="0">Newest</option>
                    <option :value="1">Ascending price</option>
                    <option :value="2">Descending price</option>
                    <option :value="3">Popular</option>

                  </select>
                </label>


              </div>

            </div>
            <!-- /store top filter -->

            <!-- store products -->
            <div class="row">
              <!-- product -->
              <div v-for="(product, index) in products.data" :key="index" class="col-md-4 col-xs-6">


                <div class="product">
                  <div class="product-img">
                    <img :src="'/storage/images/' + product.image" alt="">

                  </div>

                  <div class="product-body">
                    <p class="product-category">{{ product.category }}</p>
                    <h3 class="product-name">
                      <router-link :to="{ name: 'product', params: { slug: product.slug } }">{{ product.name }}
                      </router-link>
                    </h3>
                    <h4 class="product-price">{{ product.sale_price }} MAD <del
                        class="product-old-price">{{ product.regular_price }} MAD</del></h4>

                    <div class="product-btns">
                      <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to
                          wishlist</span></button>
                      <button class="quick-view">
                        <router-link :to="{ name: 'product', params: { slug: product.slug } }"><i class="fa fa-eye"></i>
                        </router-link><span class="tooltipp">quick view</span>
                      </button>
                    </div>
                  </div>
                  <div class="add-to-cart">
                    <button data-toggle="modal" data-target="#exampleModal3" @click="getProduct(product.slug)"
                      class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                  </div>
                </div>

              </div>

            </div>


            <div class="clearfix visible-sm visible-xs"></div>

            <!-- store bottom filter -->
            <div class="store-filter clearfix">

              <span class="store-qty">Showing 20-100 products</span>
              <Pagination align="center" :data="products" @pagination-change-page="loadProducts" />



            </div>

            <!-- /store bottom filter -->
          </div>
          <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ this.product.name }}</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="product-image float-left mx-4">
                    <img height="200px" width="200px" :src="'/storage/images/' + this.product.image">

                  </div>
                  <div class="product-content">
                    <p>{{ this.product.short_description }}</p>

                    <br>
                    <span class="shipping">Shipping fee: {{ this.product.shipping_fee }} MAD</span>
                    <br>
                    <span class="price">{{ this.total > 0 ? this.total : this.product.sale_price }} MAD</span>

                    <div class="form-inline attributes">
                      <label v-for="(attr, index) in attributes.attribute" :key="index">{{ attr }}:
                        <select name="attributes" @change="selectAttribute(index)" v-model="selected[index]"
                          class="form-control ml-2">
                          <option v-for="(value, ind) in attributes.values[index]"
                            :value="{ myprice: attributes.prices[index][ind], myvalue: value }" :key="ind">{{ value }}
                          </option>

                        </select>
                      </label>

                    </div>
                    <div class="input-group form-inline">
                      <label class="mr-4">QTY: </label>
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-info" @click="decrement" type="button">-</button>
                      </div>
                      <input class="form-control" disabled v-model="cart.quantity" type="number" max="10" min="1">
                      <div class="input-group-append">
                        <button class="btn btn-outline-info" @click="increment" type="button">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button @click="addToCart()" data-dismiss="modal" type="button" class="btn btn-primary">Add To
                    Cart</button>
                </div>
              </div>
            </div>
          </div>
          <!-- /STORE -->
        </div>
        <!-- /row -->
      </div>
      <!-- /container -->
    </div>
    <!-- /SECTION -->
  </div>
</template>
<script>
import LaravelVuePagination from 'laravel-vue-pagination';
import cartMixin from '../../mixins/cart';


export default {
  components: {
    'Pagination': LaravelVuePagination

  },
  name: "browseBySubcategory",
  mixins: [cartMixin],
  data() {
    return {
      sortby: 0,
      prices: [],
      subcategories: [],
      products: {},
      cart: { id: '', slug: '', product: '', price: '', quantity: 1, attributes: '', shipping_fee: '' },
      carts: [],
      total: 0,
      product: { id: '', category: '', subcategory: '', name: '', slug: '', short_description: '', description: '', regular_price: '', sale_price: '', image: null, shipping_fee: '', status: '' },
      attributes: { values: '', prices: '' },
      myvalue: '',
      myprice: '',
      selected: [],
      options: [],


    }
  },
  methods: {
 
    getProduct(slug) {

      axios.get('/api/show/product/' + slug)
        .then(res => {
          this.product = res.data.product;
          this.attributes = res.data.attributes;
          console.log(this.gallery);
        }).catch(error => console.log(error));

    },

    loadProducts(page = 1) {

      axios.get(`/api/browse/subcategory/${this.$route.params.subcategory}`
        + '/?page=' + page
        + '&sortby=' + this.sortby
      ).then(res => {
        this.products = res.data;

      }).catch(err => console.log(err))
    },

  },

  mounted() {


    this.loadProducts();
  },

  watch: {
    sortby: function () {
      this.loadProducts();
    },

    '$route.params.subcategory': function () {
      this.loadProducts();

    },
  }
}
</script>

