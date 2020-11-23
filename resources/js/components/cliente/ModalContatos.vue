<template>
  <div>
    <button v-on:click="openModal()" type="button" class="btn btn-primary">
      <i class="fa fa-plus-square" aria-hidden="true"></i> Adicionar Contatos
    </button>
    <sweet-modal ref="modal" title="Adição de Contatos" width="70%">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10" v-for="formulario in dados.emails">
              <div class="form-group">
                <label>E-mail</label>
                <input type="email" class="form-control" name="email[]" v-model="formulario.email" />
              </div>
            </div>
            <div class="col-md-2 mt-4">
              <a href="#">
                <i
                  class="mais fa fa-plus-square fa-2x"
                  aria-hidden="true"
                  v-on:click="adicionarEmail()"
                ></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10" v-for="formulario in dados.telefones">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Telefone:</label>
                    <input
                      type="text"
                      class="form-control"
                      name="telefone[]"
                      v-model="formulario.telefone"
                      v-mask="['(##) ####-####','(##) #####-####']"
                    />
                  </div>
                </div>
                <div class="col-md-3 mt-4">
                  <div class="form-check mais">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="customCheck1"
                      name="whatsapp[]"
                      v-model="formulario.whatsapp"
                    />
                    <label class="form-check-label">WhatsApp?</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 mt-4">
              <a href="#">
                <i
                  class="mais fa fa-plus-square fa-2x"
                  aria-hidden="true"
                  v-on:click="adicionarTelefone()"
                ></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <div class="float-right">
        <button v-on:click="adicionarContatos()" class="btn btn-primary">Adicionar Contatos</button>
        <button v-on:click="closeModal()" class="btn btn-danger">Fechar</button>
      </div>
    </sweet-modal>
    <sweet-modal
      ref="sucesso"
      icon="success"
      hide-close-button
      blocking
    >Contatos Adicionados Com Sucesso!!!</sweet-modal>
    <sweet-modal ref="erro" icon="error">Não Foi Possível Salvar os Contatos</sweet-modal>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      dados: {
        emails: [{ email: "", id_cliente: this.id }],
        telefones: [{ telefone: "", whatsapp: false, id_cliente: this.id }]
      }
    };
  },
  mounted() {},
  methods: {
    adicionarContatos() {
      this.$vs.loading();
      axios
        .post("api/adicionar-contatos", this.dados)
        .then(response => {
          let retorno = response.data;
          this.$vs.loading.close();
          this.$refs.modal.close();
          this.$refs.sucesso.open();
          setTimeout(() => {
            window.location.reload(1);
          }, 1500);
        })
        .catch(e => {
          this.$vs.loading.close();
          this.$refs.erro.open();
        });
    },
    adicionarEmail() {
      this.dados.emails.push({ email: "", id_cliente: this.id });
    },

    adicionarTelefone() {
      this.dados.telefones.push({
        telefone: "",
        whatsapp: false,
        id_cliente: this.id
      });
    },
    openModal() {
      this.$refs.modal.open();
    },
    closeModal() {
      this.$refs.modal.close();
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
  margin-top: 20%;
}
</style>