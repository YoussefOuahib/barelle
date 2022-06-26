<template>
    <div>
        <main>
        <div class="inline-form">
        <div class="myform">
        <label for="name">Brand*</label>
        <div>
                <input type="text" placeholder="Tesla / Amazon / ..." required v-model="settings.name" class="inputform">

        </div>
      </div>
      <div class="myform">
        <label for="category">Email*</label>
        <div>
         <input type="email" placeholder="admin@brand.com" required v-model="settings.email" class="inputform">
        </div>

      </div>
        </div>
         <div class="inline-form">
        <div class="myform">
        <label for="name">Phone*</label>
        <div>
                <input type="number" required v-model="settings.phone_number" class="inputform">

        </div>
      </div>
      <div class="myform">
        <label for="category">Address</label>
        <div>
         <input type="text" placeholder="leave it bland if you have no office"  v-model="settings.address" class="inputform">
        </div>

      </div>
        </div>
         <div class="myform">
        <label for="name">Google Maps Link</label>
        <div>
        <input type="text" placeholder="https://wwww.google.com/maps/..." v-model="settings.map" class="inputform">
        </div>
      </div>
       <div class="myform" style="text-align:center">
            <h5> Click On the picture to upload the main picture </h5>
            <div>
           <label for="image" class="myimg">

 
    <img style="cursor:pointer;margin: 0 auto;" :src="'/storage/products/' + this.previewImg" height="150px" width="150px">



          </label>
            </div>
<input style="display: none" type="file" id="image"  @change="handleOnChange"/>
         </div>

         <div class="myform">
        <label for="name">Header text*</label>
        <div>
        <input type="text" required v-model="settings.header_text" placeholder="Welcome to our Store" class="inputform">
        </div>
      </div>

       <div class="myform">
        <label for="short_description">Footer Description*</label>
        <div>
    <textarea class="inputform" v-model="settings.footer_description" required placeholder="write a short description about your business" cols="20"></textarea>

        </div>
      </div>
      <div class="myform">
        <label for="name">Newsletter Header</label>
        <div>
        <input type="text" required  v-model="settings.newsletter_header" placeholder="Subscribe to our newsletter .." class="inputform">
        </div>
      </div>
      <div class="myform">
        <label for="name">Newsletter Text</label>
        <div>
        <input type="text" required v-model="settings.newsletter_text" placeholder="don't miss our updates .." class="inputform">
        </div>
      </div>
      <button type="button" @click="insertSettings()" class="btn btn-primary" > <i class="fa-light fa-plus"></i>Submit</button>
        </main>
    </div>
</template>
<script>
import placeholder from '../assets/images/placeholder.jpg'

export default {
    name: "settings",
    
    data(){
        return {
           previewImg : '',
           settings: { name: '', address: '', phone_number: '', email: '',logo: '',footer_description: '',map: '',header_text:'',newsletter_header:'',newsletter_text:'' },
            
        }
    },
    methods: {
        handleOnChange(e) {
       this.previewImg = '',
       this.settings.logo = '';
       if(e.target.files[0]){
        this.settings.logo  = e.target.files[0];
        this.previewImg = URL.createObjectURL(this.settings.logo);
        
       }
        },
        insertSettings() {
               const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               
          let formData = new FormData();
             formData.append('name', this.settings.name);
          formData.append('email', this.settings.email);
          formData.append('phone_number', this.settings.phone_number);
          formData.append('address', this.settings.address);
          formData.append('logo', this.settings.logo);
          formData.append('header_text', this.settings.header_text);
          formData.append('map', this.settings.map);
          formData.append('newsletter_header', this.settings.newsletter_header);
         formData.append('newsletter_text', this.settings.newsletter_text);
          formData.append('footer_description', this.settings.footer_description);
         axios.post('/api/settings', formData, config).then(res => {
                    if(res.data.status == 201) {
                    Swal.fire(
  'Done',
  'Settings has been Successfully set',
  'success'
)
                  
                    this.getSettings();
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
    
    getSettings() {
         axios.get('/api/settings')
                .then(res => {
            
              
                    this.settings = res.data.settings;
                    this.previewImg = this.settings.logo;

                   


                    
                   

                }).catch(error => console.log(error));
    },
    },
     created() {
        
        this.getSettings();
    }
   

}
</script>