<template>
    <div>
        <h1>Not Found Page</h1>
    </div>
    <p>
        <router-link to ='/'> Ve Voi Anh Di</router-link>
    </p>
</template>

<script>
export default {
    created() {
    this.$store.state.showSidenav = false;
    this.$store.state.showNavbar = false;
    this.$store.state.showFooter = false;
  },
  beforeUnmount() {
    this.$store.state.showSidenav = true;
    this.$store.state.showNavbar = true;
    this.$store.state.showFooter = true;
  },
};
</script>
