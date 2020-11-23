<template>
  <div>
    <div class="row d-flex justify-content-center">
      <div class="col-5 ">
        <multiselect
          v-model="value"
          :options="clientes"
          :custom-label="nameWithLang"
          placeholder="Selecione um cliente"
          label="nome"
          track-by="nome"
          selectLabel="Pressione enter para selecionar"
        ></multiselect>
      </div>

      <div class="col-2">
        <button
          type="button"
          class="btn btn-danger"
          v-on:click="bloquearCliente(value)"
        >
          Bloquear
        </button>
      </div>
    </div>
    <div class="table-responsive mt-2">
      <table class="table ">
        <thead class="thead-light">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Razão Social</th>
            <th scope="col">CNPJ</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cliente in clienteBloqueados" :key="cliente.id_cliente">
            <td class="align-middle">{{ cliente.id_cliente }}</td>
            <td class="align-middle">{{ cliente.nome }}</td>
            <td class="align-middle">{{ cliente.cnpj }}</td>

            <td>
              <button
                type="button"
                class="btn btn-primary"
                v-on:click="desbloqueaCliente(cliente.id_cliente)"
              >
                <i class="fa fa-trash-o" aria-hidden="true"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="row card-footer">
      <jw-pagination
        :items="filteredClientes"
        @changePage="onChangePage"
        :labels="customLabels"
        :pageSize="10"
        :maxPages="18"
      ></jw-pagination>
    </div>
  </div>
</template>
<script>
const customLabels = {
  first: "Primeira",
  last: "Última",
  previous: "Anterior",
  next: "Próxima"
};
export default {
  data() {
    return {
      pageOfItems: [],
      searchText: "",
      customLabels,
      clientes: [],
      clienteBloqueados: [],
      value: null
    };
  },

  mounted() {
    this.getClientes();
    this.getClientesBloqueados();
  },

  computed: {
    filteredClientes() {
      return this.clienteBloqueados.filter(cliente => {
        let textoValid = true;

        if (this.searchText) {
          let searchText = this.searchText.toLowerCase();
          textoValid =
            cliente.nome.toLowerCase().includes(searchText) ||
            cliente.cnpj.toLowerCase().includes(searchText);
        }
        return textoValid;
      });
    }
  },

  methods: {
    getClientes() {
      axios
        .get("get-todos-clientes")
        .then(response => {
          this.clientes = response.data;
        })
        .catch(e => {});
    },

    nameWithLang({ nome, cnpj }) {
      return `${nome} — ${cnpj}`;
    },

    getClientesBloqueados() {
      this.$vs.loading();
      axios
        .get("get-clientes-bloqueados")
        .then(response => {
          this.clienteBloqueados = response.data;
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    },

    bloquearCliente(dados) {
      if (dados === null) {
        this.$vs.notify({
          title: "Falha!!!",
          text: "Escolha um cliente",
          color: "danger",
          position: "top-center"
        });
        this.$vs.loading.close();
      } else {
        this.$vs.loading();
        axios
          .post("bloquear-cliente", dados)
          .then(res => {
            setTimeout(() => {
              window.location.reload(1);
            }, 1500);
          })
          .catch(e => {
            this.$vs.notify({
              title: "Falha!!!",
              text: "Cliente já bloqueado",
              color: "danger",
              position: "top-center"
            });
            this.$vs.loading.close();
          });
      }
    },
    desbloqueaCliente(id) {
      axios
        .put("desbloquear-cliente/" + id)
        .then(res => {
          setTimeout(() => {
            window.location.reload(1);
          }, 2000);
          this.$vs.notify({
            title: "success!!!",
            text: " Desbloqueado Cliente",
            color: "success",
            position: "top-center"
          });
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    },

    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
    }
  }
};
</script>

<style media="screen">
.link {
  text-decoration: none;
  color: #212529;
}
</style>