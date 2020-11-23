<template>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" v-bind:href="url">
        <img v-bind:src="logo" width="200" height="50" class="d-inline-block align-top" />
      </a>
    </div>
  </nav>
</template>

<script>
export default {
  props: ["logo", "url"]
};
</script>

<style scoped>
nav {
  background-color: #0087cb;
}
</style>
