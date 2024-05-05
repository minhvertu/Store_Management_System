<template>
    <main>
      <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <!-- Page title -->
                <div class="my-5">
                    <h3>My Profile</h3>
                    <hr>
                </div>
                <!-- Form START -->
                <form @submit.prevent="submitForm">
                    <div class="row mb-5 gx-5">
                        <!-- Contact detail -->
                        <div class="col-xxl-8 mb-5 mb-xxl-0">
                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                <div class="row g-3">
                                    <h4 class="mb-4 mt-0">Profile</h4>
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">First Name *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="First name" value="" v-model="users.name">
                                    </div>
                                    <!-- Last name -->
                                    <div class="col-md-6">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Last name" value="" v-model="users.address">
                                    </div>
                                    <!-- Phone number -->
                                    <div class="col-md-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Phone number" value="" v-model="users.birth_day">
                                    </div>

                                    <!-- Mobile number -->
                                    <div class="col-md-6">
                                        <label class="form-label">Phone number *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Phone number" value="" v-model="users.phone_number">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="inputEmail4" value="" v-model="users.email">
                                    </div>
                                    <!-- Skype -->
                                    <div class="col-md-6">
                                        <label class="form-label">Employee Code</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Phone number" value=""  v-model="users.employee_code">
                                    </div>
                                </div> <!-- Row END -->
                            </div>
                        </div>
                        <!-- Upload profile -->
                        <div class="col-xxl-4">
                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                <div class="row g-3">
                                    <h4 class="mb-4 mt-0">Upload your profile photo</h4>
                                    <div class="text-center">
                                        <!-- Image upload -->
                                        <div class="square position-relative display-2 mb-3 image-frame">
    <img :src="'storage/' + imageUrl"  class="shadow-sm w-100 border-radius-lg"
         style="object-fit: cover;" />
</div>
                                        <!-- Button -->
                                        <button type="button" class=" p-0 position-relative" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">

                                        <label class="btn btn-success me-2" >Upload</label>
                                        </button>
                                        <button type="button" class="btn btn-danger">Remove</button>
                                        <!-- Content -->
                                        <p class="text-muted mt-3 mb-0"><span class="me-1">Note:</span>Minimum size 300px x 300px</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row END -->

                    <!-- Social media detail -->

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                          Uploading a new photo</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"
                          aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p class="body-desc">
                          It will be easier for your friends to recognize you if you upload your real photo. You can
                          upload the image in JPG, GIF or PNG format. </p>
                        <div class="photo-input"> <input type="file" ref="fileInput" @change="uploadImage"
                            id="loadFile">
                          <button class="btn btn-sm btn-primary" @click.prevent="openFileInput">Select a file</button>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-center">
                        <p class="footer-title">
                          If you're having problems uploading, try choosing a smaller photo.</p>
                      </div>
                    </div>
                  </div>
                </div>

                    <!-- button -->
                    <div class="gap-3 d-md-flex justify-content-md-end text-center">
                        <button type="submit" class="btn btn-primary btn-lg" >Update profile</button>
                    </div>
                </form> <!-- Form END -->
            </div>
        </div>
    </div>

    </main>
  </template>


  <script>
  import axios from 'axios';
  import ArgonInput from "../Profile/ArgonInput.vue";
  import ArgonButton from "../Profile/ArgonButton.vue";
  import ProfileCard from "../Profile/ProfileCard.vue";
  import setNavPills from "../../assets/js/nav-pills";

  const body = document.getElementsByTagName("body")[0];

  export default {
    name: "Profile",
    data() {
      return {
        users: [],
        imageUrl: null
      };
    },
    components: { ProfileCard, ArgonInput, ArgonButton },

    methods: {
      openFileInput() {
        document.getElementById('loadFile').click();
      },
      async submitForm() {
        const id = localStorage.getItem('id');
        try {
          console.log(this.users);
          await axios.put(`/api/editProfile/${id}`, this.users);
          alert('Update Successfully');
        } catch (error) {
          console.error(error);
        }
      },
      uploadImage() {
        const formData = new FormData();
        formData.append('image', this.$refs.fileInput.files[0]);

        axios.post('/api/upload-image', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
          .then(response => {
            const imagePath = response.data.image_path;
            this.imageUrl = response.data.image_url;
            console.log('Image uploaded successfully:', imagePath);
            alert('Update Successfully');
            window.location.href = '/profile';

            // Hiển thị hình ảnh trên giao diện người dùng
            this.imagePath = imageUrl; // Giả sử imageUrl là biến trong data của Vue component
          })
          .catch(error => {
            console.error('Error uploading image:', error);
          });
      }
    },
    mounted() {
      this.$store.state.isAbsolute = true;
      setNavPills();

    },
    beforeMount() {
      this.$store.state.imageLayout = "profile-overview";
      this.$store.state.showNavbar = true;
      this.$store.state.showFooter = true;
      this.$store.state.hideConfigButton = true;
      body.classList.add("profile-overview");
    },
    beforeUnmount() {
      this.$store.state.isAbsolute = false;
      this.$store.state.imageLayout = "default";
      this.$store.state.showNavbar = true;
      this.$store.state.showFooter = true;
      this.$store.state.hideConfigButton = false;
      body.classList.remove("profile-overview");
    },
    async mounted() {
      try {
        const id = localStorage.getItem('id');
        console.log(id);

        const response = await axios.get(`/api/profile/${id}`);
        this.users = response.data;
        this.imageUrl = response.data.image;
        console.log(response.data)
      } catch (error) {
        console.error(error);
      }
    }
  }
  </script>

  <style>
  body {
    background-color: #eee
  }

  .height-100 {
    height: 100vh
  }

  .modal-header>.modal-title {
    font-size: 14px
  }

  .modal-body>.body-desc {
    font-size: 14px
  }

  .modal-footer>.footer-title {
    font-size: 12px
  }

  #loadFile {
    display: none
  }

  .modal-header>.modal-title,
  .modal-body>.body-desc,
  .modal-body>.photo-input,
  .modal-footer>.footer-title {
    text-align: center
  }

  body{margin-top:20px;
        color: #9b9ca1;
        }
        .bg-secondary-soft {
            background-color: rgba(208, 212, 217, 0.1) !important;
        }
        .rounded {
            border-radius: 5px !important;
        }
        .py-5 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }
        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }
        .file-upload .square {
            height: 250px;
            width: 250px;
            margin: auto;
            vertical-align: middle;
            border: 1px solid #e5dfe4;
            background-color: #fff;
            border-radius: 5px;
        }
        .text-secondary {
            --bs-text-opacity: 1;
            color: rgba(208, 212, 217, 0.5) !important;
        }
        .btn-success-soft {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }
        .btn-danger-soft {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }
        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.6;
            color: #29292e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e5dfe4;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 5px;
            -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        }
        .image-frame {
    border: 4px solid #6c757d; /* Thêm viền màu xám đậm */
    border-radius: 10px; /* Làm cho góc cạnh hơi tròn */
    padding: 4px; /* Thêm khoảng trống giữa ảnh và viền */
    background-color: #f8f9fa; /* Màu nền của khung ảnh */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng nhẹ */
}

  </style>
