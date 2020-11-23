<template>
  <div>
    <button
      v-on:click="modal()"
      type="button"
      class="btn btn-success"
    >Fazer Tratativas Para Títulos Selecionados</button>
    <sweet-modal ref="modal" width="70%" :title=" 'Titulos: ' + id_titulo">
      <div class="row">
        <div class="col-md-5">
          <label>
            <b>Ocorrência</b>
          </label>
          <select class="custom-select" v-model="selectted">
            <option disabled value>Selecione Uma Ocorrência</option>
            <option v-for="option in options" :key="option.id">{{option.nome_ocorrencia}}</option>
          </select>
        </div>

        <div class="col-md-3">
          <label>
            <b>Data:</b>
          </label>
          <datepicker
            input-class="form-control"
            :language="datepicker.ptBR"
            :format="datepicker.format"
            v-model="dadosTratativas.dataInicio"
          />
        </div>
        <div class="col-md-4">
          <label>
            <b>Agendamento do valor</b>
          </label>
          <input
            type="text"
            class="form-control"
            placeholder="Informe o Valor Negociado"
            v-model="dadosTratativas.Valor"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
          />
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-md-12">
          <label>
            <b>Acionamento</b>
          </label>
          <textarea class="form-control" rows="6" v-model="dadosTratativas.descricao_tratativa"></textarea>
        </div>
      </div>
      <hr />
      <div class="float-right">
        <button type="button" class="btn btn-primary" @click="insertTratativas()">Salvar</button>
        <button type="button" class="btn btn-danger" v-on:click="$refs.modal.close()">Fechar</button>
      </div>
    </sweet-modal>
    <sweet-modal
      ref="sucesso"
      icon="success"
      hide-close-button
      blocking
    >Ocorrência Salva Com Sucesso!!!</sweet-modal>
    <sweet-modal
      ref="erro"
      icon="error"
    >Não Foi Possível Salvar ocorrência, verifique se todos os campos estão corretos</sweet-modal>
  </div>
</template>

<script>
import { ptBR } from "vuejs-datepicker/dist/locale";
export default {
  props: ["id_titulo", "id_cliente", "valor_devido"],
  data() {
    return {
      options: [],
      selectted: "",
      datepicker: {
        format: "dd/MM/yyyy",
        ptBR: ptBR
      },
      cliente: {},
      dadosTratativas: {
        id_cliente: this.id_cliente,
        id_titulo: this.id_titulo,
        Valor: "",
        descricao_tratativa: "",
        dataInicio: "",
        id_ocorrencia: "",
        saldo_devedor: this.valor_devido
      }
    };
  },
  watch: {
    selectted(newValue) {
      this.retornoOcorrencia(newValue);
      this.getIdOcorrencia(newValue);
    }
  },
  mounted() {
    this.dataAtual();
    this.getDescricaoOcorrencia();
    this.getInformacoes();
  },

  methods: {
    getInformacoes() {
      axios
        .get("/api/get-informacao-cliente/" + this.id_cliente)
        .then(response => {
          this.cliente = response.data;
        })
        .catch(e => {});
    },
    getDescricaoOcorrencia() {
      this.$vs.loading();
      axios
        .get("/api/get-ocorrencia")
        .then(res => {
          this.options = res.data;
          this.$vs.loading.close();
        })
        .catch(e => {
          this.$vs.loading.close();
        });
    },
    retornoOcorrencia(newValue) {
      let date = new Date();
      switch (newValue) {
        case "Promessa de Pagamento":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 2
          );
          break;
        case "Retorno agendado":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
          );
          break;
        case "Parcelamento":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 2
          );
          break;
        case "Solicitação de Cancelamento":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 7
          );
          break;
        case "Confissão de Dívida":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 7
          );
          break;
        case "Notificação Extrajudicial":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 7
          );
          break;
        case "Reenvio de boleto":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 2
          );
          break;
        case "Reenvio de Nota":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 2
          );
          break;
        case "alteração de e-mail":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
          );
          break;
        case "Acionado por e-mail":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 1
          );
          break;
        case "Baixado Manual":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
          );
          break;
        case "Acionado via Whatsapp":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 1
          );
          break;
        case "Cliente questiona Valor":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 2
          );
          break;
        case "Pendência consultor":
          this.dadosTratativas.dataInicio = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 2
          );
          break;

        default:
      }
    },
    insertTratativas() {
      let dados = this.dadosTratativas;
      dados.nome_cliente = this.cliente.nome;
      if (
        dados.descricao_tratativa === "" ||
        dados.Valor === "" ||
        dados.id_ocorrencia === ""
      ) {
        this.$vs.notify({
          title: "Falha!!!",
          text: "Preencha Todos os Campos!!!",
          color: "danger",
          position: "top-center"
        });
      } else {
        this.$vs.loading();
        axios
          .post("/api/cadastro-selecao-tratativa", dados)
          .then(response => {
            let retorno = response.data;
            this.$refs.modal.close();
            this.$refs.sucesso.open();
            this.$vs.loading.close();
            setTimeout(() => {
              window.location.reload(1);
            }, 1500);
          })
          .catch(e => {
            this.$vs.loading.close();
            this.$refs.erro.open();
          });
      }
    },

    getIdOcorrencia(nome_ocorrencia) {
      axios
        .get("api/get-id-ocorrencia/" + nome_ocorrencia)
        .then(res => {
          this.dadosTratativas.id_ocorrencia = res.data[0].id;
        })
        .catch(e => {});
    },
    dataAtual() {
      let date = new Date();
      date;
      this.dadosTratativas.dataInicio = new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate()
      );
    },

    modal() {
      this.$refs.modal.open();
    }
  }
};
</script>
<style>
