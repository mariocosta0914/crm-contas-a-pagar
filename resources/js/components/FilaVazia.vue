<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <blockquote
          class="blockquote text-center text-danger"
        >Caro Operador, Sua Fila Encontra-se Vazia, Solicite Ao Seu Supervisor Uma Nova Fila De Atendimento!!!</blockquote>
      </div>
    </div>
    <div class="row d-flex justify-content-center">
        <a class="btn btn-primary" v-bind:href="url" role="button">Atualizar A Página</a>
      </div>
  </div>
</template>

<script>
export default {
  props: ["url"],
};
</script>