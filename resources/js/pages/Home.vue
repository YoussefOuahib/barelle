<template>
  <div>
    <section class="slider">
      <VueSlickCarousel v-bind="carousel">
        <div v-for="slider in sliders" :key="slider.id">
          <img :src="'storage/images/' + slider.picture" width="100%" height="350px">
        </div>

      </VueSlickCarousel>

    </section>
    <section class="features">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="feature">
            <div class="feature-icon">
              <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="feature-content">
              <h5> Free Delivery</h5>
              <p>Free shipping on all orders </p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="feature">
            <div class="feature-icon">
              <i class="fa-solid fa-arrow-rotate-left"></i>
            </div>
            <div class="feature-content">
              <h5> Free Return</h5>
              <p>Free return over $100 </p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="feature">
            <div class="feature-icon">
              <i class="fa-solid fa-headset"></i>
            </div>
            <div class="feature-content">
              <h5>Customer Support</h5>
              <p>Friendly 24/7 customer support </p>
            </div>

          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="feature">
            <div class="feature-icon">
              <i class="fa-solid fa-money-bill-transfer"></i>
            </div>
            <div class="feature-content">
              <h5> Money Back Guarantee</h5>
              <p>Back guarantee under 7 days </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section class="banners mt-2">
      <div class="row">
        <div v-for="banner in banners" :key="banner.order" class="col-4">
          <div v-if="banner.order <= 3" class="banner-img">
            <img :src="'storage/banners/' + banner.picture">
          </div>
        </div>


      </div>
    </section>
    <hr>


    <section class="products">
      <h2>Featured Product</h2>
      <div class="container">
        <carousel :per-page="4">
          <slide v-for="(product, index) in featured" :key="index">
            <div class="item">
              <div class="thumb-wrapper">
                <div class="img-box">
                  <router-link :to="{ name: 'product', params: { slug: product.slug } }">
                    <img :src="'storage/images/' + product.image" class="img-fluid" alt="">
                  </router-link>
                </div>
                <div class="thumb-content">
                  <router-link :to="{ name: 'product', params: { slug: product.slug } }">
                    <h4>{{ product.name }}</h4>

                    <p class="item-price"><strike>{{ product.regular_price }} MAD</strike> <b>{{ product.sale_price }}
                        MAD</b>
                    </p>
                  </router-link>
                  <a data-toggle="modal" data-target="#exampleModal3" @click="getProduct(product.slug)"
                    class="btn btn-primary">Add to Cart</a>
                </div>
              </div>
            </div>
          </slide>

        </carousel>
      </div>


    </section>

    <h2 class="text-center my-4">Categories</h2>

    <div class="container my-4">
      <div class="row mt-2 g-4">
        <div class="col-md-3" v-for="category in mycategories" :key="category.id">
          <div class="card p-1">
            <router-link :to="{ name: 'browseByCategory', params: { category: category.id } }">
              <div class="d-flex justify-content-between align-items-center p-2">
                <div class="flex-column lh-1 imagename"> {{ category.name }} </div>


                <div> <img :src="'storage/images/' + category.image" height="100" width="100" /> </div>

              </div>
            </router-link>
            <small class="text-muted mx-4">{{ category.products }} Products</small>
          </div>
        </div>

      </div>
    </div>

    <hr>
    <section class="banners mt-2">
      <div class="row">
        <div v-for="banner in banners" :key="banner.order" class="col-4">
          <div v-if="banner.order == 4 || banner.order == 5 || banner.order == 6" class="banner-img">

            <img :src="'storage/banners/' + banner.picture">
          </div>
        </div>


      </div>
    </section>
    <hr>

    <div class="shell">
      <div class="container">
        <h2>Best Selling Products</h2>

        <div class="row">
          <div v-for="(product, index) in best_selling" :key="index" v-if="index < 8"
            class="col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="wsk-cp-product">
              <router-link :to="{ name: 'product', params: { slug: product.slug } }">

                <div class="wsk-cp-img"><img :src="'storage/images/' + product.image" alt="Product"
                    class="img-responsive" /></div>
              </router-link>
              <div class="wsk-cp-text">
                <div class="category">
                  <span>{{ product.subcategory }}</span>
                </div>
                <div class="title-product">
                  <router-link :to="{ name: 'product', params: { slug: product.slug } }">

                    <h3>{{ product.name }} </h3>
                  </router-link>
                </div>

                <div class="card-footer">
                  <router-link :to="{ name: 'product', params: { slug: product.slug } }">
                    <div class="wcf-left"><span class="price">{{ product.sale_price }}MAD</span>
                      <span class="text-decoration-line-through text-muted">{{ product.regular_price }}MAD</span>
                    </div>
                  </router-link>
                  <div class="wcf-right"><a data-toggle="modal" data-target="#exampleModal3"
                      @click="getProduct(product.slug)" class="buy-btn"> Add to cart</a></div>
                </div>
              </div>
            </div>
          </div>



        </div>


      </div>
    </div>

    <hr>
    <section class="banners mt-2">
      <div class="row">
        <div v-for="banner in banners" :key="banner.order" class="col-4">
          <div v-if="banner.order > 6" class="banner-img">

            <img :src="'storage/banners/' + banner.picture">
          </div>
        </div>


      </div>
    </section>
    <hr>

    <section class="products">
      <h2>Our Collection</h2>
      <div class="container">
        <carousel :per-page="4">
          <slide v-for="(product, index) in products" :key="index">
            <div class="item">

              <div class="thumb-wrapper">
                <router-link :to="{ name: 'product', params: { slug: product.slug } }">

                  <div class="img-box">
                    <img :src="'storage/images/' + product.image" class="img-fluid" alt="">
                  </div>
                </router-link>

                <div class="thumb-content">
                  <router-link :to="{ name: 'product', params: { slug: product.slug } }">

                    <h4>{{ product.name }}</h4>

                    <p class="item-price"><strike>{{ product.regular_price }} MAD</strike> <b>{{ product.sale_price }}
                        MAD</b>
                    </p>
                  </router-link>
                  <a data-toggle="modal" data-target="#exampleModal3" @click="getProduct(product.slug)"
                    class="btn btn-primary">Add to Cart</a>
                </div>
              </div>
            </div>
          </slide>

        </carousel>
      </div>


    </section>
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
              <img height="200px" width="200px" :src="'storage/images/' + this.product.image">

            </div>
            <div class="product-content">
              <p>{{ this.product.short_description }}</p>

              <br>
              <span class="shipping">Shipping fee: {{ this.product.shipping_fee }} MAD</span>
              <br>
              <span class="price">{{ this.total > 0 ? this.total : this.product.sale_price }} MAD</span>

              <div class="form-inline attributes" v-if="attributes">
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
            <button data-dismiss="modal" type="button" class="btn btn-info">
              <router-link :to="{ name: 'product', params: { slug: product.slug } }">View Product</router-link>
            </button>
            <button @click="addToCart()" data-dismiss="modal" type="button" class="btn btn-primary">Add To Cart</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
import { Carousel, Slide } from 'vue-carousel';
import cartMixin from '../mixins/cart';

export default {
  components: {
    VueSlickCarousel,
    Carousel,
    Slide
  },
  name: 'Home',
  mixins: [cartMixin],
  data() {
    return {
      featured: {},
      categories: {},
      products: {},
      best_selling: {},
      carousel: {
        "dots": true,
        "arrows": false,
        "dotsClass": "slick-dots custom-dot-class",
        "speed": 500,
        "slidesToShow": 1,
        "slidesToScroll": 1
      },
      banners: {},
      products: {},
      sliders: { title: '', picture: '', link: '', type: '' },
      attributes: {},
      product: { id: '', category: '', subcategory: '', name: '', slug: '', short_description: '', description: '', regular_price: '', sale_price: '', image: null, shipping_fee: '', status: '' },
      cart: { id: '', slug: '', product: '', price: '', quantity: 1, attributes: '', shipping_fee: '' },
      myvalue: '',
      myprice: '',
      selected: [],
      options: [],
      total: 0,
      alreadyExisted: false,
      carts: [],
    }
  },
  methods: {
    getData() {
      axios.get('/api/show/data').then(res => {
        this.sliders = res.data.sliders;
        this.banners = res.data.banners;
        this.categories = res.data.categories;

      }).catch(err => console.log(err));
    },
    loadProducts() {
      axios.get('/api/show/home').then(res => {
        this.products = res.data.products;
        this.featured = res.data.featured;
        this.best_selling = res.data.best_selling;
      })
    },
    getProduct(slug) {
            axios
                .get("/api/show/product/" + slug)
                .then((res) => {
                    this.product = res.data.product;
                    this.attributes = res.data.attributes;
                })
                .catch((error) => console.log(error));
        },
  },

  mounted() {
    this.loadProducts();
    this.getData();

  },

}
</script>
<style scoped>
@import '../assets/navbar/style.css';
</style>