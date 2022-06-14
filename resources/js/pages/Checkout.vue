<template>
    <div>
      <div class="breadcumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                CHECKOUT
            </div>
        </div>
    </div>
</div>

		<!-- SECTION -->
		<div class="section my-4">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class="col-md-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title mb-4 ">
								<h3 class="title">Billing address</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" v-model="order.first_name" placeholder="First Name">
							</div>
							<div class="form-group">
								<input class="input" type="text" v-model="order.last_name" placeholder="Last Name">
							</div>
							<div class="form-group">
								<input class="input" type="email" v-model="order.email" placeholder="Email">
							</div>
							<div class="form-group">
								<input class="input" type="text" v-model="order.address" placeholder="Address">
							</div>
						
							
							<div class="form-group">
								<input class="input" type="tel" v-model="order.phone" placeholder="Telephone">
							</div>
						
						</div>
						<!-- /Billing Details -->


						<!-- Order notes -->
						<div class="order-notes">
							<textarea class="input" v-model="order.note" placeholder="Order Notes"></textarea>
						</div>
						<!-- /Order notes -->
					</div>

					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>PRODUCT</strong></div>
								<div><strong>TOTAL</strong></div>
							</div>
							<div class="order-products">
								<div  v-for="item in cart" :key="item.id"  class="order-col">
									<div>{{item.quantity}}x {{item.product}}</div>
									<div>{{item.price}}</div>
								</div>
								
							</div>
							<div class="order-col">
								<div>Shiping</div>
								<div>
									<strong>{{shipping_fee}}</strong>
									</div>
							</div>
							<div class="order-col">
								<div><strong>TOTAL</strong></div>
								<div><strong class="order-total">{{total}} MAD</strong></div>
							</div>
						</div>
						<div class="payment-method">
							<div class="input-radio">
								<input type="radio" v-model="order.payment" value="Direct Bank Transfert" name="payment" id="payment-1">
								<label for="payment-1">
									<span></span>
									Direct Bank Transfer
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" v-model="order.payment" value="Cash On delivery" name="payment" id="payment-2">
								<label for="payment-2">
									<span></span>
									Cash On Delivery
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" v-model="order.payment" value="PAYPAL" name="payment" id="payment-3">
								<label for="payment-3">
									<span></span>
									Paypal System
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="terms">
							<label for="terms">
								<span></span>
								I've read and accept the <a href="#">terms & conditions</a>
							</label>
						</div>
						<a @click="makeOrder()" class="checkout-btn order-submit">Place order</a>
					</div>
					<!-- /Order Details -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

    </div>
</template>
<script>
export default {
    name: "checkout",
	data() {
		return {
	  cart: JSON.parse(localStorage.getItem('cart')) || '' ,
      total_price : 0,
	 cartItems: [],
	 qty : 0,
	  order: {first_name: '',last_name: '', email: '', address: '', item_count: '',phone: '', payment: '', note: ''},
		}
	},
	computed: {
		shipping_fee: function() {
			
				 return this.cart.reduce((fee,item) => {
            return fee + item.shipping_fee;
                }, 0);
			},
			total : function() {
				return this.shipping_fee + this.total_price;
			}
		
	},
	methods : {
		makeOrder()
		{
			const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               
          let formData = new FormData();
		   formData.append('first_name', this.order.first_name);
          formData.append('last_name', this.order.last_name);
          formData.append('address', this.order.address);
		formData.append('email', this.order.email);
          formData.append('phone', this.order.phone);
		  formData.append('payment', this.order.payment);
		  formData.append('total', this.total);
		formData.append('note', this.note);
		  formData.append('item_count', this.qty);
		  formData.append('cart', JSON.stringify(this.cartItems));
		   axios.post('/api/orders', formData, config).then(res => {
                    if(res.status == 201) {
                    Swal.fire(
  'Done',
  'Your order has been placed',
  'success'
)
                    this.order = {};
					localStorage.removeItem('cart');
                   
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
		 viewCart()
    {
      if(localStorage.getItem('cart')) {
        this.cart = JSON.parse(localStorage.getItem('cart'));
          this.total_price = this.cart.reduce((price,item) => {
            return price + item.quantity * item.price
                }, 0);
        
        this.badge = this.cart.length;
		for (let i = 0; i < this.cart.length; i++) {
			 this.qty = this.qty + this.cart[i].quantity;
			
		}
	
	
        }
        },
	},
	mounted() {
		
		for (let i = 0; i < this.cart.length; i++) {
			this.cartItems.push(this.cart[i]);
		
			
		}

	
	},
	created() {
		this.viewCart();
	},
}
</script>

<style scoped>


</style>