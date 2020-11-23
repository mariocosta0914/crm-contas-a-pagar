<template>
  <div>
    <card-generico sombra="true">
      <div class="col-md-12 overflow-auto caixa">
        <h4>
          <strong>Hitóricos de Tratativas</strong>
        </h4>
        <hr />
        <ul class="chat" v-for="dado in dados">
          <li class="left clearfix">
            <span class="chat-img pull-left">
              <i class="fa fa-user fa-5x" aria-hidden="true"></i>
            </span>
            <div class="chat-body clearfix">
              <div class="header">
                <strong class="primary-font">{{ dado.name}}</strong>
                <small class="pull-right text-muted">
                  <span class="glyphicon glyphicon-time">Retorno:</span>
                  {{ dado.Data_Renitencia }}
                </small>
              </div>
              <p>{{dado.nome_ocorrencia}}</p>
              <p v-if="dado.id_titulo==null">Titulo(s) : {{dado.titulos}}</p>
              <p v-else>Titulo(s) : {{dado.id_titulo}}</p>
              <p>Valor Negociado : {{formataNumero(dado.Valor)}}</p>
            </div>
          </li>
          <li class="right clearfix">
            <div class="chat-body clearfix">
              <div class="header">
                <small class="text-muted">
                  <span class="glyphicon glyphicon-time"></span>
                  Data e Hora da Tratativa: {{dado.data_criacao}}
                </small>
              </div>
              <p>{{dado.descricao_tratativa}}</p>
            </div>
          </li>
        </ul>
      </div>
    </card-generico>
  </div>
</template>

<script>
export default {
  props: ["id_cliente"],
  data() {
    return {
      dados: {}
    };
  },
  mounted() {
    this.getHitoricoTratativas(this.id_cliente);
  },
  methods: {
    getHitoricoTratativas(id) {
      axios
        .get("/api/get-historico-tratativas/" + id)
        .then(res => {
          this.dados = res.data;
        })
        .catch(e => {});
    },

    formataNumero(numero) {
      return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL"
      }).format(numero);
    }
  }
};
</script>

<style scoped>
.caixa {
  max-height: 500px;
}

.chat {
  list-style: none;
  margin: 0;
  padding: 0;
}

.chat li {
  margin-bottom: 10px;
  padding-bottom: 5px;
  border-bottom: 1px dotted #b3a9a9;
}

.chat li.left .chat-body {
  margin-left: 60px;
}

.chat li.right .chat-body {
  margin-right: 60px;
}

.chat li .chat-body p {
  margin: 0;
  color: #777777;
}

::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #f5f5f5;
}

::-webkit-scrollbar {
  width: 12px;
  background-color: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #555;
}
</style>