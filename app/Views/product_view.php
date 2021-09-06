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
                <v-container :fluid="true">
                                    
                    <!-- Table List Product -->
                    <template>
                        <v-card>
                            <v-card-title>
                                Products
                                <!-- Button Add New Product -->
                                 <v-btn color="primary" dark @click="modalAddOpen">Add New</v-btn>
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
                                </v-text-field>
                            </v-card-title>


                            <v-data-table :headers="headers" :items="products" :items-per-page="10" :loading="loading" :search="search" class="elevation-1" loading-text="Loading... Please wait" dense>
                                <template v-slot:item="row">
                                    <tr>
                                        <td>{{row.item.product_id}}</td>
                                        <td><v-img :src="row.item.product_image" class="me-3" width="60" style="float:left;"></v-img>
                                            <h3>{{row.item.product_name}}</h3>
                                        </td>
                                        <td>{{row.item.product_price}}</td>
                                        <td>
                                            <v-switch v-model="row.item.active" value="active" false-value="0" true-value="1" color="success" value="success" fluid @click="activeItem(row.item)"></v-switch>
                                        </td>
                                        <td>
                                            <v-icon class="mr-2" @click="editItem(row.item)">
                                                 mdi-pencil
                                            </v-icon>
                                            <v-icon color="red" @click="deleteItem(row.item)">
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
                            <v-dialog v-model="modalAdd" fullscreen hide-overlay transition="dialog-bottom-transition">
                                <v-card>
                                    <v-toolbar dark color="primary">
                                    <v-btn icon dark @click="modalAddClose">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                    <v-toolbar-title>Settings</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-toolbar-items>
                                        <v-btn dark text @click="saveProduct" :loading="loading" >
                                        Simpan
                                        </v-btn>
                                    </v-toolbar-items>
                                    </v-toolbar>
                                    <v-form ref="form" v-model="valid">
                                        <v-card-title>
                                            <span class="text-h5">Add Product</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container :fluid="true">
                                                <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                                                <v-row>
                                                    <v-col cols="12">
                                                    <!--<v-file-input
                                                    v-model="foto"
                                                    accept="image/png, image/jpeg, image/bmp"
                                                    placeholder="Pick an avatar"
                                                    prepend-icon="mdi-camera"
                                                    label="Avatar"
                                                    @change="readFotoReg(event)"
                                                    clearable="false"
                                                    ></v-file-input>
                                                    <img id='outputFotoReg' style="width:100px;">-->
                                                    <v-image-input v-model="foto" :clearable="true" :hide-actions="false" :image-width="700" :image-height="700" image-format="jpg,jpeg,png" overlay-padding="50px" @input="onFileInfo" />    
                                                    </v-col>
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
                                            <v-btn color="blue darken-1" text @click="modalAddClose">Close</v-btn>
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
                                    <v-form ref="form" v-model="valid">
                                        <v-card-title>
                                            <span class="text-h5">Edit Product</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field label="Product Name*" v-model="productNameEdit" :rules="textRules" required></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-text-field label="Price*" v-model="productPriceEdit" :rules="textRules" required>
                                                        </v-text-field>
                                                    </v-col>

                                                </v-row>
                                            </v-container>
                                            <small>*indicates required field</small>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="modalEditClose">Close</v-btn>
                                             <v-btn color="primary darken-1" dark @click="updateProduct" :loading="loading">Update</v-btn>
                                        </v-card-actions>
                                    </v-form>
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
                                    <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="modalDelete = false">No</v-btn>
                                         <v-btn color="blue darken-1" text @click="deleteProduct" :loading="loading">Yes</v-btn>
                                        <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-row>
                    </template>              
                    <!-- End Modal Delete Product -->
                     
                    <v-snackbar v-model="snackbar" absolute top centered :color="snackbarType" :timeout="timeout">
                        <span v-if="snackbar">{{snackbarMessage}}</span>

                        <template v-slot:action="{ attrs }">
                            <v-btn text v-bind="attrs" @click="snackbar = false">
                                Close
                            </v-btn>
                        </template>
                    </v-snackbar>   

                    <v-snackbar v-model="ui.snackbar.fileInfo" :timeout="5000">
                        <span v-if="fileInfo">{{ fileInfoMessage }}</span>
                    </v-snackbar>
                             
                </v-container>
            </v-main>
        </v-app>
    </div>
     
    <script src="https://vuejs.org/js/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://unpkg.com/vuetify-image-input"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function b64toBlob(b64Data, contentType, sliceSize) {
            contentType = contentType || '';
            sliceSize = sliceSize || 512;

            var byteCharacters = atob(b64Data);
            var byteArrays = [];

            for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                var slice = byteCharacters.slice(offset, offset + sliceSize);

                var byteNumbers = new Array(slice.length);
                for (var i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                var byteArray = new Uint8Array(byteNumbers);

                byteArrays.push(byteArray);
            }

            var blob = new Blob(byteArrays, {
                type: contentType
            });
            return blob;
        }

        var vue = null;
        var dataVue = {
            search: '',
            headers: [{
                    text: 'ID',
                    value: 'product_id'
                },
                {
                    text: 'INFO PRODUK',
                    value: 'product_name'
                },
                {
                    text: 'HARGA',
                    value: 'product_price'
                },
                {
                    text: 'AKTIF',
                    value: 'active'
                },
                {
                    text: 'ATUR',
                    value: 'actions',
                    sortable: false
                },
            ],
            products: [],
            modalAdd: false,
            productName: '',
            productPrice: '',
            productImage: null,
            foto: null,
            active: '',
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
            notifMessage: '',
            notifType: '',
            snackbar: false,
            timeout: 4000,
            snackbarType: '',
            snackbarMessage: '',
            outputFotoReg: null,
            fileInfo: null,
            ui: {
                drawer: true,
                snackbar: {
                    fileInfo: false,
                },
            },
            fotoID: null
        }
        var createdVue = function() {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            this.getProducts();
        }
        var mountedVue = function() {}
        var watchVue = {}
        var methodsVue = {
            modalAddOpen: function() {
                this.modalAdd = true;
                this.fotoID = '';
                this.foto = null;
                this.notifType = '';
                this.textRules = [
                    v => !!v || 'Field is required',
                    //v => v.length <= 10 || 'Name must be less than 10 characters',
                ];
                this.emailRules = [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ];
            },
            modalAddClose: function() {
                this.productName = '';
                this.productPrice = '';
                this.fotoID = null;
                this.foto = null;
                this.modalAdd = false;
                this.$refs.form.resetValidation();
            },
            // Get Product
            getProducts: function() {
                this.loading = true;
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
            readFotoReg: function(event) {
                var input = event.target;
                // vue.fotoReg = input.files[0]
                var reader = new FileReader();
                reader.onload = function() {
                    var dataURL = reader.result;
                    var output = document.getElementById('outputFotoReg');
                    output.src = dataURL;
                };
                var fileName = input.files[0].name;
                reader.readAsDataURL(input.files[0]);
                //this.imageUpload(input.files[0],fileName)
            },
            onFileInfo(value) {
                this.fileInfo = value;
                //this.ui.snackbar.fileInfo = true;
                this.imageUpload(value);
            },
            imageUpload: function(file) {
                var formData = new FormData()
                // Split the base64 string in data and contentType
                var block = file.split(";");
                // Get the content type of the image
                var contentType = block[0].split(":")[1]; // In this case "image/gif"
                // get the real base64 content of the file
                var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

                // Convert it to a blob to upload
                var blob = b64toBlob(realData, contentType);
                formData.append('foto', blob);
                axios({
                        method: 'post',
                        url: '/imageupload',
                        data: formData,
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(res => {
                        // handle success
                        this.loading = false
                        var data = res.data;
                        if (data.status == true) {
                            this.ui.snackbar.fileInfo = true;
                            this.fileInfoMessage = data.message;
                            this.fotoID = data.data
                        } else {
                            this.notifType = "error";
                            this.notifMessage = data.message;
                        }
                    })
                    .catch(err => {
                        // handle error
                        console.log(err.response);
                        this.loading = false
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
                            product_image: this.fotoID,
                        },
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => {
                        // handle success
                        this.loading = false
                        var data = res.data;
                        if (data.status == true) {
                            this.snackbar = true;
                            this.snackbarType = "success";
                            this.snackbarMessage = data.message;
                            this.getProducts();
                            this.productName = '';
                            this.productPrice = '';
                            this.fotoID = null;
                            this.foto = null;
                            this.modalAdd = false;
                            this.$refs.form.resetValidation();
                        } else {
                            this.notifType = "error";
                            this.notifMessage = data.message;
                            this.modalAdd = true;
                            this.$refs.form.validate();
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
                this.notifType = "";
                this.textRules = [
                    v => !!v || 'Field is required',
                    //v => v.length <= 10 || 'Name must be less than 10 characters',
                ];
                this.emailRules = [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ];
                this.productIdEdit = product.product_id;
                this.productNameEdit = product.product_name;
                this.productPriceEdit = product.product_price;
            },
            modalEditClose: function() {
                this.modalEdit = false;
                this.$refs.form.resetValidation();
            },

            //Update Product
            updateProduct: function() {
                this.loading = true;
                axios.put(`product/update/${this.productIdEdit}`, {
                        product_name: this.productNameEdit,
                        product_price: this.productPriceEdit
                    })
                    .then(res => {
                        // handle success
                        this.loading = false;
                        var data = res.data;
                        if (data.status == true) {
                            this.snackbar = true;
                            this.snackbarType = "success";
                            this.snackbarMessage = data.message;
                            this.getProducts();
                            this.productName = '';
                            this.productPrice = '';
                            this.modalEdit = false;
                            this.$refs.form.resetValidation();
                        } else {
                            this.notifType = "error";
                            this.notifMessage = data.message;
                            this.modalEdit = true;
                            this.$refs.form.validate();
                        }
                    })
                    .catch(err => {
                        // handle error
                        console.log(err.response);
                        this.loading = false
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
                this.loading = true;
                axios.delete(`product/delete/${this.productIdDelete}`)
                    .then(res => {
                        // handle success
                        this.loading = false;
                        var data = res.data;
                        if (data.status == true) {
                            this.snackbar = true;
                            this.snackbarType = "success";
                            this.snackbarMessage = data.message;
                            this.getProducts();
                            this.modalDelete = false;
                        } else {
                            this.notifType = "error";
                            this.notifMessage = data.message;
                            this.modalDelete = true;
                        }
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                        this.loading = false;
                    })
            },

            // Set Item Active Product
            activeItem: function(product) {
                this.loading = true;
                this.productIdEdit = product.product_id;
                this.active = product.active;
                axios.put(`productactive/update/${this.productIdEdit}`, {
                        active: this.active,
                    })
                    .then(res => {
                        // handle success
                        this.loading = false;
                        var data = res.data;
                        if (data.status == true) {
                            this.snackbar = true;
                            this.snackbarType = "success";
                            this.snackbarMessage = data.message;
                            this.getProducts();
                        }
                    })
                    .catch(err => {
                        // handle error
                        console.log(err.response);
                        this.loading = false
                    })
            },
            
        }
    </script>
    <?= $this->renderSection('js') ?>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data: dataVue,
            mounted: mountedVue,
            created: createdVue,
            watch: watchVue,
            methods: methodsVue
        })
    </script>
</body>

</html>