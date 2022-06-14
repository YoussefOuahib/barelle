<template>
<div>
  <main>
            <!-- end of insights-->
            <div class="recent-orders">
                <h2>Subcategories</h2>
              <div class="button" @click="showModal = true;">
                <span class="material-icons-sharp">add</span>
               <h3 >Add Subategory</h3>
              </div>
              <div class="control-panel">
                <table>
                   <thead>
    <tr>
     
      <th>Name</th>
      <th>Parent Category</th>
      <th>Products</th>
      <th></th>
    </tr>
  </thead>

                   
  <tbody>
     <tr v-for="subcategory in subcategories.data" :key="subcategory.id">
   
      <td>{{subcategory.name}}</td>
      <td>{{subcategory.category}}</td>
      <td>{{subcategory.products_count}}</td>

         <td>
        <button style="background: transparent;" type="button" @click="getSubcategory(subcategory.id);showupdateModal = true;"><span style="cursor: pointer;" class="primary material-icons-sharp">edit</span></button>
        <button style="background: transparent;" type="button"  @click="deleteSubcategory(subcategory.id)"><span style="cursor: pointer;" class="danger material-icons-sharp">delete</span></button>
        

      </td>
      
      
    </tr>
                     
                    </tbody>
                </table>
              </div>
              <div class="pagination">
                <Pagination  :data="subcategories" @pagination-change-page="getSubcategories" />
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
        <h3 class="modal-title">Add Subcategory</h3>
      </div>
      <div class="modal-body">
      
       <div class="myform">
        <label for="category">Category:</label>
        <div>
        <select required  v-model="subcategory.category_id" class="inputform">
      <option v-for="category in categories" :key="category.id" :value="category.id" >{{category.name}}</option>
     
    </select>
        </div>
      </div>
       <div class="myform">
        <label for="category">Subcategory:</label>
        <div>
        <input type="text" required v-model="subcategory.name" class="inputform">
        </div>
      </div>

      
    </div>
    <div class="modal-footer">
                <button type="button" @click="addSubcategory()" class="btn btn-primary" > <i class="fa-light fa-plus"></i>Add</button>
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
        <h3 class="modal-title">Update Subcategory</h3>
      </div>
      <div class="modal-body">
      <div class="myform">
        <label for="category">Category:</label>
        <div>
        <select required  v-model="subcategory.category_id" class="inputform">
      <option v-for="category in categories" :key="category.id" :value="category.id" >{{category.name}}</option>
     
    </select>
        </div>
      </div>
       <div class="myform">
        <label for="category">Subcategory:</label>
        <div>
        <input type="text" required v-model="subcategory.name" class="inputform">
        </div>
      </div>


      
    </div>
    <div class="modal-footer">
                <button type="button" @click="updateSubcategory(subcategory.id)" class="btn btn-primary" > <i class="fa-solid fa-pen-to-square"></i>Update</button>
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
  name: "subcategory",
   components: {
        'Pagination': LaravelVuePagination

    },
   data() {
       return {
           message: '',
           subcategory: {name: '', category_id: ''},
           showModal : false,
           showupdateModal: false,
           categories: {},
           subcategories: {},

       }
   },

   methods: {

        getSubcategories(page = 1) {
            axios.get('/api/subcategories?page=' + page).then(res => {
             
                this.subcategories = res.data;
                this.categories = res.data.categories;
               
            }).catch(err => console.log(err));
        },
        getSubcategory(id)
            {
                 axios.get('/api/subcategories/' + id)
                .then(res => {
                  
                    this.subcategory = res.data.data;
                }).catch(error => console.log(error));
            },
        addSubcategory() {
            
                axios.post('/api/subcategories', this.subcategory).then(res => {
                    if(res.data.status == 201) {
                      console.log('hello mtf');
                    Swal.fire(
  'Done',
  'Subcategory has been Successfully added',
  'success'
)
                    this.getSubcategories();
                    this.subcategory = {name: ''};
                    this.showModal = false;
                    }
                    else {
                        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: this.message,
 
});
                    }
                }).catch(err => console.log(err));
           
        },


        updateSubcategory(id) {
          axios.put('/api/subcategories/' + id, this.subcategory).then(res => {
            if(res.data.status == 201) {
                Swal.fire(
  'Done',
  'Subcategory has been Successfully removed',
  'success'
)
                    this.getSubcategories();
                    this.subcategory = {name: '', category_id: ''};
                    this.showupdateModal = false;
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

        deleteSubcategory(id) {
          axios.delete('/api/subcategories/' + id, this.subcategory).then(res => {
               if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'Subcategory has been Successfully removed',
  'success'
)
                    
                    this.getSubcategories();

                    this.subategory = {name: '', category_id: ''};
                    }
                    else {
                        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: this.message,
 
});
                    }
          }).catch(err => console.log(err));
        }
        
    },
    
    mounted() {
            this.getSubcategories();
        }
    
}
</script>