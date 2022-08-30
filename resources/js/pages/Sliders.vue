<template>
  <div>

  <main>
            <div class="recent-orders">
                <h2>Sliders</h2>
              <div class="button" @click="showModal = true;">
                <span class="material-icons-sharp">add</span>
               <h3 >Add Slider</h3>
              </div>
              <div class="control-panel">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Link</th>
                            <th></th>
                         
                        </tr>
                    </thead>
                   
  <tbody>
     <tr v-for="slider in sliders.data" :key="slider.id">
   
      <td class="slider-pic"><img width="100px" height="100px" :src="'/storage/images/' + slider.picture" alt=""></td>
       <td>{{slider.title}}</td>
       <td>{{slider.link}}</td>
       

     
     
         <td>
        <button style="background: transparent;" type="button" @click="getSlider(slider.id);showupdateModal = true;"><span style="cursor: pointer;" class="primary material-icons-sharp">edit</span></button>
        <button style="background: transparent;" type="button"  @click="deleteSlider(slider.id)"><span style="cursor: pointer;" class="danger material-icons-sharp">delete</span></button>
        

      </td>
      
      
    </tr>
                     
                    </tbody>
                </table>
              </div>
                <div class="pagination">
             <Pagination  :data="sliders" @pagination-change-page="getSliders" />
              </div>
            </div>
        </main>
     <div class="modal-vue">
  

  <div class="overlay" v-if="showModal" @click="showModal = false"></div>
  

  <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showModal">
    <button class="close" @click="showModal = false"><span style="cursor: pointer" class="danger material-icons-sharp">clear</span></button>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Slider</h3>
      </div>
      <div class="modal-body">
      
      <div class="myform">
        <label for="name">Title:</label>
        <div>
        <input type="text" required v-model="slider.title" class="inputform">
        </div>
      </div>
      <div class="myform">
        <label for="name">Link:</label>
        <div>
        <input type="text" required v-model="slider.link" class="inputform">
        </div>
      </div>
     
       <div class="myform" style="text-align:center">
            <h5> Click On the picture to upload the main picture </h5>
            <div>
           <label for="image" class="myimg">

 
    <img style="cursor:pointer;margin: 0 auto;" :src="this.previewImg" height="150px" width="150px">



          </label>
            </div>
<input style="display: none" type="file" id="image"  @change="handleOnChange"/>
         </div>



      
    </div>
    <div class="modal-footer">
                <button type="button" @click="addSlider()" class="btn btn-primary" > <i class="fa-light fa-plus"></i>Add</button>
                          <button type="button" @click="showModal = false" class="btn btn-danger" > <i class="fa-solid fa-xmark"></i>Close</button>

           </div>
      </div>
  </div>
  
</div>
 <div class="modal-vue">
  
  

  <div class="overlay" v-if="showupdateModal" @click="showupdateModal = false"></div>
  

  <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showupdateModal">
    <button class="close" @click="showupdateModal = false"><span style="cursor: pointer" class="danger material-icons-sharp">clear</span></button>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Update Slider</h3>
      </div>
      <div class="modal-body">
       <div class="myform">
        <label for="name">Title:</label>
        <div>
        <input type="text" required v-model="slider.title" class="inputform">
        </div>
      </div>
      <div class="myform">
        <label for="name">Link:</label>
        <div>
        <input type="text" required v-model="slider.link" class="inputform">
        </div>
      </div>
     
      
          <div class="myform" style="text-align:center">
            <h5> Click On the picture to upload the main picture </h5>
            <div>
           <label for="image1" class="myimg">
             
<img v-if="this.prv != ''" style="cursor:pointer; margin: 0 auto" :src="'/sliders/' + this.prv" height="150px" width="150px">
    <img v-else style="cursor:pointer; margin: 0 auto" :src="this.previewImg != '' ? this.previewImg :'https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg'" height="150px" width="150px">






          </label>
            </div>
<input style="display: none" type="file" id="image1"  @change="handleOnChange"/>
         </div>

    <div class="modal-footer">
                <button type="button" @click="updateSlider(slider.id)" class="btn btn-primary" > <i class="fa-solid fa-pen-to-square"></i>Update</button>
                          <button type="button" @click="showupdateModal = false" class="btn btn-danger" > <i class="fa-solid fa-xmark"></i>Close</button>

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
    name: "slider",
    components: {
        'Pagination': LaravelVuePagination

    },
    data() {
        return {
            message : '',
            sliders: {},
            slider: {title: '',link:'',picture: '', type: '', key: ''},
            prv : null,
            prvs: [],
            previewImg : "https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg",
            previews: [],
            showModal : false,
            showupdateModal: false,


        }
    },
    methods: {
          handleOnChange(e) {
        this.prv = '',
       this.previewImg = '',
       this.slider.picture = '';
       if(e.target.files[0]){
        this.slider.picture  = e.target.files[0];
        this.previewImg = URL.createObjectURL(this.slider.picture);
        
       }
        
      },
        getSliders() {
          
            axios.get('/api/sliders').then(res => {
                this.sliders = res.data;
            }).catch(err => console.log(err));
        },
        getSlider(id)
            {
                 axios.get('/api/sliders/' + id)
                .then(res => {
                  
                    this.slider = res.data.data;

                    this.prv = this.slider.picture;

                    
                }).catch(error => console.log(error));
            },
        addSlider() {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               
          let formData = new FormData();
             formData.append('title', this.slider.title);
          formData.append('type', this.slider.type);
          formData.append('key', this.slider.key);
          formData.append('link', this.slider.link);
          formData.append('picture', this.slider.picture);
                axios.post('/api/sliders', formData, config).then(res => {
                    if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'slider has been Successfully added',
  'success'
)
                    this.getSliders();
                    this.slider = {};
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


        updateSlider() {
         const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
           let formData = new FormData();
           formData.append('title', this.slider.title);
          formData.append('type', this.slider.type);
          formData.append('key', this.slider.key);
          formData.append('link', this.slider.link);
          formData.append('picture', this.slider.picture);
          formData.append("_method", "put");



          axios.post(`/api/sliders/${this.slider.id}`, formData, config).then(res => {
             const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               
         
            if(res.data.status == 201) {
                Swal.fire(
  'Done',
  'banner has been Successfully updated',
  'success'
)
                    this.getSliders();
                    this.slider = {};
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

        deleteSlider(id) {
           
          axios.delete('/api/sliders/' + id, this.slider).then(res => {
           
               if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'slider has been Successfully removed',
  'success'
)
                    this.getSliders();
                    this.slider = {name: ''};
                    }
                    
            
           
          }).catch(err => console.log(err));
           
        }
        
        
    },
    mounted() {

            this.getSliders();
        }
}
</script>
<style scoped>
.slider-pic img {
  margin:  0 auto;
  border-radius: 50px;
}
</style>