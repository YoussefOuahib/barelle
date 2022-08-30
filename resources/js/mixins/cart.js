export default {
    methods: {
        increment() {
            this.cart.quantity++;
        },
        decrement() {
            this.cart.quantity > 1 ? this.cart.quantity-- : this.cart.quantity;
        },
        selectAttribute(index) {
            let collect = [];
            let price = parseInt(this.selected[index].myprice);
            this.options[index] = this.selected[index].myvalue;
            collect[index] = price;
            for (let i = 0; i < collect.length; i++) {
                this.total = this.total + collect[i];
            }
            this.total = this.total + this.product.sale_price;
        },
        

        addToCart() {
            let alreadyExisted = false;
            for (let i = 0; i < this.carts.length; i++) {
                if ( this.product.id == this.carts[i].id && this.options.toString() == this.carts[i].attributes) {
                    alreadyExisted = true;
                    this.carts[i].quantity = parseInt(this.carts[i].quantity) + parseInt(this.cart.quantity);
                    let mycart = JSON.stringify(this.carts);
                    localStorage.setItem("cart", mycart);
                    this.viewCart();
                }
            }
            if (alreadyExisted == false) {
                this.cart.id = this.product.id;
                this.cart.slug = this.product.slug;
                this.cart.product = this.product.name;
                this.cart.shipping_fee = this.product.shipping_fee;
                this.cart.price = (this.total > 0 ? this.total : this.product.sale_price) * this.cart.quantity;
                this.cart.attributes = this.options.toString()
                    ? this.options.toString()
                    : "";
                this.carts.push(this.cart);
                this.cart = { quantity: 1 };
                this.storeCart();
            }
        },
    
    storeCart() {
        let mycart = JSON.stringify(this.carts);
        localStorage.setItem("cart", mycart);
        this.viewCart();
    },
    viewCart() {
        let total_price = 0;
        if (localStorage.getItem("cart")) {
            this.carts = JSON.parse(localStorage.getItem("cart"));
            total_price = this.carts.reduce((price, item) => {
                return price + item.quantity * item.price;
            }, 0);

            this.$emit("cart", this.carts);

        }
    },
}
}
    
