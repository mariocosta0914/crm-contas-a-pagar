<template>
  <div>
    <ul class="nav justify-content-center menu">
      <li class="nav-item">
        <a class="nav-link link" v-bind:href="url_inicio">
          <i class="fa fa-home mr-2" aria-hidden="true"></i>Início
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link link" v-bind:href="url_usuarios">
          <i class="fa fa-users mr-2" aria-hidden="true"></i>Usuários
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link link" v-bind:href="url_relatorios">
          <i class="fa fa-file-text mr-2" aria-hidden="true"></i>Relatórios
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link link" v-bind:href="url_envio_diario">
          <i class="fa fa-paper-plane mr-2" aria-hidden="true"></i>Envio diario
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link link" v-bind:href="url_configuracao">
          <i class="fa fa-cog mr-2" aria-hidden="true"></i>Configuração
        </a>
      </li>
    </ul>
    <hr />
  </div>
</template>

<script>
export default {
  props: [
    "url_inicio",
    "url_usuarios",
    "url_relatorios",
    "url_configuracao",
    "url_envio_diario"
  ]
};
</script>

<style scope>
.link {
  text-decoration: none;
  color: #212529;
}

a:hover {
  color: #212529;
}

.menu {
  font-size: large;
}
</style>