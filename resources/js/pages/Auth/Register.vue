
<template>

    <div>
        <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
					<span class="login100-form-title p-b-26">
						Create your account
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>
                    <div class="wrap-input100 validate-input">
						<input class="input100" type="text" v-model="user.name" name="name">
						<span class="focus-input100" data-placeholder="Name"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" v-model="user.email" name="email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

                    <div class="wrap-input100 validate-input">
						<input class="input100" type="number" v-model="user.phone" name="phone">
						<span class="focus-input100" data-placeholder="Phone"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" v-model="user.password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>
					


					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" @click="register()" class="login100-form-btn">
								Register
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Already have an account ?
						</span>

						
					<router-link class="txt2" :to="{ name: 'login' }">
					Login</router-link>

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
            user: {name: "", email: "", phone: "", password: ""},
			

        }
    },
	beforeRouteEnter(to, from, next) {
        if (JSON.parse(localStorage.getItem('logged'))) {
            return next('home');
        }
        next();
    },
	methods: {
		register() {
			
			axios.get('/sanctum/csrf-cookie').then(response => {

			
            axios.post('api/register', this.user)
            .then(res => {
                this.message = res.data.message;
				this.logged = res.data.logged;
				localStorage.setItem('logged', true);

				  Swal.fire(
  'Done',
  this.message,
  'success'
)
				
				
                this.$router.go({name: 'home'});

            
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
