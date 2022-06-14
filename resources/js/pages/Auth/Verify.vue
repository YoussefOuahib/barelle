<template>
    <div>
       
        <!-- Button trigger modal -->
<button type="button" @click="verify" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Verify Now
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title center" id="exampleModalLabel">Email Verification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body text-center">
           <div style="position: relative; left: 45%;">
      <socket v-if="!isloaded"></socket>
      </div>
              <h6 class="padding-top: 20px" v-if="!isloaded">Loading...</h6>

        <h6 class="padding-top: 20px" v-if="isloaded">{{this.msg}}</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-if="isloaded" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
            

    </div>
</template>

<script>
export default {
    name: 'verify',
    data() {
        return {
            msg: '',
            isloaded: true,
            logged: JSON.parse(localStorage.getItem('logged')) || false,

        }
    },
    beforeRouteEnter (to, from, next) {
      if (this.logged) {
            return next('/');
        }
        if(window.Laravel.user.email_verified_at != null) {
            
            return next('/');
        }
      
        next()
    },
    
    methods : {
        verify() {
            
            this.isloaded = false;
       
            axios.get('/sanctum/csrf-cookie').then(response => {
               
                axios.get('api/email/resend').then(res => {
                 
                    
                    console.log(res.data.msg);
                    this.msg = res.data.msg
                    this.isloaded = true;
                   
                });
            });
        }
    }
}
</script>