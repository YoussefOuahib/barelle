
<template>

    <div>
        <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
					<span class="login100-form-title p-b-26">
						Login 
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" v-model="user.email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" v-model="user.password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" @click="login()" class="login100-form-btn">
								Login
							</button>
						</div>
					</div>
					<div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

						<router-link :to="{ name: 'register' }">Sign Up</router-link>
							
						
					</div>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
    </div>
</template>
<script>
export default {
	

    data() {
        return {
			message: '',
			logged: JSON.parse(localStorage.getItem('logged')) || false,
            user: {email: "", password: ""}
        }
    },
	beforeRouteEnter(to, from, next) {
        if (JSON.parse(localStorage.getItem('logged'))) {
            return next('home');
        }
        next();
    },
	
	methods: {
		login() {
			axios.get('/sanctum/csrf-cookie').then(response => {
  

			axios.post('api/login', this.user)
			.then(res => {
				if(res.data.logged == true) {
					console.log(res.data.logged);
					this.message = res.data.message;
					localStorage.setItem('logged', JSON.stringify(true));
					localStorage.setItem('admin', JSON.stringify(res.data.isAdmin));
					localStorage.setItem('name',JSON.stringify(res.data.name));					
					this.$router.go({name: 'home'});

				}
				else {
					
					this.message = response.data.message;
					Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: this.message,
 
})
     
					this.user = {email: "", password: ""};

					setTimeout(() => {
						this.message = '';
					}, 2000)
				}
			}).catch(err => console.log(err));
			});
			
		}
	}
  
}
</script>
<style scoped>
  @import '../../assets/login/css/main.css';
    @import '../../assets/login/css/util.css';

</style>
