<template>
  <form method="POST" v-bind:action="url + '/' + dados.id">
    <div class="form-group">
      <label for="exampleInputEmail1">Nome</label>
      <input class="form-control" v-bind:value="dados.name" disabled />
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">E-mail</label>
      <input class="form-control" v-bind:value="dados.email" disabled />
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Data de Cadastro</label>
      <input class="form-control" v-bind:value="dados.data_criacao" disabled />
    </div>
    <input type="hidden" name="_method" value="PUT" />
    <input type="hidden" name="_token" v-bind:value="token" />
    <input type="hidden" name="id" v-bind:value="dados.id" />
    <div class="float-right">
      <button type="submit" class="btn btn-danger">Excluir Usuário</button>
      <a type="button" class="btn btn-primary" v-bind:href="url_voltar">Voltar</a>
    </div>
  </form>
</template>
<script>
export default {
  props: ["dados", "token", "url","url_voltar"],
  data() {
    return {};
  }
};
</script>