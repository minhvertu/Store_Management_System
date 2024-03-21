<template>
    <div>
        <h2 v-if="isNewProduct">Add Product</h2>
        <h2 v-else>Edit Product</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" type="text"  id="name" v-model="product.name" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Amount</label>
                <input class="form-control" id="amount" v-model="product.amount" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Type</label>
                <input class="form-control" id="product_type" v-model="product.product_type" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Code</label>
                <input class="form-control" id="product_code" v-model="product.product_code" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Import Price</label>
                <input class="form-control" id="import_price" v-model="product.import_price" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Sell Price</label>
                <input class="form-control" id="sell_price" v-model="product.sell_price" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Gender</label>
                <input class="form-control" id="gender_item_code" v-model="product.gender_item_code" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Size</label>
                <input class="form-control" id="size" v-model="product.size" />
            </div>
            <div>
                <button type="submit" v-if="isNewProduct" class="btn btn-primary">Add Product</button>
                <button type="submit" v-else class="btn btn-primary">Update Product</button>
                <button  @click="$router.push('/productList')" class="mx-2 p-2 col border btn btn-success">Back</button>
            </div>
        </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        product: {
          id: '',
          name: '',
          amount: '',
          product_code: '',
          product_type: '',
          import_price: '',
          sell_price: '',
          gender_item_code: '',
          size: '',
        }
      };
    },
    computed: {
      isNewProduct() {
        console.log(this.$route.path);
        return !this.$route.path.includes('edit');
      }
    },
    async created() {
      if (!this.isNewProduct) {
        const response = await axios.get(`/api/products/${this.$route.params.id}`);
        this.product = response.data;
      }
    },
    // saveProduct () {
    //     axios.post('api/products', {
    //         salary_code: this.salary_code,
    //         name: this.name,
    //         card_id: this.card_id,
    //         phone_number: this.phone_number,
    //         product_code: this.product_code,
    //     })
    //     .then(response => {
    //         if (response.data.status === false) {
    //             this.error.message = response.data.message
    //             setTimeout(() => {
    //                 this.error.message = ''
    //             }, 3000)
    //         } else {
    //             this.products.push(response.data)
    //         }
    //     })
    //     .catch(error => {
    //         console.log(error)
    //     })
    // },
    methods: {
      async submitForm() {
        try {
            if (this.isNewProduct) {
            await axios.post('/api/products', this.product);
            alert('Add Product Successfully');
            this.$router.push('/productList');
          } else if (!this.isNewProduct){
            await axios.put(`/api/products/${this.$route.params.id}`, this.product);
            alert('Update Successfully');
            this.$router.push('/productList');
          } else {
            alert("You don't have permission to add product");
            this.$router.push('/productList');
          }
        } catch (error) {
          console.error(error);
        }
      },
    },

//     async mounted() {
//     try {
//     const response = await axios.get(`/api/products/${this.$route.params.id}`);
//     this.product = response.data;
//     console.log(response.data)
//     } catch (error) {
//     console.error(error);
//     }
// }
  }
  </script>