<template>
  <div>
    <div class="row">
      <div class="col-md-5">
        <card-generico>
          <h5 class="card-title">Intervalo de Vencimento</h5>
          <hr />
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Data Inicial:</label>
              <input type="date" class="form-control mt-1" v-model="intervalo.data_inicial" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Data Final:</label>
              <input type="date" class="form-control mt-1" v-model="intervalo.data_final" />
            </div>
          </div>
        </card-generico>
      </div>
      <div class="col-md-5">
        <card-generico>
          <h5 class="card-title">Intervalo de Valor</h5>
          <hr />
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Valor Inicial:</label>
              <input type="number" class="form-control mt-1" v-model="intervalo.valor_inicial" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Valor Final:</label>
              <input type="number" class="form-control mt-1" v-model="intervalo.valor_final" />
            </div>
          </div>
        </card-generico>
      </div>
      <div class="col-md-2">
        <card-generico>
          <h6 class="card-title">
            <b>Resultado</b>
          </h6>
          <div class="row">
            <div class="col-md-12">
              <p>
                Clientes:
                <strong>{{informacoes.quantidade}}</strong>
              </p>
            </div>
            <div class="col-md-12">
              <p>
                Valor:
                <strong>{{formataNumero(informacoes.soma)}}</strong>
              </p>
            </div>
          </div>
          <button
            v-if="destination.length===0"
            type="button"
            class="btn btn-primary"
            disabled
          >Verificar</button>
          <button
            v-else
            type="button"
            class="btn btn-primary"
            v-on:click="verificarInformacoes(destination,intervalo)"
          >Verificar</button>
        </card-generico>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <label class="d-flex justify-content-center">
              <strong>Lista de Prioridades</strong>
            </label>
          </div>
          <div class="col-md-6">
            <label class="ml-5">
              <strong>Prioridades Ativas</strong>
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-md-8">
        <dual-list
          :source="source"
          :destination="destination"
          label="name"
          @onChangeList="onChangeList"
        />
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6 d-flex justify-content-center ml-3">
        <h5>
          <strong>Quantidade de Boletos: {{retorno.quantidade}}</strong>
        </h5>
      </div>
      <div class="col-md-5 ml-4">
        <h5>
          <strong>Valor Total Devido: R$ {{retorno.valor}}</strong>
        </h5>
      </div>
    </div>
    <div class="float-right">
      <button v-if="destination.length===0" type="button" class="btn btn-primary" disabled>Salvar</button>
      <button
        v-else
        type="button"
        class="btn btn-primary"
        v-on:click="salvarFila(destination,intervalo)"
      >Salvar</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["segmento"],
  data() {
    return {
      source: [
        {
          name: "Menor Valor de Dívida",
          code: "1",
          segmento: this.segmento,
        },
        {
          name: "Maior Valor de Dívida",
          code: "2",
          segmento: this.segmento,
        },
        {
          name: "Menor Quantidade de Títulos",
          code: "3",
          segmento: this.segmento,
        },
        {
          name: "Maior Quantidade de Títulos",
          code: "4",
          segmento: this.segmento,
        },
        {
          name: "Menor Quantidade de Dias Em Atraso",
          code: "5",
          segmento: this.segmento,
        },
        {
          name: "Maior Quantidade de Dias Em Atraso",
          code: "6",
          segmento: this.segmento,
        },
        {
          name: "Maior Tempo de Último Acionamento",
          code: "7",
          segmento: this.segmento,
        },
        {
          name: "Menor Tempo de Último Acionamento",
          code: "8",
          segmento: this.segmento,
        },
      ],
      destination: [],
      intervalo: {
        segmento: this.segmento,
      },
      informacoes: {
        quantidade: 0,
        soma: 0,
      },
      retorno: {},
    };
  },

  mounted() {
    this.getPrioridades();
    this.getConfiguracaoFila();
  },

  watch: {
    retorno: function () {
      setTimeout(() => {
        this.$vs.loading.close();
      }, 4000);
    },
    informacoes: function () {},
  },

  methods: {
    onChangeList: function ({ source, destination }) {
      this.source = source;
      this.destination = destination.sort();
    },

    getConfiguracaoFila() {
      axios
        .post("/api/configuracao-fila", {
          segmento: this.segmento,
        })
        .then((response) => {
          this.retorno = response.data;
        })
        .catch((e) => {});
    },

    verificarInformacoes(dados, ranger) {
      this.$vs.loading();
      axios
        .post("/api/get-valores-fila", {
          segmento: this.segmento,
          fila: dados,
          intervalo: ranger,
        })
        .then((response) => {
          this.informacoes = response.data;
          this.$vs.loading.close();
        })
        .catch((e) => {
          this.$vs.loading.close();
        });
    },

    salvarFila(dados, ranger) {
      this.$vs.loading();
      axios
        .post("/api/salvar-fila", {
          segmento: this.segmento,
          fila: dados,
          intervalo: ranger,
        })
        .then((response) => {
          this.$vs.loading.close();
          this.$vs.notify({
            title: "Sucesso!!!",
            text: "Fila Salva Com Sucesso!!!",
            color: "success",
            position: "top-right",
          });
        })
        .catch((e) => {
          this.$vs.loading.close();
          this.$vs.notify({
            title: "Falha!!!",
            text: "Não Foi Possível Salvar a Fila!!!",
            color: "danger",
            position: "top-right",
          });
        });
    },

    getPrioridades() {
      this.$vs.loading();
      axios
        .get("/api/get-prioridades/" + this.segmento)
        .then((response) => {
          this.destination = response.data;
        })
        .catch((e) => {
          this.$vs.loading.close();
        });
    },

    formataNumero(numero) {
      return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(numero);
    },
  },
};
</script>

<style>
.list-box-wrapper .list-box-item .search-box {
  display: none !important;
}

.border {
  border: 0px !important;
}

.list-box-wrapper .list-box-item .bulk-action {
  display: none !important;
}
</style>