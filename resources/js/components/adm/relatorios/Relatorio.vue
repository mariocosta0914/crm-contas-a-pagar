<template>
  <div>
    <h5>
      <strong>Filtros</strong>
    </h5>
    <hr />
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label>Data Inicial:</label>
        <input type="date" class="form-control mt-1" v-model="relatorio.data_inicial" required />
      </div>
      <div class="col-md-4 mb-3">
        <label>Data Final:</label>
        <input type="date" class="form-control mt-1" v-model="relatorio.data_final" />
      </div>
      <div class="col-md-4 mb-3">
        <label>Operador:</label>
        <select-operador v-on:operadores="relatorioOperadores" />
      </div>
    </div>
    <button v-on:click="criarRelatorio()" class="btn btn-primary mb-2 float-right">Exportar</button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      relatorio: {}
    };
  },
  methods: {
    relatorioOperadores(valor) {
      this.relatorio.operadores = valor;
    },

    criarRelatorio() {
      if (this.relatorio.data_inicial > this.relatorio.data_final) {
        this.$vs.notify({
          title: "Falha!!!",
          text: "A Data Inicial é Maior Que A Data Final!!!",
          color: "danger",
          position: "top-right"
        });
      } else {
        if (
          typeof this.relatorio.data_inicial === "undefined" ||
          typeof this.relatorio.data_final === "undefined"
        ) {
          this.$vs.notify({
            title: "Falha!!!",
            text: "O Campo Data é Obrigatório",
            color: "danger",
            position: "top-right"
          });
        } else {
          this.$vs.loading();
          axios({
            url: "/api/criar-relatorio",
            method: "POST",
            responseType: "blob",
            data: this.relatorio
          })
            .then(response => {
              var fileURL = window.URL.createObjectURL(
                new Blob([response.data])
              );
              var fileLink = document.createElement("a");
              fileLink.href = fileURL;
              fileLink.setAttribute("download", "Relatorio-CRM-Cobranca.xls");
              document.body.appendChild(fileLink);
              fileLink.click();
              this.$vs.loading.close();
            })
            .catch(e => {
              this.$vs.loading.close();
            });
        }
      }
    }
  }
};
</script>