<template>
  <div>
    <div class="row">
      <div class="col-md-5">
        <p>
          <strong>Cliente:</strong>
          {{informacoes.nome}}
        </p>
      </div>
      <div class="col-md-3">
        <p>
          <strong>CNPJ:</strong>
          {{informacoes.cnpj | cnpj}}
        </p>
      </div>
      <div class="col-md-4">
        <p>
          <strong>Vendedor:</strong>
          {{informacoes.Vendedor}}
        </p>
      </div>
    </div>
    <div class="row">
      <div v-if="informacoes.Telefone" class="col-md-5">
        <p>
          <strong>Telefone:</strong>
          {{informacoes.Telefone}}
        </p>
      </div>
      <div v-if="informacoes.Telefone1" class="col-md-3">
        <p>
          <strong>Telefone:</strong>
          {{informacoes.Telefone1}}
        </p>
      </div>
      <div v-if="informacoes.Telefone2" class="col-md-4">
        <p>
          <strong>Telefone:</strong>
          {{informacoes.Telefone2}}
        </p>
      </div>
    </div>
    <div class="row">
      <div v-if="informacoes.Email" class="col-md-5">
        <p>
          <strong>E-mail:</strong>
          {{informacoes.Email}}
        </p>
      </div>
      <div v-if="informacoes.Celular" class="col-md-4">
        <p>
          <strong>Celular:</strong>
          {{informacoes.Celular}}
        </p>
      </div>
    </div>
    <div class="row">
      <div v-for="contato in contatos" class="col-md-4">
        <p v-if="contato.tipo_contato =='email'">
          <strong>E-mail:</strong>
          {{contato.contato}}
        </p>
        <p v-if="contato.tipo_contato =='telefone'">
          <strong v-if="contato.whatsapp==0">Telefone:</strong>
          <strong v-if="contato.whatsapp==1">Whatsapp:</strong>
          {{contato.contato}}
        </p>
      </div>
    </div>
    <modal-contatos v-bind:id="this.id"></modal-contatos>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      informacoes: {},
      contatos: {},
    };
  },
  filters: {
    cnpj: function (cnpj) {
      cnpj = typeof cnpj != "string" ? cnpj.toString() : cnpj;
      cnpj = cnpj.padStart(14, "0");
      cnpj = cnpj.replace(
        /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/,
        "$1.$2.$3/$4-$5"
      );
      return cnpj;
    },
  },

  mounted() {
    this.getInformacoes(this.id);
    this.getContatos(this.id);
  },
  methods: {
    getInformacoes(id) {
      axios
        .get("api/get-informacao-cliente/" + id)
        .then((response) => {
          this.informacoes = response.data;
        })
        .catch((e) => {});
    },
    getContatos(id) {
      axios
        .get("api/get-contatos/" + id)
        .then((response) => {
          this.contatos = response.data;
        })
        .catch((e) => {});
    },
  },
};
</script>
<style>
h2,
.h2 {
  line-height: 2.8 !important;
}
</style>