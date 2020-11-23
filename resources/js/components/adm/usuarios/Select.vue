<template>
  <div>
    <multiselect
      v-model="valor"
      placeholder="Selecione um ou Mais"
      label="tipo"
      track-by="id"
      :options="tipos"
      :multiple="true"
      :taggable="true"
      @tag="addTag"
      selectLabel="Pressione Enter Para Selecionar"
      deselectLabel="Pressione Enter Para Remover"
      required
    ></multiselect>
    <input type="hidden" name="tipos" v-bind:value="selectedTypes" />
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      tipos: [],
      valor: []
    };
  },

  mounted() {
    this.getTipoUsuarios();
    this.getTipoUsuarioById(this.id);
  },

  computed: {
    selectedTypes: function() {
      let selectedTypes = [];
      this.valor.forEach(item => {
        selectedTypes.push(item.id);
      });
      return selectedTypes;
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
        .get("/api/get-tipos-usuarios")
        .then(response => {
          this.tipos = response.data;
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    },

    getTipoUsuarioById(id) {
      this.$vs.loading();
      axios
        .get("/api/get-acesso-usuario/" + id)
        .then(response => {
          this.valor = response.data;
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    }
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>