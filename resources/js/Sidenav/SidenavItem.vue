<template>
    <router-link :to="url" class="nav-link" active-class="active" v-bind="$attrs">
      <div
        class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center"
      >
        <slot name="icon"></slot>
      </div>
      <span
        class="nav-link-text"
        :class="this.$store.state.isRTL ? 'me-1' : 'ms-1'"
      >
        {{ navText }}
      </span>
    </router-link>
  </template>

  <script>
  export default {
    name: "SidenavItem",
    props: {
      url: {
        type: String,
        required: true
      },
      navText: {
        type: String,
        required: true
      }
    }
  };
  </script>

  <style scoped>
  .nav-link.active {
    font-weight: bold;
  }
  </style>
