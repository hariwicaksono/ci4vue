<!DOCTYPE html>
<html lang="en">

<head>
        
    <meta charset="UTF-8">
        
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Product List</title>
        
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
        
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                                    
                    <!-- Table List Product -->
                    <template>
                        <v-card>
                            <v-card-title>
                                Products
                                <!-- Button Add New Product -->
                                 <v-btn color="primary" dark @click="modalAddOpen">Add New</v-btn>
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line
                                    hide-details>
                                </v-text-field>
                            </v-card-title>


                            <v-data-table :headers="headers" :items="products" :items-per-page="5" :loading="loading"
                                :search="search" class="elevation-1" loading-text="Loading... Please wait">
                                <template v-slot:item="row">
                                    <tr>
                                        <td>{{row.item.product_id}}</td>
                                        <td>{{row.item.product_name}}</td>
                                        <td>{{row.item.product_price}}</td>
                                        <td>
                                            <v-icon small class="mr-2" @click="editItem(row.item)">
                                                 mdi-pencil
                                            </v-icon>
                                            <v-icon small @click="deleteItem(row.item)">
                                                mdi-delete
                                            </v-icon>
                                        </td>
                                    </tr>
                                </template>
                                                    
                            </v-data-table>
                        </v-card>
                                            
                        <!--<v-simple-table>
                                    <template v-slot:default>
                                        <thead>
                                                <tr>
                                                        <th class="text-left">Product Name</th>
                                                        <th class="text-left">Price</th>
                                                        <th class="text-left">Actions</th>
                                                    </tr>
                                            </thead>
                                        <tbody>
                                                <tr v-for="product in products" :key="product.product_id">
                                                        <td>{{ product.product_name }}</td>
                                                        <td>{{ product.product_price }}</td>
                                                        <td>
                                                            <template>
                                                                    <v-icon small class="mr-2" @click="editItem(product)">
                                                                            mdi-pencil
                                                                        </v-icon>
                                                                    <v-icon small @click="deleteItem(product)">
                                                                            mdi-delete
                                                                        </v-icon>
                                                                </template>
                                                            </td>
                                                    </tr>
                                            </tbody>
                                        </template>
                                </v-simple-table>-->
                         

                    </template>
                                    
                    <!-- End Table List Product -->
                                     
                                    
                    <!-- Modal Save Product -->
                    <template>
                        <v-row justify="center">
                            <v-dialog v-model="modalAdd" persistent max-width="600px">
                                <v-card>
                                <v-form ref="form" v-model="valid">
                                    <v-card-title>
                                        <span class="text-h5">Add Product</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                        <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-text-field label="Product Name*" v-model="productName" :rules="textRules" required>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-text-field label="Price*" v-model="productPrice" :rules="textRules" required>
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                        <small>*indicates required field</small>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="modalAddClose" >Close</v-btn>
                                         <v-btn color="primary" dark @click="saveProduct" :loading="loading">Save</v-btn>
                                    </v-card-actions>
                                </v-form>
                                </v-card>
                            </v-dialog>
                        </v-row>
                    </template>     
                    <!-- End Modal Save Product -->
                     
                                    
                    <!-- Modal Edit Product -->
                    <template>
                        <v-row justify="center">
                            <v-dialog v-model="modalEdit" persistent max-width="600px">
                                <v-card>
                                    <v-card-title>
                                        <span class="text-h5">Edit Product</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>

                                                <v-col cols="12">
                                                    <v-text-field label="Product Name*" v-model="productNameEdit"
                                                        required></v-text-field>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-text-field label="Price*" v-model="productPriceEdit" required>
                                                    </v-text-field>
                                                </v-col>

                                            </v-row>
                                        </v-container>
                                        <small>*indicates required field</small>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="modalEdit = false">Close</v-btn>
                                         <v-btn color="blue darken-1" text @click="updateProduct">Update</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-row>
                    </template>  
                    <!-- End Modal Edit Product -->
                     
                                    
                    <!-- Modal Delete Product -->
                    <template>
                        <v-row justify="center">
                            <v-dialog v-model="modalDelete" persistent max-width="600px">
                                <v-card>
                                    <v-card-title>
                                        <span class="text-h5">Delete</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                               <h3>Are sure want to delete <strong>"{{ productNameDelete }}"</strong> ?</h3>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="modalDelete = false">No</v-btn>
                                         <v-btn color="blue darken-1" text @click="deleteProduct">Yes</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-row>
                    </template>              
                    <!-- End Modal Delete Product -->
                     
                    <v-snackbar
                    v-model="snackbar" absolute top centered color="success" :timeout="timeout"
                    >
                    {{ notifMessage }}

                    <template v-slot:action="{ attrs }">
                        <v-btn
                        text
                        v-bind="attrs"
                        @click="snackbar = false"
                        >
                        Close
                        </v-btn>
                    </template>
                    </v-snackbar>            
                </v-container>
            </v-main>
        </v-app>
    </div>
     
    <script src="https://vuejs.org/js/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            search: '',
            headers: [{
                    text: 'ID',
                    value: 'product_id'
                },
                {
                    text: 'Nama Produk',
                    value: 'product_name'
                },
                {
                    text: 'Harga',
                    value: 'product_price'
                },
                {
                    text: 'Aksi',
                    value: 'actions',
                    sortable: false
                },
            ],
            products: [],
            modalAdd: false,
            productName: '',
            productPrice: '',
            modalEdit: false,
            productIdEdit: '',
            productNameEdit: '',
            productPriceEdit: '',
            modalDelete: false,
            productIdDelete: '',
            productNameDelete: '',
            loading: true,
            valid: true,
            textRules: [],
            emailRules: [],
            notifMessage: "",
            notifType: "",
            snackbar: false,
            timeout: 2000,
        },
        created: function() {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            this.getProducts();
        },
        watch: {
        },
        methods: {
            cleanNotif: function() {
                this.notifMessage = "";
                this.notifType = "";
            },
            cleanFormLogin: function() {
                this.cleanNotif()
            },
            modalAddOpen: function()
            {
                this.modalAdd = true;
                this.notifType = "";
                this.textRules = [
                    v => !!v || 'Field is required',
                    //v => v.length <= 10 || 'Name must be less than 10 characters',
                ];
                this.emailRules = [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ];
            },
            modalAddClose: function()
            {
                this.modalAdd = false;
                this.$refs.form.resetValidation();
            },
            // Get Product
            getProducts: function() {
                this.loading = true;
                this.notifMessage = "";
                axios.get('product/getproduct')
                    .then(res => {
                        // handle success
                        this.loading = false;
                        this.products = res.data.data;
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                    })
            },
            // Save Product
            saveProduct: function() {
                this.loading = true;
                axios({
                    method: 'post',
                    url: '/product/save',
                    data: {
                        product_name: this.productName,
                        product_price: this.productPrice,
                    },
                    headers: {
                        "Content-Type": "application/json"
                    }
                    })
                    .then(res => {
                        // handle success
                        this.loading = false
                        var data = res.data;
                      
                            if (data.status == false) {
                                this.notifType = "error";
                                this.notifMessage = data.message;
                                this.loading = false;
                                this.modalAdd = true;
                                this.$refs.form.validate();
                            } else {
                                this.snackbar = true;
                                this.notifMessage = data.message;
                                this.getProducts();
                                this.productName = '';
                                this.productPrice = '';
                                this.modalAdd = false;
                                this.$refs.form.resetValidation();
                            }
                        
                       
                    })
                    .catch(err => {
                        // handle error
                        console.log(err.response);
                        this.loading = false
                    })
            },

            // Get Item Edit Product
            editItem: function(product) {
                this.modalEdit = true;
                this.productIdEdit = product.product_id;
                this.productNameEdit = product.product_name;
                this.productPriceEdit = product.product_price;
            },

            //Update Product
            updateProduct: function() {
                axios.put(`product/update/${this.productIdEdit}`, {
                        product_id: this.productIdEdit,
                        product_name: this.productNameEdit,
                        product_price: this.productPriceEdit
                    })
                    .then(res => {
                        // handle success
                        var data = res.data;
                        this.snackbar = true;
                        this.notifMessage = res.data.message;
                        this.getProducts();
                        this.modalEdit = false;
                        console.log(res.data.message);
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                    })
            },

            // Get Item Delete Product
            deleteItem: function(product) {
                this.modalDelete = true;
                this.productIdDelete = product.product_id;
                this.productNameDelete = product.product_name;
            },

            // Delete Product
            deleteProduct: function() {
                axios.delete(`product/delete/${this.productIdDelete}`)
                    .then(res => {
                        // handle success
                        this.getProducts();
                        this.modalDelete = false;
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                    })
            }

        },

    })
    </script>
</body>

</html>