<template>
    <div class="container-fluid" id="Product">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group rounded" style="width: 55%">
                    <input
                        type="search"
                        class="form-control rounded"
                        placeholder="Search"
                        aria-label="Search"
                        aria-describedby="search-addon"
                        v-model="searchKeyword"
                        @input="searchProducts"
                    />
                    <span
                        class="input-group-text bg-dark text-light"
                        id="search-addon"
                    >
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <button
                        class="btn btn-outline-info me-2"
                        data-mdb-ripple-init
                        data-mdb-ripple-color="dark"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                        data-bs-whatever="@mdo"
                    >
                        Create Products
                    </button>
                    <button
                        class="btn btn-outline-success"
                        data-mdb-ripple-init
                        data-mdb-ripple-color="dark"
                        @click="exportProducts"
                    >
                        Export Data
                    </button>
                </div>
                <!-- Modal -->

                <form @submit.prevent="submitForm">
                    <div
                        class="modal fade"
                        id="exampleModal"
                        tabindex="-1"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
                        >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Create Product Form
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label"
                                                >Name</label
                                            >
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="name"
                                                v-model="product.name"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                for="import_price"
                                                class="form-label"
                                                >Import Price</label
                                            >
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="import_price"
                                                v-model="product.import_price"
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                for="sell_price"
                                                class="form-label"
                                                >Sell Price</label
                                            >
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="sell_price"
                                                v-model="product.sell_price"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                for="category_id"
                                                class="form-label"
                                                >Category</label
                                            >
                                            <select
                                                class="form-select"
                                                aria-label="Select Category"
                                                v-model="product.category_id"
                                            >
                                                <option disabled value="">
                                                    Select Category
                                                </option>
                                                <option
                                                    v-for="category in categories"
                                                    :key="category.id"
                                                    :value="category.id"
                                                >
                                                    {{ category.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                for="gender_id"
                                                class="form-label"
                                                >Gender</label
                                            >
                                            <select
                                                class="form-select"
                                                aria-label="Select Gender"
                                                v-model="product.gender_id"
                                            >
                                                <option disabled value="">
                                                    Select Gender
                                                </option>
                                                <option
                                                    v-for="gender in genders"
                                                    :key="gender.id"
                                                    :value="gender.id"
                                                >
                                                    {{ gender.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                for="brand_id"
                                                class="form-label"
                                                >Brand</label
                                            >
                                            <select
                                                class="form-select"
                                                aria-label="Select Brand"
                                                v-model="product.brand_id"
                                            >
                                                <option disabled value="">
                                                    Select Brand
                                                </option>
                                                <option
                                                    v-for="brand in brands"
                                                    :key="brand.id"
                                                    :value="brand.id"
                                                >
                                                    {{ brand.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label
                                                for="detail"
                                                class="form-label"
                                                >Detail</label
                                            >
                                            <textarea
                                                class="form-control"
                                                id="detail"
                                                v-model="product.detail"
                                                rows="5"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="file" class="form-label"
                                                >Upload Images</label
                                            >
                                            <input
                                                type="file"
                                                class="form-control"
                                                ref="fileInput"
                                                multiple
                                                @change="onFileChange"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="row mb-3"
                                        v-if="uploadedImages.length"
                                    >
                                        <div
                                            class="col-md-3"
                                            v-for="(
                                                image, index
                                            ) in uploadedImages"
                                            :key="index"
                                        >
                                            <img
                                                :src="image"
                                                class="img-fluid"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        @click="showCreateToast"
                                    >
                                        Add Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form @submit.prevent="updateProduct">
                    <div
                        class="modal fade"
                        id="updateModal"
                        tabindex="-1"
                        aria-labelledby="updateModalLabel"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
                        >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="updateModalLabel"
                                    >
                                        Update Product
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                for="updateName"
                                                class="form-label"
                                                >Name</label
                                            >
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="updateName"
                                                v-model="editedProduct.name"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                for="updateImportPrice"
                                                class="form-label"
                                                >Import Price</label
                                            >
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="updateImportPrice"
                                                v-model="
                                                    editedProduct.import_price
                                                "
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                for="updateSellPrice"
                                                class="form-label"
                                                >Sell Price</label
                                            >
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="updateSellPrice"
                                                v-model="
                                                    editedProduct.sell_price
                                                "
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                for="updateCategoryId"
                                                class="form-label"
                                                >Category</label
                                            >
                                            <select
                                                class="form-select"
                                                aria-label="Select Category"
                                                v-model="
                                                    editedProduct.category_id
                                                "
                                            >
                                                <option disabled value="">
                                                    Select Category
                                                </option>
                                                <option
                                                    v-for="category in categories"
                                                    :key="category.id"
                                                    :value="category.id"
                                                >
                                                    {{ category.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                for="updateGenderId"
                                                class="form-label"
                                                >Gender</label
                                            >
                                            <select
                                                class="form-select"
                                                aria-label="Select Gender"
                                                v-model="
                                                    editedProduct.gender_id
                                                "
                                            >
                                                <option disabled value="">
                                                    Select Gender
                                                </option>
                                                <option
                                                    v-for="gender in genders"
                                                    :key="gender.id"
                                                    :value="gender.id"
                                                >
                                                    {{ gender.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                for="updateBrandId"
                                                class="form-label"
                                                >Brand</label
                                            >
                                            <select
                                                class="form-select"
                                                aria-label="Select Brand"
                                                v-model="editedProduct.brand_id"
                                            >
                                                <option disabled value="">
                                                    Select Brand
                                                </option>
                                                <option
                                                    v-for="brand in brands"
                                                    :key="brand.id"
                                                    :value="brand.id"
                                                >
                                                    {{ brand.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label
                                                for="updateDetail"
                                                class="form-label"
                                                >Detail</label
                                            >
                                            <textarea
                                                class="form-control"
                                                id="updateDetail"
                                                v-model="editedProduct.detail"
                                                rows="5"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                for="updateFile"
                                                class="form-label"
                                                >Upload Images</label
                                            >
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="updateFile"
                                                ref="fileInput"
                                                multiple
                                                @change="onUpdateImageChange"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="row mb-3"
                                        v-if="uploadedImages.length"
                                    >
                                        <div
                                            class="col-md-3"
                                            v-for="(
                                                image, index
                                            ) in uploadedImages"
                                            :key="index"
                                        >
                                            <img
                                                :src="image"
                                                class="img-fluid"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        data-bs-dismiss="modal"
                                        @click="showToast"
                                    >
                                        Update Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="liveToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Update Product Successfully
                        </div>
                    </div>
                </div>


                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="createToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Create Product Successfully
                        </div>
                    </div>
                </div>


                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="deleteToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Delete Product Successfully
                        </div>
                    </div>
                </div>

                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="exportToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Export Data Successfully
                        </div>
                    </div>
                </div>

                <div
                    class="modal fade"
                    id="uploadDescriptionImages"
                    tabindex="-1"
                    aria-labelledby="uploadDescriptionImagesLabel"
                    aria-hidden="true"
                >
                    <div
                        class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
                    >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="uploadDescriptionImagesLabel"
                                >
                                    Upload Descripion Images
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <input
                                        type="file"
                                        multiple
                                        @change="
                                            uploadDescriptionImages(
                                                selectedProductId,
                                                $event
                                            )
                                        "
                                    />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table border">
                <thead>
                    <tr>
                        <td></td>
                        <th
                            scope="col"
                            class="center-text text-uppercase"
                            @click="sortBy('product_code')"
                        >
                            Product Code
                            <span
                                class="arrow"
                                :class="
                                    sortOrders['product_code'] > 0
                                        ? 'asc'
                                        : 'dsc'
                                "
                            ></span>
                        </th>
                        <th
                            scope="col"
                            class="center-text text-uppercase"
                            @click="sortBy('name')"
                        >
                            Name
                            <span
                                class="arrow"
                                :class="sortOrders['name'] > 0 ? 'asc' : 'dsc'"
                            ></span>
                        </th>
                        <!-- <th scope="col" class="center-text  text-uppercase" @click="sortBy('category.name')">
                            Product Type
                            <span class="arrow" :class="sortOrders['category.name'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('import_price')">
                            Import Price
                            <span class="arrow" :class="sortOrders['import_price'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('sell_price')">
                            Sell Price
                            <span class="arrow" :class="sortOrders['sell_price'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('gender_id')">
                            Gender
                            <span class="arrow" :class="sortOrders['gender_id'] > 0 ? 'asc' : 'dsc'"></span>
                        </th> -->
                        <th
                            scope="col"
                            class="center-text text-uppercase"
                            @click="sortBy('brand.name')"
                        >
                            Brand
                            <span
                                class="arrow"
                                :class="
                                    sortOrders['brand.name'] > 0 ? 'asc' : 'dsc'
                                "
                            ></span>
                        </th>
                        <th scope="col" class="center-text text-uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="(product, index) in filteredProducts"
                        :key="product.id"
                    >
                        <tr
                            data-bs-toggle="collapse"
                            :data-bs-target="'#collapseorder-' + index"
                            aria-expanded="false"
                            aria-controls="collapseExample"
                            style=""
                        >
                            <td
                                style="text-align: center"
                                class="align-middle text-center"
                            >
                                <div
                                    class="image-container"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        overflow: hidden;
                                    "
                                >
                                    <img
                                        :src="'/storage/' + product.image"
                                        alt="Product Image"
                                        class="shadow-sm border-1"
                                        style="
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                        "
                                    />
                                </div>
                            </td>
                            <td class="center-text align-middle">
                                {{ product.product_code }}
                            </td>
                            <td class="center-text align-middle">
                                {{ product.name }}
                            </td>
                            <!-- <td class="center-text">{{ product.category.name }}</td>
                            <td class="center-text">{{ product.import_price }}</td>
                            <td class="center-text">{{ product.sell_price }}</td>
                            <td class="center-text">{{ genderLabel(product.gender_id) }}</td> -->
                            <td class="center-text align-middle">
                                {{ product.brand.name }}
                            </td>
                            <td class="center-text align-middle">
                                <span class="material-symbols-outlined me-2">
                                    <button
                                        @click="deleteProduct(product, index)"
                                        type="button"
                                        class="btn btn-danger m-0"
                                        data-mdb-ripple-init
                                    >
                                        delete_forever
                                    </button>
                                </span>
                                <span class="material-symbols-outlined me-2">
                                    <button
                                        type="button"
                                        class="btn btn-info m0"
                                        data-mdb-ripple-init
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateModal"
                                        data-bs-whatever="@mdo"
                                        @click="openUpdateModal(product)"
                                    >
                                        edit
                                    </button>
                                </span>

                                <span class="material-symbols-outlined me-2">
                                    <button
                                        type="button"
                                        class="btn btn-warning m0"
                                        data-mdb-ripple-init
                                        data-bs-toggle="modal"
                                        data-bs-target="#uploadDescriptionImages"
                                        @click="openUploadModal(product.id)"
                                        data-bs-whatever="@mdo"
                                    >
                                        image
                                    </button>
                                </span>

                                <!-- <input type="file" multiple @change="uploadDescriptionImages(product.id, $event)"> -->
                            </td>
                        </tr>
                        <td colspan="12">
                            <div
                                class="collapse"
                                :id="'collapseorder-' + index"
                            >
                                <div class="card card-body border rounded">
                                    <h5 class="text-center mb-4">
                                        Product Information
                                    </h5>
                                    <div class="d-flex">
                                        <div
                                            class="image-container me-6"
                                            style="
                                                width: 15%;
                                                height: 15%;
                                                overflow: hidden;
                                                margin-right: 20px;
                                            "
                                        >
                                            <img
                                                :src="
                                                    '/storage/' + product.image
                                                "
                                                alt="Product Image"
                                                class="shadow-sm border-radius-lg border border-1"
                                                style="
                                                    width: 100%;
                                                    height: 100%;
                                                    object-fit: cover;
                                                "
                                            />
                                        </div>
                                        <div
                                            class="product-info d-flex flex-wrap"
                                        >
                                            <div class="col me-6">
                                                <div class="mb-3">
                                                    <label
                                                        for="productCode"
                                                        class="form-label"
                                                        ><strong
                                                            >Product
                                                            Code:</strong
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="productCode"
                                                        v-model="
                                                            product.product_code
                                                        "
                                                        readonly
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        for="category"
                                                        class="form-label"
                                                        ><strong
                                                            >Category:</strong
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="category"
                                                        v-model="
                                                            product.category
                                                                .name
                                                        "
                                                        readonly
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        for="gender"
                                                        class="form-label"
                                                        ><strong
                                                            >Gender:</strong
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="gender"
                                                        v-model="
                                                            product.gender.name
                                                        "
                                                        readonly
                                                    />
                                                </div>
                                            </div>
                                            <div class="col me-6">
                                                <div class="mb-3">
                                                    <label
                                                        for="importPrice"
                                                        class="form-label"
                                                        ><strong
                                                            >Import
                                                            Price:</strong
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="importPrice"
                                                        v-model="
                                                            product.import_price
                                                        "
                                                        readonly
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        for="sellPrice"
                                                        class="form-label"
                                                        ><strong
                                                            >Sell Price:</strong
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="sellPrice"
                                                        v-model="
                                                            product.sell_price
                                                        "
                                                        readonly
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        for="brand"
                                                        class="form-label"
                                                        ><strong
                                                            >Brand:</strong
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="brand"
                                                        v-model="
                                                            product.brand.name
                                                        "
                                                        readonly
                                                    />
                                                </div>
                                            </div>
                                            <div class="col me-6">
                                                <label
                                                    for="brand"
                                                    class="form-label"
                                                    ><strong
                                                        >Detail:</strong
                                                    ></label
                                                >
                                                <textarea
                                                    class="form-control"
                                                    id="brand"
                                                    v-model="product.detail"
                                                    readonly
                                                    rows="9"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </template>
                </tbody>
            </table>
            <div v-if="showPagination">
                <ul
                    class="pagination justify-content-end"
                    style="font-size: 80%"
                >
                    <li :class="{ disabled: currentPage === 1 }">
                        <a class="page-link" href="#" @click.prevent="prevPage"
                            >Previous</a
                        >
                    </li>
                    <li
                        v-for="page in totalPages"
                        :key="page"
                        :class="{ active: currentPage === page }"
                    >
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="goToPage(page)"
                            >{{ page }}</a
                        >
                    </li>
                    <li :class="{ disabled: currentPage === totalPages }">
                        <a class="page-link" href="#" @click.prevent="nextPage"
                            >Next</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Product",
    data() {
        return {
            user_permissions: {},
            products: [],
            product: {
                id: "",
                name: "",
                product_type: "",
                import_price: "",
                sell_price: "",
                gender_id: "",
                detail: "",
                brand_id: "",
                category_id: "",
                image: "",
            },

            editedProduct: {
                id: "",
                name: "",
                import_price: "",
                sell_price: "",
                gender_id: "",
                detail: "",
                brand_id: "",
                category_id: "",
                image: "",
            },

            isNewProduct: true,
            imageUrl: null,

            sortKey: "", // Cột hiện tại được sắp xếp
            sortOrders: {}, // Hướng sắp xếp của các cột

            brands: [],
            genders: [],
            categories: [],
            searchKeyword: "",
            addPermission: true,
            listView: true,
            currentPage: 1, // Trang hiện tại
            pageSize: 15, // Số lượng nhân viên trên mỗi trang
            error: {
                message: "",
            },
            roleId: "",
            selectedProductId: null,
            uploadedImages: [],
        };
    },
    created() {
        // const savedPage = localStorage.getItem("currentPage");
        // if (savedPage) {
        //     this.currentPage = parseInt(savedPage, 10);
        // }
        this.getProducts();
        this.getBrands();
        this.getGenders();
        this.getCategories();

        this.blockAddPermission();
        this.roleId = localStorage.getItem("role_id");
    },
    methods: {
        showToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("liveToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        showCreateToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("createToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        showDeleteToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("deleteToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        showExportToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("exportToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },
        openUploadModal(productId) {
            this.selectedProductId = productId;
            // Mở modal (nếu cần)
        },



        async uploadDescriptionImages(productId, event) {
            try {
                // Tạo FormData để chứa các tệp hình ảnh và product_id
                const formData = new FormData();
                const files = event.target.files;

                // Thêm các tệp hình ảnh vào FormData
                for (let i = 0; i < files.length; i++) {
                    formData.append("images[]", files[i]);
                }

                // Thêm product_id vào FormData
                formData.append("product_id", productId);

                // Gửi yêu cầu POST đến API '/upload-description-image' với FormData
                const response = await axios.post(
                    "/api/upload-description-image",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                // Xử lý phản hồi từ server
                // console.log('Description images uploaded successfully:', response.data);
                alert("Description images uploaded successfully!");
                window.location.href = "/productList";

                // Làm mới sản phẩm để cập nhật danh sách các hình ảnh (nếu cần)
                await this.getProducts();
            } catch (error) {
                // Xử lý lỗi nếu có
                // console.error('Failed to upload description images:', error);
                alert(
                    "Failed to upload description images. Please try again later."
                );
            }
        },

        onUpdateImageChange(event) {
            // Lấy file ảnh từ sự kiện change
            const file = event.target.files[0];
            // Kiểm tra nếu có file ảnh được chọn
            if (file) {
                // Cập nhật ảnh trong biến editedProduct
                this.editedProduct.image = file;
            }
        },
        openUpdateModal(product) {
            this.editedProduct = {
                id: product.id,
                name: product.name,
                import_price: product.import_price,
                sell_price: product.sell_price,
                gender_id: product.gender_id,
                detail: product.detail,

                brand_id: product.brand_id,
                category_id: product.category_id,
                image: product.image,
            };
            $("#updateModal").modal("show");
        },
        getProducts() {
            axios
                .get("api/products")
                .then((response) => {
                    this.products = response.data;
                    console.log(this.products);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async updateProduct() {
            try {
                await axios
                    .put(
                        `/api/products/${this.editedProduct.id}`,
                        this.editedProduct
                    )
                    .then((response) => {
                        this.getProducts();
                        $("#updateModal").modal("hide");
                    });
            } catch (error) {
                console.error(error);
            }
        },

        sortBy(key) {
            if (this.sortKey === key) {
                this.sortOrders[key] = this.sortOrders[key] * -1;
            } else {
                this.sortKey = key;
                this.sortOrders[key] = 1;
            }

            this.filteredProducts.sort((a, b) => {
                let modifier = this.sortOrders[key];
                if (a[key] < b[key]) return -1 * modifier;
                if (a[key] > b[key]) return 1 * modifier;
                return 0;
            });
        },
        onFileChange(event) {
            const files = event.target.files;
            this.uploadedImages = [];
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.uploadedImages.push(e.target.result);
                };
                reader.readAsDataURL(files[i]);
            }
            this.product.image = files[0]; // You can still keep this line if you want to store the first file in product.image
        },
        async submitForm() {
            try {
                const formData = new FormData();
                formData.append("image", this.product.image);
                formData.append("name", this.product.name);
                formData.append("import_price", this.product.import_price);
                formData.append("sell_price", this.product.sell_price);
                formData.append("detail", this.product.detail);

                formData.append("gender_id", this.product.gender_id);
                formData.append("brand_id", this.product.brand_id);
                formData.append("category_id", this.product.category_id);

                await axios
                    .post("/api/products", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        this.getProducts(); // Cập nhật danh sách sản phẩm
                        this.hideModal();
                        this.showToast(); // Hiển thị toast message
                    });
            } catch (error) {
                console.error(error);
            }
        },

        hideModal() {
            const modalEl = document.getElementById("exampleModal");
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        },

        genderLabel(genderCode) {
            if (genderCode == 1) {
                return "Male";
            } else {
                return "Female";
            }
        },

        getGenders() {
            axios
                .get("api/genders")
                .then((response) => {
                    this.genders = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getBrands() {
            axios
                .get("api/brands")
                .then((response) => {
                    this.brands = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getCategories() {
            axios
                .get("api/categories")
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        deleteProduct(product, index) {
            axios
                .delete("api/products/" + product.id)
                .then((response) => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message;

                        setTimeout(() => {
                            this.error.message = "";
                        }, 3000);
                    } else {
                        this.products.splice(index, 1);
                        this.getProducts();
                        this.showDeleteToast(); // Hiển thị toast message
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        goToPage(page) {
            this.currentPage = page;
            localStorage.setItem("currentPage", page);
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        searchProducts() {
            const keyword = this.searchKeyword.toLowerCase();
            this.filteredProducts = this.products.filter((product) => {
                // if ((keyword === 'male' && product.gender_id == 1) || (keyword === 'female' && product.gender_id == 2)) {
                //     return true;
                // }

                return (
                    product.name.toLowerCase().includes(keyword) ||
                    product.category.name.toLowerCase().includes(keyword) ||
                    product.brand.name.toLowerCase().includes(keyword) ||
                    product.product_code.toLowerCase().includes(keyword) ||
                    product.import_price.includes(keyword) ||
                    product.sell_price.toLowerCase().includes(keyword)
                    // product.gender_id.toLowerCase().includes(keyword)
                );
            });
        },
        toggleListView() {
            this.listView = !this.listView;
        },
        blockAddPermission() {
            let user_permissions = JSON.parse(
                localStorage.getItem("permission_id")
            );

            for (let i = 0; i < user_permissions.length; i++) {
                if (user_permissions[i].id == 5) {
                    this.addPermission = true;
                    return this.addPermission;
                }
            }
            return (this.addPermission = false);
        },

        exportProducts() {
            axios
                .get("/api/products_export", { responseType: "arraybuffer" })
                .then((response) => {
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement("a");
                    fileLink.href = fileURL;
                    fileLink.setAttribute("download", "products.xlsx");
                    document.body.appendChild(fileLink);
                    fileLink.click();
                    this.showExportToast();
                })
                .catch((error) => {
                    console.error("Export failed:", error);
                    alert("Failed to export data. Please try again later.");
                });
        },
    },
    computed: {
        filteredProducts() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            const keyword = this.searchKeyword.toLowerCase();
            const filteredProducts = this.products.filter((product) => {
                if (
                    (keyword === "male" && product.gender_id == 1) ||
                    (keyword === "female" && product.gender_id == 2)
                ) {
                    return true;
                }
                return (
                    product.name.toLowerCase().includes(keyword) ||
                    product.category.name.toLowerCase().includes(keyword) ||
                    product.brand.name.toLowerCase().includes(keyword) ||
                    product.product_code.toLowerCase().includes(keyword) ||
                    product.import_price.includes(keyword) ||
                    product.sell_price.toLowerCase().includes(keyword)
                    // product.gender_id.toLowerCase().includes(keyword)
                );
            });
            return filteredProducts.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.products.length / this.pageSize);
        },
        showPagination() {
            if (this.filteredProducts.length >= 4 || this.nextPage > 1) {
                return true;
            } else if (this.filteredProducts.length < 5 && this.nextPage == 1) {
                return false;
            }
            return true;
        },
    },
    // async mounted() {
    //     this.imageUrl = response.data.image;
    // },
};
</script>

<style lang="scss" scoped>
.error {
    margin-bottom: 15px;
}

.center-text {
    text-align: center;
}

.table-bordered td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: center;
}

.image-container:hover img {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}

.pagination li a,
.pagination li span {
    border-radius: 20px;
    padding: 8px 16px;
}

/* CSS cho hình mũi tên chỉ ra hướng sắp xếp */
.arrow {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 0.25em;
    vertical-align: middle;
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: none;
    border-left: 0.3em solid transparent;
}

.asc {
    border-top: none;
    border-bottom: 0.3em solid;
}

.dsc {
    border-top: 0.3em solid;
    border-bottom: none;
}
.lh70 {
    line-height: 70px;
}
.m0 {
    margin: 0;
}
</style>
