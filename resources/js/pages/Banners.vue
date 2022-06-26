<template>
  <div>

    <main>
      <div class="recent-orders">
        <h2>Banners</h2>
        <div class="button" @click="showModal = true;">
          <span class="material-icons-sharp">add</span>
          <h3>Add Banner</h3>
        </div>
        <div class="control-panel">
          <table>
            <thead>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Link</th>
                <th>Order</th>
                <th></th>

              </tr>
            </thead>

            <tbody>
              <tr v-for="banner in banners.data" :key="banner.id">

                <td class="banner-pic"><img width="100px" height="100px" :src="'/storage/banners/' + banner.picture"
                    alt=""></td>
                <td>{{ banner.title }}</td>
                <td>{{ banner.link }}</td>
                <td>{{ banner.order }}</td>



                <td>
                  <button style="background: transparent;" type="button"
                    @click="getBanner(banner.id); showupdateModal = true;"><span style="cursor: pointer;"
                      class="primary material-icons-sharp">edit</span></button>
                  <button v-if="banner.order > 1" style="background: transparent;" type="button"
                    @click="goUp(banner.id)"><span style="cursor: pointer;"
                      class="warning material-icons-sharp">expand_less</span></button>
                  <button v-if="banner.order < 9" style="background: transparent;" type="button"
                    @click="goDown(banner.id)"><span style="cursor: pointer;"
                      class="danger material-icons-sharp">keyboard_arrow_down</span></button>


                </td>


              </tr>

            </tbody>
          </table>
        </div>
        <div class="pagination">
          <Pagination :data="banners" @pagination-change-page="getBanners" />
        </div>
      </div>
    </main>
    <div class="modal-vue">


      <div class="overlay" v-if="showModal" @click="showModal = false"></div>


      <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showModal">
        <button class="close" @click="showModal = false"><span style="cursor: pointer"
            class="danger material-icons-sharp">clear</span></button>
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Add Banner</h3>
          </div>
          <div class="modal-body">

            <div class="myform">
              <label for="name">Title:</label>
              <div>
                <input type="text" required v-model="banner.title" class="inputform">
              </div>
            </div>
            <div class="myform">
              <label for="name">Link:</label>
              <div>
                <input type="text" required v-model="banner.link" class="inputform">
              </div>
            </div>
            <div class="myform">
              <label for="name">Order:</label>
              <div>
                <input type="number" min="1" max="10" required v-model="banner.order" class="inputform">
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




          </div>
          <div class="modal-footer">
            <button type="button" @click="addBanner()" class="btn btn-primary"> <i
                class="fa-light fa-plus"></i>Add</button>
            <button type="button" @click="showModal = false" class="btn btn-danger"> <i
                class="fa-solid fa-xmark"></i>Close</button>

          </div>
        </div>
      </div>

    </div>
    <div class="modal-vue">



      <div class="overlay" v-if="showupdateModal" @click="showupdateModal = false"></div>


      <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showupdateModal">
        <button class="close" @click="showupdateModal = false"><span style="cursor: pointer"
            class="danger material-icons-sharp">clear</span></button>
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Update Banner</h3>
          </div>
          <div class="modal-body">
            <div class="myform">
              <label for="name">Title:</label>
              <div>
                <input type="text" required v-model="banner.title" class="inputform">
              </div>
            </div>
            <div class="myform">
              <label for="name">Link:</label>
              <div>
                <input type="text" required v-model="banner.link" class="inputform">
              </div>
            </div>


            <div class="myform" style="text-align:center">
              <h5> Click On the picture to upload the main picture </h5>
              <div>
                <label for="image1" class="myimg">

                  <img v-if="this.prv != ''" style="cursor:pointer; margin: 0 auto" :src="'storage/banners/' + this.prv"
                    height="150px" width="150px">
                  <img v-else style="cursor:pointer; margin: 0 auto"
                    :src="this.previewImg != '' ? this.previewImg : 'https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg'"
                    height="150px" width="150px">




                </label>
              </div>
              <input style="display: none" type="file" id="image1" @change="handleOnChange" />
            </div>

            <div class="modal-footer">
              <button type="button" @click="updateBanner(banner.id)" class="btn btn-primary"> <i
                  class="fa-solid fa-pen-to-square"></i>Update</button>
              <button type="button" @click="showupdateModal = false" class="btn btn-danger"> <i
                  class="fa-solid fa-xmark"></i>Close</button>

            </div>
          </div>
        </div>

      </div>
    </div>


  </div>
</template>


<script>
import LaravelVuePagination from 'laravel-vue-pagination';

export default {
  name: 'banner',
  components: {
    'Pagination': LaravelVuePagination

  },
  data() {
    return {
      message: '',
      banners: {},
      banner: { title: '', link: '', picture: '', order: '' },
      prv: null,
      prvs: [],
      previewImg: "https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg",
      previews: [],
      showModal: false,
      showupdateModal: false,


    }
  },
  methods: {
    handleOnChange(e) {
      this.prv = '',
        this.previewImg = '',
        this.banner.picture = '';
      if (e.target.files[0]) {
        this.banner.picture = e.target.files[0];
        this.previewImg = URL.createObjectURL(this.banner.picture);

      }

    },
    getBanners() {

      axios.get('/api/banners').then(res => {
        this.banners = res.data;
      }).catch(err => console.log(err));
    },
    getBanner(id) {
      axios.get('/api/banners/' + id)
        .then(res => {

          this.banner = res.data.data;
          this.prv = this.banner.picture;

        }).catch(error => console.log(error));
    },
    goUp(id) {
      axios.put('/api/up/banners/' + id, this.banner).then(res => {
        this.getBanners();

      }).catch(error => console.log(error));
    },
    goDown(id) {
      axios.put('/api/down/banners/' + id, this.banner).then(res => {
        this.getBanners();

      }).catch(error => console.log(error));
    },
    addBanner() {
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      let formData = new FormData();
      formData.append('title', this.banner.title);
      formData.append('order', this.banner.order);
      formData.append('link', this.banner.link);
      formData.append('picture', this.banner.picture);
      axios.post('/api/banners', formData, config).then(res => {
        if (res.data.status == 201) {
          Swal.fire(
            'Done',
            'banner has been Successfully added',
            'success'
          )
          this.getBanners();
          this.banner = {};
        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: res.data.message,

          });
        }
      }).catch(err => console.log(err));

    },


    updateBanner() {
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }
      let formData = new FormData();
      formData.append('title', this.banner.title);
      formData.append('order', this.banner.order);
      formData.append('link', this.banner.link);
      formData.append('picture', this.banner.picture);
      formData.append("_method", "put");



      axios.post(`/api/banners/${this.banner.id}`, formData, config).then(res => {
        const config = {
          headers: {
            'content-type': 'multipart/form-data'
          }
        }


        if (res.data.status == 201) {
          Swal.fire(
            'Done',
            'banner has been Successfully updated',
            'success'
          )
          this.getBanners();
          this.banner = {};
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

    deleteBanner(id) {

      axios.delete('/api/banners/' + id, this.banner).then(res => {

        if (res.data.status == 201) {
          Swal.fire(
            'Done',
            'banner has been Successfully removed',
            'success'
          )
          this.getBanners();
          this.banner = { title: '' };
        }



      }).catch(err => console.log(err));

    }


  },
  mounted() {

    this.getBanners();
  }
}
</script>
<style scoped>
.banner-pic img {
  margin: 0 auto;
  border-radius: 50px;
}
</style>