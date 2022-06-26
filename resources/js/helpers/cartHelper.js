import Vue from 'vue'
window.e = new Vue();
 class cartHelper {
    addToCart(cart, options, product) {
        let total = 0;
        let carts = JSON.parse(localStorage.getItem("cart"));
        let alreadyExisted = false;
        for (let i = 0; i < carts.length; i++) {
            if (product.id == carts[i].id && options.toString() == carts[i].attributes ) {
                alreadyExisted = true;
                carts[i].quantity =
                    parseInt(carts[i].quantity) + parseInt(cart.quantity);

                let mycart = JSON.stringify(carts);
                localStorage.setItem("cart", mycart);
            }
        }
        if (alreadyExisted == false) {
            cart.id = product.id;
            cart.slug = product.slug;
            cart.product = product.name;
            cart.shipping_fee = product.shipping_fee;
            cart.price = (total > 0 ? total : product.sale_price) * cart.quantity;
            cart.attributes = options.toString() ? options.toString() : "";
            carts.push(cart);
            cart = { quantity: 1 };
            let mycart = JSON.stringify(carts);
            localStorage.setItem("cart", mycart);
            this.viewCart();
        }
    }

    viewCart() {
        let total_price = 0;
        if (localStorage.getItem("cart")) {
            let carts = JSON.parse(localStorage.getItem("cart"));
            total_price = carts.reduce((price, item) => {
                return price + item.quantity * item.price;
            }, 0);
            e.$emit('cart', carts);
        }
    }
};
export default cartHelper = new cartHelper();
