<template>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" v-bind:href="url">
        <img v-bind:src="logo" width="200" height="50" class="d-inline-block align-top" />
      </a>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <span class="navbar-text">
          <label>
            <i class="fa fa-smile-o fa-2x" aria-hidden="true"></i>
          </label>
          <label class="ml-1">
            <b>
              Olá,
              <br />
              {{usuario}}
            </b>
            <span class="sr-only">(current)</span>
          </label>
        </span>
        <span class="navbar-text ml-4">
          <slot></slot>
        </span>
      </div>
    </div>
  </nav>
  
</template>

<script>
export default {
  props: ["logo", "url", "usuario"]
};
</script>

<style scoped>
nav {
  background-color: #0087cb;
}

.navbar-dark .navbar-text {
  color: white;
}
</style>
