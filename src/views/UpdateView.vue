<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'

  const slug = useRoute().params.slug
  const update = ref( undefined as undefined | { title: string, content: string } )
  
  const fetchPost = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/papj-updates?slug=' + slug + '&_fields=title.rendered,content.rendered' )
        const json = await response.json()
        if ( json.length ) {
          update.value = { title: json[ 0 ].title.rendered, content: json[ 0 ].content.rendered }
        }
      } catch ( exception ) {
        console.error( 'Failed to fetch the update "' + slug + '": ' + exception )
      }
    }

  fetchPost()
</script>

<template>
  <article v-if="update" class="papj-update">
    <header>
      <h1 v-html="update.title"></h1>
    </header>
    <div v-html="update.content">
    </div>
  </article>
</template>

<style scoped>
</style>
