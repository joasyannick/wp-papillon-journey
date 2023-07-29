<script setup lang="ts">
  import { useI18n } from 'vue-i18n'
  const { t } = useI18n()
</script>

<script lang="ts">
  export default {
    data() {
      return {
        image: ''
      }
    },
    created() {
      fetch( import.meta.env.VITE_WP_REST_URL + 'papillon-journey/v1/welcome/image' )
        .then( response => response.json() )
        .then( data => this.image = data )
    },
  }
</script>

<template>
  <article class="papj-welcome">
    <header>
      <h2>{{ t("welcome.thrive") }}</h2>
    </header>
    <img alt="Welcome image" :src="image"/>
  </article>  
</template>

<style scoped>

  article.papj-welcome {
    display: flex;
  }
  article.papj-welcome > header {
    position: absolute;
  }

  article.papj-welcome > header {
    top: 60px;
    left: 20px;
    font: 20px/calc(1.5 * 20px) 'Quicksand', sans-serif;
  }

  article.papj-welcome > img {
    width: 100vw;
    height: 100vh;
    object-fit: cover;
  }
</style>