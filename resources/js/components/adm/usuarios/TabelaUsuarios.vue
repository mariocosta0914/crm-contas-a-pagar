<template>
  <div class="table-responsive mt-3">
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th scope="col">Nome</th>
          <th scope="col">E-mail</th>
          <th scope="col">Tipo de Acesso</th>
          <th scope="col">Status</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="usuario in usuarios">
          <td>{{usuario.name}}</td>
          <td>{{usuario.email}}</td>
          <td>
            <span v-for="(acesso, index) in acessos">
              <label v-if="acesso.id_usuario==usuario.id">{{acesso.tipo}},</label>
            </span>
          </td>
          <td>{{usuario.status}}</td>
          <td>
            <a class="link" v-bind:href="url_editar_usuario +'/'+usuario.id">
              <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
            </a>
            <a class="link" v-bind:href="url_excluir_usuario +'/'+usuario.id">
              <i class="fa fa-trash-o fa-lg ml-2" aria-hidden="true"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["url_excluir_usuario", "url_editar_usuario"],
  data() {
    return {
      usuarios: {},
      acessos: {}
    };
  },
  mounted() {
    this.getUsuarios();
  },
  methods: {
    getUsuarios() {
      this.$vs.loading();
      axios
        .get("/api/get-usuarios")
        .then(response => {
          this.usuarios = response.data.dados_usuario;
          this.acessos = response.data.dados_acessso;
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    }
  }
};
</script>

<style scope>
.link {
  text-decoration: none;
  color: #212529;
}
</style>