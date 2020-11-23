<template>
  <div class="container">
    <h4>
      <strong>{{ informacoes.nome }}</strong>
      
    </h4>
    <hr />

    <div class="row">
      <div class="col-md-3">
        <p>
          <strong>CNPJ:</strong> {{informacoes.cnpj}}
        </p>
      </div>
      <div class="col-md-4">
        <p>
          <strong>E-mail-1:</strong> {{informacoes.Email}}
        </p>
      </div>

      <div class="col-md-4">
        <p>
          <strong>E-mail-2:</strong> {{informacoes.Email}}
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <p>
          <strong>Telefone:</strong> {{informacoes.Telefone}}
        </p>
      </div>
      <div class="col-md-4">
        <p>
          <strong>Vendedor:</strong> {{informacoes.Vendedor}}
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
      getInformacoes(id){
          axios
          .get('api/get-informacao-cliente/' + id)
          .then(res => {
              this.informacoes = res.data
          })
          .catch(e => {});
      }

   
  }
};
</script>
