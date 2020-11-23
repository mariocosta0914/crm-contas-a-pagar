<template>
  <div>
    <h4>
      <strong>Títulos</strong>
    </h4>
    <hr />
    <div class="table-responsive">
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col" class="align-middle">
              <label class="form-checkbox">
                <input type="checkbox" v-model="selectAll" @click="select" />
                <i class="form-icon"></i>
              </label>
            </th>
            <th scope="col">TÍTULO</th>
            <th scope="col">VALOR</th>
            <th scope="col">VALOR PAGO</th>
            <th scope="col">SALDO</th>
            <th scope="col">VENCIMENTO ORIGINAL</th>
            <th scope="col">VENCIMENTO PRORROGADO</th>
            <th scope="col">BANCO</th>
            <th scope="col">STATUS</th>
            <th scope="col">FAZER TRATATIVA</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="titulo in titulos" :key="titulo.id">
            <th scope="row" class="align-middle">
              <input type="checkbox" :value="titulo.id" v-model="selected" />
            </th>
            <td class="align-middle">{{ titulo.id }}</td>
            <td class="align-middle">R$ {{ titulo.Valor}}</td>
            <td class="align-middle">R$ {{ titulo.valor_pago}}</td>
            <td class="align-middle">R$ {{titulo.valor_devido}}</td>
            <td class="align-middle">{{ titulo.data_vencimento }}</td>
            <td class="align-middle">{{ titulo.data_vencimento_prorrogado }}</td>
            <td class="align-middle">{{ titulo.banco }}</td>
            <td class="align-middle">{{ titulo.SituacaoBoleto }}</td>
            <td>
              <modal-tratativas
                v-bind:id_titulo="titulo.id"
                v-bind:id_cliente="id_cliente"
                v-bind:url_boleto="url_boleto"
                v-bind:url_nota="url_nota"
                v-bind:valor_devido="valor_devido"
                v-bind:vencimento_original="titulo.data_vencimento"
                v-bind:vencimento_prorrogado="titulo.data_vencimento_prorrogado"
                v-bind:user_logado="user_logado"
                v-bind:tipo_nota="titulo.TipoDeDocumento"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <hr />
    <div class="float-right mt-3 row">
      <div class="mr-1">
        <modal-selecao-tratativas
          v-if="selected.length > 1"
          v-bind:id_titulo="selected"
          v-bind:id_cliente="id_cliente"
          v-bind:valor_devido="valor_devido"
        />
      </div>
      <button
        type="button"
        class="btn btn-primary"
        v-on:click="finalizaAtendimento()"
      >Finalizar Atendimento</button>
    </div>
    <sweet-modal
      ref="sucesso"
      icon="success"
      hide-close-button
      blocking
    >Atendimento Finalizado Com Sucesso!!!</sweet-modal>
    <sweet-modal ref="sem_tratativa">
      Você não realizou nenhuma tratativa referente a esse cliente, abaixo você
      poderá escrever uma justificativa.
      <div class="col-md-12">
        <div class="form-group">
          <label class="d-flex justify-content-start">
            <b>Justificativa:</b>
          </label>
          <textarea type="text" class="form-control" v-model="observacao" rows="5" />
        </div>
      </div>
      <hr />
      <div class="float-right">
        <button
          v-on:click="finalizaAtendimentoSemTratativa(observacao)"
          class="btn btn-primary"
        >Finalizar</button>
        <button v-on:click="closeModal()" class="btn btn-danger">Fechar</button>
      </div>
    </sweet-modal>
  </div>
</template>

<script>
export default {
  props: [
    "url",
    "id_cliente",
    "url_boleto",
    "url_nota",
    "valor_devido",
    "user_logado"
  ],
  components: {},
  data() {
    return {
      titulos: "",
      selectAll: false,
      selected: [],
      observacao: ""
    };
  },
  mounted() {
    this.getTitulos(this.id_cliente);
  },
  methods: {
    getTitulos(id_cliente) {
      this.$vs.loading();
      axios
        .get("api/get-informacao-titulos/" + id_cliente)
        .then(res => {
          this.titulos = res.data;
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    },
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let i in this.titulos) {
          this.selected.push(this.titulos[i].id);
        }
      }
    },

    finalizaAtendimento() {
      this.$vs.loading();
      axios
        .post("/api/encerra-atendimento", { id_cliente: this.id_cliente })
        .then(response => {
          let retorno = response.data;
          if (retorno.mensagem === "sucesso") {
            this.$vs.loading.close();
            this.$refs.sucesso.open();
            setTimeout(() => {
              window.location.reload(1);
            }, 1500);
          } else {
            this.$vs.loading.close();
            this.$refs.sem_tratativa.open();
          }
        })
        .catch(e => {});
    },

    finalizaAtendimentoSemTratativa(dados) {
      if (dados === "") {
        this.$vs.notify({
          title: "Falha!!!",
          text: "Informe a Justificativa",
          color: "danger",
          position: "top-center"
        });
      } else {
        this.$vs.loading();
        axios
          .post("/api/encerra-atendimento-sem-tratativa", {
            id_cliente: this.id_cliente,
            observacao: dados
          })
          .then(response => {
            this.$vs.loading.close();
            this.$refs.sem_tratativa.close();
            this.$refs.sucesso.open();
            setTimeout(() => {
              window.location.reload(1);
            }, 2000);
          })
          .catch(e => {
            this.$vs.loading.close();
          });
      }
    },

    closeModal() {
      this.$refs.sem_tratativa.close();
    },
  }
};
</script>

<style>
.link {
  text-decoration: none;
  color: #212529;
}
</style>