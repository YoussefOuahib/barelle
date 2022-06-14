<template>
<div>
  <main>
            <!-- end of insights-->
            <div class="recent-orders">
                <h2>Categories</h2>
              <div class="button" @click="showModal = true;">
                <span class="material-icons-sharp">add</span>
               <h3 >Add Category</h3>
              </div>
              <div class="control-panel">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subcategories</th>
                            <th>Image</th>
                            <th>Actions</th>
                         
                        </tr>
                    </thead>
                   
  <tbody>
    <tr v-for="(category,index) in categories.data" :key="index">
   
      <td>{{category.name}}</td>
      <td>
        <small v-for="subcategory in category.subcategories" > {{subcategory.name}}-</small>
      </td>
            <td class="banner-pic"><img width="100px" height="100px" :src="'/storage/products/' + category.image" alt=""></td>

         <td>
        <button style="background: transparent;" type="button" @click="getCategory(category.id);showupdateModal = true;"><span style="cursor: pointer;" class="primary material-icons-sharp">edit</span></button>
        <button style="background: transparent;" type="button"  @click="deleteCategory(category.id)"><span style="cursor: pointer;" class="danger material-icons-sharp">delete</span></button>
        

      </td>
      
      
    </tr>
                     
                    </tbody>
                </table>
              </div>
              <div class="pagination">
               <Pagination  :data="categories" @pagination-change-page="getCategories" />
              </div>
            </div>
        </main>
     <div class="modal-vue">
  
  
  <!-- overlay -->
  <div class="overlay" v-if="showModal" @click="showModal = false"></div>
  
  <!-- modal -->
  <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showModal">
    <button class="close" @click="showModal = false"><span style="cursor: pointer" class="danger material-icons-sharp">clear</span></button>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Category</h3>
      </div>
      <div class="modal-body">
      
      <div class="myform">
        <label for="name">Category:</label>
        <div>
        <input type="text" required v-model="category.name" class="inputform">
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
                <button type="button" @click="addCategory()" class="btn btn-primary" > <i class="fa-light fa-plus"></i>Add</button>
                          <button type="button" @click="showModal = false" class="btn btn-danger" > <i class="fa-solid fa-xmark"></i>Close</button>

           </div>
      </div>
  </div>
  
</div>
 <div class="modal-vue">
  
  
  <!-- overlay -->
  <div class="overlay" v-if="showupdateModal" @click="showupdateModal = false"></div>
  
  <!-- modal -->
  <div class="modal" style="width: 70%; top: 140px; left: 120px;" v-if="showupdateModal">
    <button class="close" @click="showupdateModal = false"><span style="cursor: pointer" class="danger material-icons-sharp">clear</span></button>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Update Category</h3>
      </div>
      <div class="modal-body">
      
      <div class="myform">
        <label for="name">Category:</label>
        <div>
        <input type="text" required v-model="category.name" class="inputform">
        </div>
      </div>

      
    </div>
    <div class="modal-footer">
                <button type="button" @click="updateCategory(category.id)" class="btn btn-primary" > <i class="fa-solid fa-pen-to-square"></i>Update</button>
                          <button type="button" @click="showupdateModal = false" class="btn btn-danger" > <i class="fa-solid fa-xmark"></i>Close</button>

           </div>
      </div>
  </div>
  
</div>
      
</div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';

export default {
    name: "category",
     components: {
        'Pagination': LaravelVuePagination

    },
    data() {
        return {
            showModal: false,
           showupdateModal: false,
            message : '',
            categories: {},
            previewImg : "https://www.aaronfaber.com/wp-content/uploads/2017/03/product-placeholder-wp.jpg",
            previews: [],
            prv : null,

            category: {name: '', image: '', subcategories: ''},


        }
    },
    methods: {
      handleOnChange(e) {
        this.prv = '',
       this.previewImg = '',
       this.category.image = '';
       if(e.target.files[0]){
        this.category.image  = e.target.files[0];
        this.previewImg = URL.createObjectURL(this.category.image);
        
       }
        
      },
        getCategories(page = 1) {
          
            axios.get('/api/categories?page=' + page).then(res => {
                this.categories = res.data;
                console.log(this.categories);
            }).catch(err => console.log(err));
           
        },
        getCategory(id)
            {
                 axios.get('/api/categories/' + id)
                .then(res => {
                  
                    this.category = res.data.data;
                    this.prv = this.category.image;
                }).catch(error => console.log(error));
            },
        addCategory() {
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               
          let formData = new FormData();
          formData.append('name', this.category.name);
          formData.append('image', this.category.image);
            
                axios.post('/api/categories',  formData, config).then(res => {
                    if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'Category has been Successfully added',
  'success'
)
                    this.getCategories();
                    
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


        updateCategory(id) {
           const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
          let formData = new FormData();
        formData.set('name', this.category.name);
          axios.put('/api/categories/' + id, this.category, formData, config).then(res => {
            if(res.data.status == 201) {
                Swal.fire(
  'Done',
  'Category has been Successfully updated',
  'success'
)
                    this.getCategories();
                    this.category = {name: ''};
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

        deleteCategory(id) {
        
          console.log(this.category);
          axios.delete('/api/categories/' + id, this.category).then(res => {
           
               if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'Category has been Successfully removed',
  'success'
)
                    this.getCategories();
                    this.category = {name: ''};
                    }
                    else {
                        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'This category is probably associated with other subcategories or something is wrong !',
 
});
                    }
            
           
          }).catch(err => console.log(err));
        
          
        }
        
        
    },
    mounted() {

            this.getCategories();
            
        }
}
</script>

<style scoped>
.banner-pic img {
  margin:  0 auto;
  border-radius: 50px;
}
</style>