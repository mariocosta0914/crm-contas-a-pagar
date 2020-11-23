<template>
  <div v-bind:class="defineSombra(sombra)">
    <div class="card-body">
      <slot></slot>
    </div>
  </div>
</template>
<script>
export default {
  props: ["sombra"],
  methods: {
    defineSombra: function(valor) {
      if (valor==="true") {
        return "card sombra link";
      } else {
        return "card link";
      }
    }
  }
};
</script>
<style scope>
.link {
  text-decoration: none;
  color: #212529;
}
.sombra {
  -webkit-box-shadow: 4px 1px 11px rgba(50, 50, 50, 0.77) !important;
  -moz-box-shadow: 4px 1px 11px rgba(50, 50, 50, 0.77) !important;
  box-shadow: 4px 1px 11px rgba(50, 50, 50, 0.77) !important;
}

a:link {
  text-decoration: none;
}
</style>