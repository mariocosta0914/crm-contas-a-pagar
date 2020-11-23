<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <p>
          <strong>Quantidade de Títulos em Aberto:</strong>
          {{informacoes.quantidade}}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p>
          <strong>Valor Total:</strong>
          R$ {{informacoes.valor_total}}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p>
          <strong>Valor Pago:</strong>
          R$ {{informacoes.valor_pago}}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p>
          <strong>Valor Devido:</strong>
          R$ {{informacoes.valor_devido}}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      informacoes: {},
    };
  },
  mounted() {
    this.getInformacoes(this.id);
  },
  methods: {
    formataNumero(numero) {
      return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(numero);
    },

    getInformacoes(id) {
      axios
        .get("/api/get-titulos-valor/" + id)
        .then((response) => {
          this.informacoes = response.data;
        })
        .catch((e) => {});
    },
  },
};
</script>