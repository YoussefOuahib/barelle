<template>
    <div>
        <div class="breadcumb">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {{ this.product.category }} | {{ this.product.subcategory }} | {{ this.product.name }}
                    </div>
                </div>
            </div>
        </div>
        <div class="details mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div>
                            <img :src="'/storage/images/' + this.product.image" width="60%">
                        </div>
                        <img v-for="(gal, index) in this.product.gallery" :key="index"
                            :src="'/storage/images/' + gal.image" width="100px" height="100px">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="product-card">
                            <h4>{{ this.product.name }}</h4>
                            <br>
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
                                            :value="{ myprice: attributes.prices[index][ind], myvalue: value }"
                                            :key="ind">{{ value }}
                                        </option>

                                    </select>
                                </label>

                            </div>
                            <div class="input-group form-inline">
                                <label class="mr-4">QTY: </label>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-info" @click="decrement" type="button">-</button>
                                </div>
                                <input class="form-control" disabled v-model="cart.quantity" type="number" max="10"
                                    min="1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" @click="increment" type="button">+</button>
                                </div>
                            </div>
                            <div class="call-to-action mt-4 text-center">
                                <button class="btn btn-primary" @click="addToCart()">Add to Cart</button>
                            </div>
                            <div class="share ml-4 mt-4">
                                <span>Share on: </span>
                                <span><i class="fa-brands fa-facebook"></i></span>
                                <span><i class="fa-brands fa-instagram"></i></span>
                                <span><i class="fa-brands fa-whatsapp"></i></span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="product-info ">

                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description"
                                role="tab" aria-controls="description" aria-selected="true">Description</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            {{ this.product.description }}
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="shell">
            <div class="container">
                <h2>Related Products</h2>

                <div class="row">
                    <div v-for="prod in related.data" :key="prod.id" class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="wsk-cp-product">
                            <div class="wsk-cp-img">
                                <img :src="'/storage/images/' + prod.image" class="img-responsive" />
                            </div>
                            <div class="wsk-cp-text">
                                <div class="category">
                                    <span>{{ prod.category }}</span>
                                </div>
                                <div class="title-product">
                                    <h3>{{ prod.name }} </h3>
                                </div>

                                <div class="card-footer">
                                    <div class="wcf-left"><span class="price">{{ prod.sale_price }} MAD</span></div>
                                    <div class="wcf-right"><a href="#" class="buy-btn"> Add to cart</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
import cartMixin from '../mixins/cart';

export default {
  components: { VueSlickCarousel },
  name: 'product',
  mixins: [cartMixin],

  data() {
    return {
      cart: { id: '', slug: '', product: '', price: '', quantity: 1, attributes: '', shipping_fee: '' },
      total_price: 0,
      carts: [],
      alreadyExisted: false,
      total: 0,
      price: 0,
      gallery: [],
      product: { id: '', category: '', subcategory: '', name: '', slug: '', short_description: '', description: '', regular_price: '', sale_price: '', image: null, shipping_fee: '', status: '' },
      attributes: { values: '', prices: '' },
      myvalue: '',
      myprice: '',
      selected: [],
      options: [],
      collect: [],
      carouselSettings: {
        "arrows": false,
        "dots": false,
      },
      related: {},
    }
  },


  methods: {
    increment() {
      this.cart.quantity++;
    },
    decrement() {
      this.cart.quantity > 1 ? this.cart.quantity-- : this.cart.quantity;
    },
    selectAttribute(index) {
      this.total = 0;
      this.price = parseInt(this.selected[index].myprice);
      this.options[index] = this.selected[index].myvalue;
      this.collect[index] = this.price;
      for (let i = 0; i < this.collect.length; i++) {
        this.total = this.total + this.collect[i];
      }
      this.total = this.total + this.product.sale_price;

    },

    getProduct() {

      axios.get(`/api/products/${this.$route.params.slug}`)
        .then(res => {
          this.product = res.data.product;
          this.attributes = res.data.attributes;
        }).catch(error => console.log(error));
    },
   
    getRelatedProducts() {
      axios.get(`/api/show/related/${this.$route.params.slug}`).then(res => {
        this.related = res.data;
      }).catch(err => console.log(err));
    },
  },
  mounted() {
    this.getProduct();
    this.getRelatedProducts();

  },
  watch: {
    '$route.params.slug': function () {
      this.getProduct();
    }
  },

}
</script>



