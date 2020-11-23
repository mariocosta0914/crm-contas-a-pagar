<template>
  <div>
    <p class="d-flex justify-content-center">
      <b>Adicione os E-mails Para Envio do Lembrete de Pagamento</b>
    </p>
    <div class="row">
      <div class="col-md-10" v-for="formulario in dados.emails">
        <div class="form-group">
          <label class="d-flex justify-content-start">E-mail</label>
          <input type="email" class="form-control" name="email[]" v-model="formulario.email" />
        </div>
      </div>
      <div class="col-md-2 mt-3">
        <a href="#">
          <i class="mais fa fa-plus-square fa-2x" aria-hidden="true" v-on:click="adicionarEmail()"></i>
        </a>
      </div>
    </div>
    <hr />
    <div class="float-right">
      <button v-on:click="enviarNotaTitulo()" class="btn btn-primary">Enviar E-mail</button>
      <button v-on:click="$emit('fechar-modal')" class="btn btn-danger">Fechar</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id","id_cliente"],
  data() {
    return {
      dados: {
        emails: [{ email: "" }],
        cdrcd: ""
      }
    };
  },
  mounted() {
    this.getContatos();
  },
  methods: {
    enviarNotaTitulo() {
      this.dados.cdrcd = this.id;
      this.$emit("fechar-modal");
      this.$emit("abrir-modal-info");
      axios
        .post("/api/envia-lembrete", this.dados)
        .then(response => {
          let retorno = response.data;
          this.$emit("fechar-modal-info");
          this.$emit("abrir-modal-sucesso");
        })
        .catch(e => {
          this.$emit("fechar-modal-info");
          this.$emit("abrir-modal-erro");
        });
    },
    adicionarEmail() {
      this.dados.emails.push({ email: "" });
    },
    getContatos() {
      axios
        .get("/api/get-contatos-envio-email/" + this.id_cliente)
        .then(response => {
          this.dados.emails = response.data;
        })
        .catch(e => {});
    }
  }
};
</script>
<style>
h2,
.h2 {
  line-height: 2.8 !important;
}
.mais {
  text-decoration: none;
  color: #212529;
}

.link {
  text-decoration: none;
  color: #212529;
}
</style>