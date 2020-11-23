<template>
  <div v-bind:class="defineTipo" role="alert">
            {{mensagem}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
</template>

<script>
export default {
  props: ["mensagem","tipo"],
  computed:{
    defineTipo:function(){
      if(this.tipo=='sucesso'){
        return "alert alert-success alert-dismissible fade show"
      }
      if(this.tipo=='falha'){
        return "alert alert-danger alert-dismissible fade show"
      }
      if(this.tipo=='atencao'){
        return "alert alert-warning alert-dismissible fade show"
      }
    }
  }
};
</script>
