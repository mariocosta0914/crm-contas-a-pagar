<template>
  <div>
    <div class="text-center">
      <button
        v-on:click="modal()"
        type="button"
        class="btn btn-primary"
      >Tratar</button>
    </div>
    <sweet-modal ref="modal" width="70%" :title=" 'Titulo:' + id_titulo">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped">
              <thead>
                <tr class="text-center" v-if="tipo_nota == 'Nota Fiscal de Serviço Eletrônica' || tipo_nota=='Nota de Telecomunicação - Fortel'">
                  <th scope="col">Enviar lembrete</th>
                  <th scope="col">Enviar boleto</th>
                  <th scope="col">Baixar Boleto</th>
                  <th scope="col">Baixar Nota</th>
                </tr>

                <tr class="text-center" v-else>
                  <th scope="col">Enviar lembrete</th>
                  <th scope="col">Enviar boleto</th>
                  <th scope="col">Baixar Boleto</th>
                </tr>
              </thead>

              <tbody>
                <tr class="text-center">
                  <td>
                    <div>
                      <a v-on:click="$refs.envioLembrete.open()" href="#">
                        <i class="fa fa-paper-plane-o fa-lg link" aria-hidden="true"></i>
                      </a>
                    </div>
                  </td>
                  <td>
                    <a v-on:click="$refs.envioTituloNota.open()" href="#">
                      <i class="fa fa-paper-plane fa-lg link" aria-hidden="true"></i>
                    </a>
                  </td>
                  <td>
                    <a v-bind:href="url_boleto + '/' + id_titulo">
                      <i class="fa fa-cloud-download fa-lg link" aria-hidden="true"></i>
                    </a>
                  </td>
                  <td v-if="tipo_nota == 'Nota Fiscal de Serviço Eletrônica' || tipo_nota=='Nota de Telecomunicação - Fortel'">
                    <a v-bind:href="url_nota + '/' + id_titulo">
                      <i class="fa fa-download fa-lg link" aria-hidden="true" />
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            {{dadosTratativas.ocorrencia}}
            <label>
              <b>Ocorrencia</b>
            </label>
            <select class="custom-select" v-model="selectted">
              <option disabled value>Selecione Uma Ocorrência</option>
              <option v-for="option in options" :key="option.id">{{option.nome_ocorrencia}}</option>
            </select>
          </div>
          <div class="col-md-05 ml-4">
            <label>
              <b>Agendamento do valor</b>
            </label>
            <input
              type="text"
              class="form-control"
              placeholder="R$ 15.000,00"
              v-model="dadosTratativas.Valor"
              onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            />
          </div>

          <div class="col-md-02 ml-4">
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
        </div>

        <div class="row">
          <div class="col-md-12">
            <label for="exampleFormControlTextarea1">
              <b>Acionamento</b>
            </label>
            <textarea
              class="form-control form-control-lg"
              rows="6"
              v-model="dadosTratativas.descricao_tratativa"
            ></textarea>
          </div>
        </div>
        <hr />
        <div class="float-right">
          <button type="button" class="btn btn-primary" @click="insertTratativas()">Salvar</button>
          <button type="button" class="btn btn-danger" v-on:click="$refs.modal.close()">Fechar</button>
        </div>
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
    <sweet-modal ref="envioLembrete" title="Envio de Lembrete de Pagamento" width="50%">
      <modal-envio-lembrete
        v-bind:id="id_titulo"
        v-bind:id_cliente="id_cliente"
        v-on:fechar-modal="$refs.envioLembrete.close()"
        v-on:abrir-modal-sucesso="$refs.successLembrete.open()"
        v-on:abrir-modal-info="$refs.infoLembrete.open()"
        v-on:fechar-modal-info="$refs.infoLembrete.close()"
        v-on:abrir-modal-erro="$refs.erroLembrete.open()"
      ></modal-envio-lembrete>
    </sweet-modal>
    <sweet-modal ref="envioTituloNota" title="Envio de Título e Nota Fiscal" width="50%">
      <modal-envio-titulo-nota
        v-bind:id="id_titulo"
        v-bind:id_cliente="id_cliente"
        v-on:fechar-modal="$refs.envioTituloNota.close()"
        v-on:abrir-modal-sucesso="$refs.successLembrete.open()"
        v-on:abrir-modal-info="$refs.infoLembrete.open()"
        v-on:fechar-modal-info="$refs.infoLembrete.close()"
        v-on:abrir-modal-erro="$refs.erroLembrete.open()"
      ></modal-envio-titulo-nota>
    </sweet-modal>
    <sweet-modal ref="successLembrete" icon="success" blocking>E-mails Enviados Com Sucesso!!!</sweet-modal>
    <sweet-modal ref="infoLembrete" icon="info" blocking hide-close-button>Enviando E-mails...</sweet-modal>
    <sweet-modal ref="erroLembrete" icon="error">Não Foi Possível Enviar os E-mails</sweet-modal>
  </div>
</template>

<script>
import { ptBR } from "vuejs-datepicker/dist/locale";
export default {
  props: [
    "id_titulo",
    "id_cliente",
    "url_boleto",
    "url_nota",
    "valor_devido",
    "vencimento_original",
    "vencimento_prorrogado",
    "tipo_nota"
  ],
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
        id_cliente: "",
        id_titulo: "",
        Valor: "",
        descricao_tratativa: "",
        dataInicio: "",
        id_ocorrencia: "",
        saldo_devedor: this.valor_devido,
        vencimento_original: this.vencimento_original,
        vencimento_prorrogado: this.vencimento_prorrogado
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
      axios
        .get("/api/get-ocorrencia")
        .then(res => {
          this.options = res.data;
        })
        .catch(e => {});
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
      this.$vs.loading();
      let dados = this.dadosTratativas;
      this.dadosTratativas.id_cliente = this.id_cliente;
      this.dadosTratativas.id_titulo = this.id_titulo;
      dados.nome_cliente = this.cliente.nome;
      axios
        .post("api/cadastro-tratativa", dados)
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
