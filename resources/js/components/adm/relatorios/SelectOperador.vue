<template>
  <div>
    <multiselect
      v-model="valor"
      placeholder="Selecione um ou Mais"
      label="name"
      track-by="id"
      :options="tipos"
      :multiple="true"
      :taggable="true"
      @tag="addTag"
      selectLabel="Pressione Enter Para Selecionar"
      deselectLabel="Pressione Enter Para Remover"
      required
    ></multiselect>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tipos: [],
      valor: []
    };
  },

  mounted() {
    this.getTipoUsuarios();
  },

  watch: {
    valor: function() {
      this.$emit("operadores", this.valor);
    }
  },

  methods: {
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
      };
      this.options.push(tag);
      this.valor.push(tag);
    },

    getTipoUsuarios() {
      axios
        .get("/api/get-usuarios-relatorios")
        .then(response => {
          this.tipos = response.data;
        })
        .catch(e => {});
    }
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
