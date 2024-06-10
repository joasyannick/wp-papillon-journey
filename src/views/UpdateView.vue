<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'

  const slug = useRoute().params.slug
  const update = ref( undefined as undefined | { title: string, content: string } )
  
  const fetchPost = async () => {
      try {
        const request = import.meta.env.VITE_WP_REST_URL + 'wp/v2/papj-updates?slug=' + slug + '&_fields=title.rendered,content.rendered'
        const response = await fetch( request )
        const updates = await response.json()
        if ( updates.length ) {
          update.value = { title: updates[ 0 ].title.rendered, content: updates[ 0 ].content.rendered }
        }
      } catch ( exception ) {
        console.error( 'Failed to fetch the update' )
      }
    }

  fetchPost()
</script>

<template>
  <section v-if="update" class="papj-update">
    <header>
      <h2 v-html="update.title"></h2>
    </header>
    <div v-html="update.content"></div>
  </section>
</template>

<style scoped>
</style>
