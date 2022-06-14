<template>
<div>
  <main>
            <!-- end of insights-->
            <div class="recent-orders">
                <h2>Attributes</h2>
              <div class="button" @click="showModal = true;">
                <span class="material-icons-sharp">add</span>
               <h3 >Add Attribute</h3>

               
              </div>
              <div class="control-panel">
                <table>
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th></th>
                         
                        </tr>
                    </thead>
                   
  <tbody>
     <tr v-for="attribute in attributes.data" :key="attribute.id">
   
      <td>{{attribute.name}}</td>
     
     
         <td>
        <button style="background: transparent;" type="button" @click="getAttribute(attribute.id);showupdateModal = true;"><span style="cursor: pointer;" class="primary material-icons-sharp">edit</span></button>
        <button style="background: transparent;" type="button"  @click="deleteAttribute(attribute.id)"><span style="cursor: pointer;" class="danger material-icons-sharp">delete</span></button>
        

      </td>
      
      
    </tr>
                     
                    </tbody>
                </table>
              </div>
                <div class="pagination">
             <Pagination  :data="attributes" @pagination-change-page="getAttributes" />
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
        <h3 class="modal-title">Add Attribute</h3>
      </div>
      <div class="modal-body">
      
      <div class="myform">
        <label for="name">Attribute:</label>
        <div>
        <input type="text" required v-model="attribute.name" class="inputform">
        </div>
      </div>

      
    </div>
    <div class="modal-footer">
                <button type="button" @click="addAttribute()" class="btn btn-primary" > <i class="fa-light fa-plus"></i>Add</button>
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
        <h3 class="modal-title">Update Attribute</h3>
      </div>
      <div class="modal-body">
      
      <div class="myform">
        <label for="name">Attribute:</label>
        <div>
        <input type="text" required v-model="attribute.name" class="inputform">
        </div>
      </div>

      
    </div>
    <div class="modal-footer">
                <button type="button" @click="updateAttribute(attribute.id)" class="btn btn-primary" > <i class="fa-solid fa-pen-to-square"></i>Update</button>
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
    name: "attribute",
    components: {
        'Pagination': LaravelVuePagination

    },
    data() {
        return {
            message : '',
            attributes: {},
            attribute: {name: ''},
            showModal : false,
            showupdateModal: false,


        }
    },
    methods: {
        getAttributes() {
          
            axios.get('/api/attributes').then(res => {
                this.attributes = res.data;
            }).catch(err => console.log(err));
        },
        getAttribute(id)
            {
                 axios.get('/api/attributes/' + id)
                .then(res => {
                  
                    this.attribute = res.data.data;
                }).catch(error => console.log(error));
            },
        addAttribute() {
            
                axios.post('/api/attributes', this.attribute).then(res => {
                    if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'attribute has been Successfully added',
  'success'
)
                    this.getAttributes();
                    this.attribute = {name: ''};
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


        updateAttribute(id) {
          axios.put('/api/attributes/' + id, this.attribute).then(res => {
            if(res.data.status == 201) {
                Swal.fire(
  'Done',
  'attribute has been Successfully updated',
  'success'
)
                    this.getAttributes();
                    this.attribute = {name: ''};
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

        deleteAttribute(id) {
           
          axios.delete('/api/attributes/' + id, this.attribute).then(res => {
           
               if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'attribute has been Successfully removed',
  'success'
)
                    this.getAttributes();
                    this.attribute = {name: ''};
                    }
                    
            
           
          }).catch(err => console.log(err));
           
        }
        
        
    },
    mounted() {

            this.getAttributes();
        }
}
</script>