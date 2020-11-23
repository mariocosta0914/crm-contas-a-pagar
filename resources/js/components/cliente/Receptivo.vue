<template>
  <div class="row">
    <div class="col">
      <h3>
        <strong>Atendimento</strong>
      </h3>
    </div>
    <div class="col">
      <div class="row float-right">
        <div class="col-auto">
          <input type="number" class="form-control" placeholder="Informe o CNPJ" v-model="cnpj" />
        </div>
        <div class="col-auto">
          <button v-on:click="buscarCliente(cnpj)" type="button" class="btn btn-primary">
            <i class="fa fa-search" aria-hidden="true"></i> Buscar Cliente Receptivo
          </button>
        </div> 
      </div>
    </div>
    <sweet-modal
      ref="sucesso"
      icon="success"
      hide-close-button
      blocking
    >Cliente Localizado Com Sucesso!!!</sweet-modal>
    <sweet-modal ref="warning" icon="warning" title="Atenção!!!">
      <b>Esse Cliente Encontra-se em Atendimento Com Outro Operador</b>
      <hr />
      <div class="float-right">
        <button v-on:click="$refs.warning.close()" class="btn btn-danger">Fechar</button>
      </div>
    </sweet-modal>
    <sweet-modal ref="naoEcontrado" icon="warning" title="Atenção!!!">
      <b>Esse ClienteNão Foi Encontrado em Nossa Base de Dados!!!</b>
      <hr />
      <div class="float-right">
        <button v-on:click="$refs.naoEcontrado.close()" class="btn btn-danger">Fechar</button>
      </div>
    </sweet-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cnpj: ""
    };
  },

  methods: {
    buscarCliente(cnpj) {
      if (cnpj === "") {
        this.$vs.notify({
          title: "Falha!!!",
          text: "Informe Um CNPJ Para a Pesquisa",
          color: "danger",
          position: "top-center"
        });
      } else {
        this.$vs.loading();
        axios
          .post("/api/get-receptivo", { CNPJ: cnpj })
          .then(response => {
            let retorno = response.data;
            if (retorno.mensagem === "sucesso") {
              this.$vs.loading.close();
              this.$refs.sucesso.open();
              setTimeout(() => {
                window.location.reload(1);
              }, 1500);
            } else {
              if (retorno.mensagem === "em_atendimento") {
                this.$vs.loading.close();
                this.$refs.warning.open();
              } else {
                if (retorno.mensagem === "nao_encontrado") {
                  this.$vs.loading.close();
                  this.$refs.naoEcontrado.open();
                }
              }
            }
          })
          .catch(e => {});
      }
    }
  }
};
</script>