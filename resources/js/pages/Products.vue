<template>
  <div>
    <main>
      <div class="recent-orders">
        <h2>Products</h2>
        <div class="button" @click="showModal = true; clearPreviews">
          <span class="material-icons-sharp">add</span>
          <h3>Add Product</h3>
        </div>
        <br>
        <div class="control-panel">
          <div>
            <label for="filter">Filter By:</label>
            <select v-model="filterBy" name="filter" class="selectform">
              <option value="0">Newest</option>
              <option value="1">Oldest</option>
              <option value="2">Most Popular</option>
              <option value="3">Price | Low to high</option>
              <option value="4">Price | High to high</option>
            </select>
            <label for="category">Categories:</label>
            <select v-model="showByCategory" name="category" class="selectform">
              <option value="">All</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
              </option>
            </select>

            <div class="search-bar">
              <label for="saerch">Search:</label>
              <input v-model="search" type="text" name="search" class="searchform">
            </div>
          </div>
          <br>
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Parents</th>
                <th>Price</th>
                <th>Orders</th>

                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products.data" :key="product.id">

                <td>{{ product.name }}</td>
                <td>{{ product.category }}/{{ product.subcategory }}</td>
                <td>{{ product.sale_price }}</td>
                <td>{{ product.orders }}</td>
                <td>
                  <button style="background: transparent;" type="button" @click="getProduct(product.slug)"><span
                      style="cursor: pointer;" class="primary material-icons-sharp">edit</span></button>
                  <button style="background: transparent;" type="button" @click="deleteProduct(product.slug)"><span
                      style="cursor: pointer;" class="danger material-icons-sharp">delete</span></button>
                  <button style="background: transparent;" type="button" @click="viewProduct(product.slug)">
                    <span style="cursor: pointer;" class="primary material-icons-sharp">visibility</span></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="pagination">
          <Pagination :data="products" @pagination-change-page="getProducts" />
        </div>
        <div>
        </div>
      </div>
    </main>

    <!-- add product form -->

    <div class="modal-vue">
      <!-- overlay -->
      <div class="overlay" v-if="showModal" @click="showModal = false"></div>
      <!-- modal -->
      <div class="modal" v-if="showModal">
        <button class="close" @click="showModal = false"><span style="cursor: pointer"
            class="danger material-icons-sharp">clear</span></button>
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Add Product</h3>
          </div>
          <div class="modal-body">
            <div class="inline-form">
              <div class="myform">
                <label for="category">Category:</label>
                <div>
                  <select required @change="selectCategory" v-model="product.category" class="inputform">
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                    </option>

                  </select>
                </div>
              </div>
              <div class="myform">
                <label for="category">Subcategory:</label>
                <div>
                  <select required v-model="product.subcategory" class="inputform">
                    <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                      {{ subcategory.name }}</option>

                  </select>
                </div>

              </div>
            </div>
            <div class="myform">
              <label for="name">Name:</label>
              <div>
                <input type="text" required v-model="product.name" class="inputform">
              </div>
            </div>

            <div class="myform">
              <label for="short_description">Short Description:</label>
              <div>
                <textarea class="inputform" v-model="product.short_description" required name="short_description"
                  cols="20"></textarea>
              </div>
            </div>
            <div class="myform">
              <label for="description">Description:</label>
              <div>
                <textarea class="inputform" v-model="product.description" required name="description"
                  cols="20"></textarea>

              </div>
            </div>
            <div class="inline-form">
              <div class="myform">
                <label for="name">Regular Price:</label>
                <div>
                  <input type="text" required v-model="product.regular_price" class="inputform">
                </div>
              </div>
              <div class="myform">
                <label for="name">Sale Price:</label>
                <div>
                  <input type="text" required v-model="product.sale_price" class="inputform">
                </div>
              </div>
            </div>
            <div class="myform">
              <label for="name">Shipping fee:</label>
              <div>
                <input type="text" required v-model="product.shipping_fee" class="inputform">
              </div>
            </div>
            <div class="myform" style="text-align:center">
              <h5> Click On the picture to upload the main picture </h5>
              <div>
                <label for="image" class="myimg">


                  <img style="cursor:pointer;margin: 0 auto;" :src="this.previewImg" height="150px" width="150px">



                </label>
              </div>
              <input style="display: none" type="file" id="image" @change="handleOnChange" />
            </div>



            <div id="wrapper" class="wrapper">

              <div class="wrapper-content">

                <label for="gallery">
                  <div class="wrapper-icon">

                    <span style="cursor: pointer"><i style="font-size:45px"
                        class="fa-solid fa-cloud-arrow-up"></i></span>
                  </div>
                  <div class="wrapper-text">
                    <p>Upload multiple Images of your products</p>
                  </div>
                </label>
                <input style="display: none" type="file" id="gallery" @change="handleGallery" multiple />

              </div>

              <div id="wrapper-footer" class=" wrapper-footer">
                <div v-for="(img, index) in this.previews" :key="index" class="wrapper-images">
                  <img style="border-radius: 10px" :src="img" height="70px" width="70px">
                  <button @click="removeImage(index)"><i class="fa-solid fa-trash"></i></button>
                </div>


              </div>


            </div>
            <div class="myform">
              <label for="name">Status</label>
              <div>
                <select required v-model="product.status" class="inputform">
                  <option value="In stock">In stock</option>
                  <option value="Out of stock">Out of stock</option>
                </select>
              </div>
            </div>

            <div class="myform">
              <label for="name">Attribute</label>
              <div>
                <select required v-model="attribute" class="inputform">
                  <option v-for="attribute in attributes" :key="attribute.id" :value="attribute.name">{{ attribute.name
                  }}
                  </option>

                </select>
                <div @click="addAttribute()" class="button" style="margin-top: 0.3rem">
                  <span class="material-icons-sharp">add</span>
                  <h3>Add Attribute</h3>
                </div>

              </div>
            </div>


            <table v-if="attributes_attr.length > 0" class="table">
              <thead>
                <tr>

                  <th scope="col">Attribute</th>
                  <th scope="col">Values</th>
                  <th scope="col">Prices</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(attr, index) in attributes_attr" :key="index">

                  <td>{{ attr }}</td>
                  <td> <input type="text" class="inputform" placeholder="value,value,value" v-model="values[index]">
                  </td>
                  <td> <input type="text" class="inputform" placeholder="value,value,value" v-model="prices[index]">
                  </td>
                  <td><button type="button" @click="deleteAttribute(index)" style="cursor:pointer" class="danger"><i
                        class="fas fa-trash-alt"></i></button></td>
                </tr>


              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" @click="addProduct()" class="btn btn-primary"> <i
                class="fa-light fa-plus"></i>Add</button>
            <button type="button" @click="showModal = false" class="btn btn-danger"> <i
                class="fa-solid fa-xmark"></i>Close</button>
          </div>
        </div>
      </div>

    </div>
    <!-- add product form -->

    <!-- update form -->

    <div class="modal-vue">


      <!-- overlay -->
      <div class="overlay" v-if="showupdateModal" @click="showupdateModal = false"></div>

      <!-- modal -->
      <div class="modal" v-if="showupdateModal">
        <button class="close" @click="showupdateModal = false"><span style="cursor: pointer"
            class="danger material-icons-sharp">clear</span></button>
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Add Product</h3>
          </div>
          <div class="modal-body">
            <div class="inline-form">
              <div class="myform">
                <label for="category">Category:</label>
                <div>
                  <select required @change="selectCategory" v-model="product.category" class="inputform">
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                    </option>

                  </select>
                </div>
              </div>
              <div class="myform">
                <label for="category">Subcategory:</label>
                <div>
                  <select required v-model="product.subcategory" class="inputform">
                    <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                      {{ subcategory.name }}</option>

                  </select>
                </div>

              </div>
            </div>
            <div class="myform">
              <label for="name">Name:</label>
              <div>
                <input type="text" required v-model="product.name" class="inputform">
              </div>
            </div>

            <div class="myform">
              <label for="short_description">Short Description:</label>
              <div>
                <textarea class="inputform" v-model="product.short_description" required name="short_description"
                  cols="20"></textarea>

              </div>
            </div>
            <div class="myform">
              <label for="description">Description:</label>
              <div>
                <textarea class="inputform" v-model="product.description" required name="description"
                  cols="20"></textarea>

              </div>
            </div>
            <div class="inline-form">
              <div class="myform">
                <label for="name">Regular Price:</label>
                <div>
                  <input type="text" required v-model="product.regular_price" class="inputform">
                </div>
              </div>
              <div class="myform">
                <label for="name">Sale Price:</label>
                <div>
                  <input type="text" required v-model="product.sale_price" class="inputform">
                </div>
              </div>
            </div>
            <div class="myform">
              <label for="name">Shipping fee:</label>
              <div>
                <input type="text" required v-model="product.shipping_fee" class="inputform">
              </div>
            </div>
            <div class="myform" style="text-align:center">
              <h5> Click On the picture to upload the main picture </h5>
              <div>
                <label for="image1" class="myimg">

                  <img v-if="this.prv != ''" style="cursor:pointer; margin: 0 auto" :src="'/storage/images/' + this.prv"
                    height="150px" width="150px">
                  <img v-else style="cursor:pointer; margin: 0 auto"
                    :src="this.previewImg != '' ? this.previewImg : 'https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg'"
                    height="150px" width="150px">





                </label>
              </div>
              <input style="display: none" type="file" id="image" @change="handleOnChange" />
            </div>



            <div id="wrapper" class="wrapper">

              <div class="wrapper-content">

                <label for="gallery">
                  <div class="wrapper-icon">

                    <span style="cursor: pointer"><i style="font-size:45px"
                        class="fa-solid fa-cloud-arrow-up"></i></span>
                  </div>
                  <div class="wrapper-text">
                    <p>Upload multiple Images of your products</p>
                  </div>
                </label>
                <input style="display: none" type="file" id="gallery" @change="handleUpdateGallery" multiple />

              </div>

              <div id="wrapper-update-footer" class=" wrapper-update-footer">

                <div v-for="(img, index) in this.product.gallery" :key="img.id" class="wrapper-images">
                  <img style="border-radius: 10px" :src="'/storage/images/' + img.image" height="70px" width="70px">

                  <button @click="removeExistingImage(img.id, index)"><i class="fa-solid fa-trash"></i></button>
                </div>
                <div v-for="(img, index) in this.previews" :key="index" class="wrapper-images">
                  <img style="border-radius: 10px" :src="img" height="70px" width="70px">

                  <button @click="removeImage(index)"><i class="fa-solid fa-trash"></i></button>
                </div>


              </div>


            </div>
            <div class="myform">
              <label for="name">Status</label>
              <div>
                <select required v-model="product.status" class="inputform">
                  <option value="In stock">In stock</option>
                  <option value="Out of stock">Out of stock</option>
                </select>
              </div>
            </div>

            <div class="myform">
              <label for="name">Attribute</label>
              <div>
                <select required v-model="attribute" class="inputform">
                  <option v-for="attribute in attributes" :key="attribute.id" :value="attribute.name">{{ attribute.name
                  }}
                  </option>

                </select>
                <div @click="addAttribute()" class="button" style="margin-top: 0.3rem">
                  <span class="material-icons-sharp">add</span>
                  <h3>Add Attribute</h3>
                </div>

              </div>
            </div>




            <table class="attributes table">
              <thead>
                <tr>

                  <th scope="col">Attribute</th>
                  <th scope="col">Values</th>
                  <th scope="col">Prices</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(attribute, index) in atts.attribute" :key="index">

                  <td>{{ attribute }}</td>
                  <td>
                    <input :id="'value_' + index" type="text" class="inputform" required v-model="values[index]">
                  </td>
                  <td>
                    <input :id="'price_' + index" type="text" class="inputform prices" required v-model="prices[index]">
                  </td>
                  <td>
                    <div style="margin-top: 1rem; display: inline-flex;">

                      <span style="cursor:pointer" @click="deleteAttribute(index)" class="btn btn-danger "><i
                          class="fas fa-trash-alt"></i></span>

                    </div>
                  </td>
                </tr>


              </tbody>
            </table>





          </div>
          <div class="modal-footer">
            <button type="button" @click="updateProduct()" class="btn btn-primary"><i
                class="fa-solid fa-pen-to-square"></i>Update</button>
            <button type="button" @click="showupdateModal = false" class="btn btn-danger"> <i
                class="fa-solid fa-xmark"></i>Close</button>

          </div>
        </div>
      </div>

    </div>
    <!-- add product form -->

  </div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';

export default {
  components: {
    'Pagination': LaravelVuePagination

  },
  name: "products",
  data() {
    return {
      vals: [],
      prcs: [],
      isActive: false,
      isdisabled: true,
      showModal: false,
      showupdateModal: false,
      images: [],
      message: '',
      products: {},
      subcategories: {},
      categories: {},
      selectedCategory: "",
      attributes: {},
      attribute: { name: '' },
      attributes_attr: [],
      values: [],
      prices: [],
      attrs: '',
      product: { id: '', category: '', subcategory: '', name: '', slug: '', short_description: '', shipping_fee: '', description: '', regular_price: '', sale_price: '', image: null, status: '' },
      prv: null,
      prvs: [],
      previewImg: "https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg",
      previews: [],
      gallery: [],
      updatedGallery: [],
      atts: { values: {}, prices: {}, attribute: '' },
      filterBy: 0,
      showByCategory: '',
      showBySubcategory: 0,
      search: '',
    }
  },
  methods: {
    selectCategory(event) {
      this.selectedCategory = event.target.value;
      console.log(this.selectedCategory);
      axios.get(`/api/subcategories/category/${this.selectedCategory}`)
        .then(res => {
          this.subcategories = res.data.subcategories;
        }).catch(err => console.log(err));
    },
    clearPreviews() {
      this.previews = [];
      this.product = {};

    },
    handleAttributes() {


      this.values = this.atts.values;
      this.prices = this.atts.prices;


    },
    addAttribute() {

      if (!this.attributes_attr.includes(this.attribute) && this.attribute.name !== '') {


        this.attributes_attr.push(this.attribute);




      }
      if (this.atts.attribute) {
        if (!this.atts.attribute.includes(this.attribute) && this.attribute.name !== '') {
          this.atts.attribute.push(this.attribute);
        }
      }

    },

    deleteAttribute(index) {
      this.attributes_attr.splice(index, index + 1);
      this.atts.attribute.splice(index, index + 1);
      this.values.splice(index, index + 1);
      this.prices.splice(index, index + 1);
    },



    handleOnChange(e) {
      this.prv = '',
      this.previewImg = '',
      this.product.image = '';
      if (e.target.files[0]) {
        this.product.image = e.target.files[0];
        this.previewImg = URL.createObjectURL(this.product.image);

      }

    },

    removeImage(index) {

      this.gallery.splice(index, 1);
      this.previews.splice(index, 1);

    },
    removeExistingImage(id, index) {

      this.gallery.splice(index, 1);
      this.previews.splice(index, 1);
      axios.delete('/api/delete/gallery/' + id, this.gallery).then(res => {

      }
      ).catch(err => console.log(err));
    },



    handleGallery(event) {


      for (let x = 0; x < event.target.files.length; x++) {
        this.gallery.push(event.target.files[x]);
        this.previews.push(URL.createObjectURL(event.target.files[x]));


      }

    },
    handleUpdateGallery(event) {

      for (let x = 0; x < event.target.files.length; x++) {

        this.updatedGallery.push(event.target.files[x]);
        this.previews.push(URL.createObjectURL(event.target.files[x]));

      }
    },
    getProducts(page = 1) {

      axios.get('/api/products?page=' + page
        + '&filterBy=' + this.filterBy
        + '&search=' + this.search
        + '&showByCategory=' + this.showByCategory
      ).then(res => {

        this.products = res.data;
        this.categories = res.data.categories;
        this.attributes = res.data.attributes;
      }).catch(err => console.log(err));
    },

    getProduct(slug) {
      this.showupdateModal = true;
      this.product = {};
      axios.get('/api/products/' + slug)
        .then(res => {
          this.prv = '';

          this.product = res.data.product;
          this.prv = this.product.image;
          this.gallery = res.data.gallery;
          this.atts = res.data.attributes;
          this.handleAttributes();

        }).catch(error => console.log(error));

    },
    updateProduct() {

      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }
      let updateformData = new FormData();
      this.attrs = this.atts.attribute.toString();
      console.log(this.attrs);
      for (let x = 0; x < this.prices.length; x++) {
        this.prcs[x] = this.prices[x].toString().split(',');
      }
      for (let i = 0; i < this.values.length; i++) {
        this.vals[i] = this.values[i].toString().split(',');
      }
      updateformData.append('attrs', this.attrs);
      updateformData.append('values', JSON.stringify(this.vals));
      updateformData.append('prices', JSON.stringify(this.prcs));
      updateformData.append('category', this.product.category);
      updateformData.append('subcategory', this.product.subcategory);
      updateformData.append('name', this.product.name);
      updateformData.append('description', this.product.description);
      updateformData.append('regular_price', this.product.regular_price);
      updateformData.append('sale_price', this.product.sale_price);
      updateformData.append('shipping_fee', this.product.shipping_fee);
      updateformData.append('short_description', this.product.short_description);
      updateformData.append('image', this.product.image);
      updateformData.append('status', this.product.status);
      if (this.updatedGallery.length > 0) {
        for (let i = 0; i < this.updatedGallery.length; i++) {
          let file = this.updatedGallery[i];
          updateformData.append('gallery[' + i + ']', file);


        }
      }

      updateformData.append("_method", "put");
      axios.post(`/api/products/${this.product.slug}`, updateformData, config).then(res => {
        if (res.data.status == 201) {
          Swal.fire(
            'Done',
            'Product has been Successfully updated',
            'success'
          )
          this.getProducts();

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

    addProduct() {
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      let formData = new FormData();

      this.attrs = this.attributes_attr.toString();

      for (let i = 0; i < this.values.length; i++) {
        this.vals[i] = this.values[i].split(',');
      }
      for (let x = 0; x < this.prices.length; x++) {
        this.prcs[x] = this.prices[x].split(',');

      }
      formData.append('attrs', this.attrs);
      formData.append('values', JSON.stringify(this.vals));
      formData.append('prices', JSON.stringify(this.prcs));
      formData.append('category', this.product.category);
      formData.append('subcategory', this.product.subcategory);
      formData.append('name', this.product.name);
      formData.append('description', this.product.description);
      formData.append('regular_price', this.product.regular_price);
      formData.append('sale_price', this.product.sale_price);
      formData.append('short_description', this.product.short_description);
      formData.append('status', this.product.status);
      formData.append('image', this.product.image);
      formData.append('shipping_fee', this.product.shipping_fee);
      if (this.gallery.length > 0) {
        for (let i = 0; i < this.gallery.length; i++) {
          let file = this.gallery[i];
          formData.append('gallery[' + i + ']', file);
        }
      }

      axios.post('/api/products', formData, config).then(res => {
        if (res.status == 201) {
          Swal.fire('Done', 'Product has been Successfully added', 'success')
          this.product = {};
          this.gallery = {};
          URL.revokeObjectURL(this.previewImg);
          URL.revokeObjectURL(this.previews);

          this.getProducts();
        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something is wrong here !',

          });
        }
      }).catch(err => console.log(err));

    },


    viewProduct(slug) {
      window.location.href = '/product/' + slug;

    },

    deleteProduct(slug) {
      axios.delete('/api/products/' + slug, this.product).then(res => {
        if (res.data.status == 201) {
          Swal.fire(
            'Done',
            'Product has been Successfully removed',
            'success'
          )
          this.getProducts();
          this.product = { name: '' };
        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something is wrong here !',

          });
        }
      }).catch(err => console.log(err));
    },
  },
  watch: {
    filterBy: function () {
      this.getProducts()

    },
    search: function () {
      this.getProducts()

    },
    showByCategory: function () {
      this.getProducts()
    }
  },


  mounted() {
    this.getProducts();

  }
}
</script>

