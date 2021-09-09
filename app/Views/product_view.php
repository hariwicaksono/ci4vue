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
    <style>
        html {
            overflow-y: hidden;
        }
    </style>
</head>

<body>
    <div id="app">
        <v-app>

            <v-app-bar app color="primary" dark elevation="2">
                <v-app-bar-nav-icon @click.stop="sidebarMenu = !sidebarMenu"></v-app-bar-nav-icon>
                <v-toolbar-title>Title</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn @click="toggleTheme" color="primary" class="mr-2">{{buttonText}}</v-btn>
            </v-app-bar>

            <v-navigation-drawer v-model="sidebarMenu" app floating :permanent="sidebarMenu" :mini-variant.sync="mini">
                <v-list dense elevation="2">
                    <v-list-item>
                        <v-list-item-action>
                            <v-icon @click.stop="toggleMini = !toggleMini">mdi-chevron-left</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                <h3>CI4Vue</h3>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-list-item class="px-2" @click="">
                    <v-list-item-avatar>
                        <v-icon>mdi-account-outline</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content class="text-truncate">
                        itshop.id
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list>
                    <v-list-item link href="/">
                        <v-list-item-icon>
                            <v-icon>mdi-home-outline</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Dashboard</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <template v-slot:append>
                    <v-divider></v-divider>
                    <div class="pa-3 text-center">
                        <span>&copy; {{ new Date().getFullYear() }}</span>
                    </div>
                </template>

            </v-navigation-drawer>

            <v-main>
                <v-container class="px-4 py-0 fill-height" fluid>
                    <v-row class="fill-height">
                        <v-col>
                            <!-- Table List Product -->
                            <v-card>
                                <v-card-text>
                                    <h1>Daftar Produk</h1>
                                </v-card-text>
                                <v-card-title>
                                    <!-- Button Add New Product -->
                                     <v-btn color="primary" dark @click="modalAddOpen">Tambah Produk</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
                                    </v-text-field>
                                </v-card-title>

                                <v-data-table :headers="headers" :items="products" :items-per-page="10" :loading="loading" :search="search" class="elevation-1" loading-text="Loading... Please wait" dense>
                                    <template v-slot:item="row">
                                        <tr>
                                            <td>{{row.item.product_id}}</td>
                                            <td>
                                                <v-avatar size="60px" rounded><img :src="row.item.media_path" /></v-avatar>
                                            </td>
                                            <td>
                                                <h3>{{row.item.product_name}}</h3>
                                            </td>
                                            <td>
                                                <v-edit-dialog :return-value.sync="row.item.product_price" @save="setPrice(row.item)" @cancel="" @open="" @close="">
                                                    {{row.item.product_price}}
                                                    <template v-slot:input>
                                                        <v-text-field v-model="row.item.product_price" single-line></v-text-field>
                                                    </template>
                                                </v-edit-dialog>
                                            </td>
                                            <td>
                                                <v-switch v-model="row.item.active" value="active" false-value="0" true-value="1" color="success" value="success" inset @click="setActive(row.item)"></v-switch>
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
                            <!-- End Table List Product -->

                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
            <!-- Modal -->
            <!-- Modal Save Product -->
            <template>
                <v-row justify="center">
                    <v-dialog v-model="modalAdd" fullscreen hide-overlay transition="dialog-bottom-transition">
                        <v-card>
                            <v-toolbar dark color="primary">
                                <v-btn icon dark @click="modalAddClose">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                                <v-toolbar-title>Tambah Produk</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-toolbar-items>
                                    <v-btn dark text @click="saveProduct" :loading="loading">
                                        <v-icon>mdi-content-save</v-icon> Simpan
                                    </v-btn>
                                </v-toolbar-items>
                            </v-toolbar>
                            <v-form ref="form" v-model="valid">
                                <v-card-text>
                                    <v-container :fluid="true">
                                        <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                                        <v-row>
                                            <v-col cols="12" md="2">
                                                <v-label>Nama Produk</v-label>
                                            </v-col>
                                            <v-col cols="12" md="10">
                                                <v-text-field label="Nama Produk *" v-model="productName" :rules="textRules" outlined dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="2">
                                                <v-label>Harga Produk</v-label>
                                            </v-col>
                                            <v-col cols="12" md="10">
                                                <v-text-field label="Harga *" v-model="productPrice" :rules="textRules" outlined dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="2">
                                                <v-label>Deskripsi Produk</v-label>
                                            </v-col>
                                            <v-col cols="12" md="10">
                                                <v-textarea v-model="productDescription" counter maxlength="3000" outlined full-width single-line></v-textarea>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="2">
                                                <v-label>Gambar Produk</v-label>
                                            </v-col>
                                            <v-col cols="12" md="10">
                                                <v-image-input v-model="productImage" :clearable="true" :hide-actions="true" :image-width="700" :image-height="700" image-format="jpg,jpeg,png" overlay-padding="50px" @input="" />
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                            </v-form>
                        </v-card>
                    </v-dialog>
                </v-row>
            </template>     
            <!-- End Modal Save Product -->
                              
            <!-- Modal Edit Product -->
            <template>
                <v-row justify="center">
                    <v-dialog v-model="modalEdit" persistent fullscreen hide-overlay transition="dialog-bottom-transition">
                        <v-card>
                            <v-toolbar dark color="primary">
                                <v-btn icon dark @click="modalEditClose">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                                <v-toolbar-title>Ubah Produk</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-toolbar-items>
                                    <v-btn dark text @click="updateProduct" :loading="loading">
                                        <v-icon>mdi-content-save</v-icon> Simpan
                                    </v-btn>
                                </v-toolbar-items>
                            </v-toolbar>
                            <v-form ref="form" v-model="valid">
                                <v-card-text>
                                    <v-container :fluid="true">
                                        <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field label="Nama Produk *" v-model="productNameEdit" :rules="textRules" required></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field label="Harga *" v-model="productPriceEdit" :rules="textRules" required>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <label>Gambar Produk</label><br />
                                                <template v-if="show == false">
                                                    <v-hover>
                                                        <template v-slot:default="{ hover }">
                                                            <v-card max-width="250">
                                                                <v-img :src="mediaPathEdit"></v-img>

                                                                <v-fade-transition>
                                                                    <v-overlay v-if="hover" absolute color="#036358">
                                                                        <v-btn color="red" dark @click="deleteMedia(productImageEdit)" :loading="loading">
                                                                            <v-icon left>
                                                                                mdi-delete
                                                                            </v-icon> Hapus
                                                                        </v-btn>
                                                                    </v-overlay>
                                                                </v-fade-transition>
                                                            </v-card>
                                                        </template>
                                                    </v-hover>
                                                </template>
                                                <v-image-input v-if="show" v-model="productImage" :clearable="true" :hide-actions="true" :image-width="700" :image-height="700" :full-height="true" :full-width="true" image-format="jpg,jpeg,png" overlay-padding="25px" @input="onFileInfo" />
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
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
                        <v-card class="pa-2">
                            <v-card-title class="text-h5">Anda yakin ingin menghapus produk ini?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="modalDelete = false">Tidak</v-btn>
                                 <v-btn color="blue darken-1" dark @click="deleteProduct" :loading="loading">Ya</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </template>              
            <!-- End Modal Delete Product -->

            <v-snackbar v-model="snackbar" :color="snackbarType" :timeout="timeout">
                <span v-if="snackbar">{{snackbarMessage}}</span>
                <template v-slot:action="{ attrs }">
                    <v-btn text v-bind="attrs" @click="snackbar = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </v-snackbar>   
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
        var computedVue = {
            mini() {
                return (this.$vuetify.breakpoint.smAndDown) || !this.toggleMini
            },
            buttonText() {
                return !this.$vuetify.theme.dark ? 'Go Dark' : 'Go Light'
            }
        }
        var dataVue = {
            sidebarMenu: true,
            toggleMini: false,
            group: null,
            search: '',
            headers: [{
                    text: 'ID',
                    value: 'product_id'
                },
                {
                    text: 'FOTO',
                    value: 'media_path'
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
            productDescription: '',
            productImage: null,
            active: '',
            mediaPath: null,
            modalEdit: false,
            productIdEdit: '',
            productNameEdit: '',
            productPriceEdit: '',
            productImageEdit: '',
            mediaPathEdit: null,
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
            show: false,
        }
        var createdVue = function() {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            this.getProducts();
        }
        var mountedVue = function() {}
        var watchVue = {}
        var methodsVue = {
            toggleTheme() {
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            },
            modalAddOpen: function() {
                this.modalAdd = true;
                this.productImage = null;
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
                this.productDescription = '';
                this.productImage = null;
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
            onFileInfo(value) {
                this.fileInfo = value;
                this.uploadMedia(value);
            },
            uploadMedia: function(file) {
                var formData = new FormData()
                // Split the base64 string in data and contentType
                var block = file.split(";");
                // Get the content type of the image
                var contentType = block[0].split(":")[1]; // In this case "image/gif"
                // get the real base64 content of the file
                var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

                // Convert it to a blob to upload
                var blob = b64toBlob(realData, contentType);
                formData.append('productImage', blob);
                axios({
                        method: 'post',
                        url: '/media/save',
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
                            this.snackbar = true;
                            this.snackbarType = "success";
                            this.snackbarMessage = data.message;
                            this.productImage = data.data
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
            // Delete Product
            deleteMedia: function() {
                this.loading = true;
                axios.delete(`media/delete/${this.productImageEdit}`)
                    .then(res => {
                        // handle success
                        this.loading = false
                        var data = res.data;
                        if (data.status == true) {
                            this.snackbar = true;
                            this.snackbarType = "success";
                            this.snackbarMessage = data.message;
                            this.show = true;
                        } else {
                            this.notifType = "error";
                            this.notifMessage = data.message;
                        }
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                        this.loading = false;
                        this.show = false;
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
                            product_description: this.productDescription,
                            product_image: this.productImage,
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
                            this.productDescription = '';
                            this.productImage = null;
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
                this.show = false;
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
                this.productImageEdit = product.product_image;
                this.mediaPathEdit = product.media_path;
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
                        product_price: this.productPriceEdit,
                        product_image: this.productImage
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
                            this.productImage = null;
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

            // Set Item Product Price
            setPrice: function(product) {
                this.loading = true;
                this.productIdEdit = product.product_id;
                this.productPrice = product.product_price;
                axios.put(`product/setprice/${this.productIdEdit}`, {
                        product_price: this.productPrice,
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

            // Set Item Active Product
            setActive: function(product) {
                this.loading = true;
                this.productIdEdit = product.product_id;
                this.active = product.active;
                axios.put(`product/setactive/${this.productIdEdit}`, {
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
            computed: computedVue,
            data: dataVue,
            mounted: mountedVue,
            created: createdVue,
            watch: watchVue,
            methods: methodsVue
        })
    </script>
</body>

</html>