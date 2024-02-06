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
  },
  beforeUnmount() {
    this.$store.state.showSidenav = true;
  },
};
</script>
