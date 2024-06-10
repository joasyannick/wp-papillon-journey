<script setup lang="ts">
  import { RouterLink } from 'vue-router'
  import { ref } from 'vue'

  const updates = ref( [] as { id: number, title: string, excerpt: string, link: string }[] )

  const fetchUpdates = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/papj-updates?_fields=id,title.rendered,excerpt.rendered' )
        const json = await response.json()
        json.forEach( ( update: any ) => updates.value.push( { id: update.id, title: update.title.rendered, excerpt: update.excerpt.rendered, link: update.link } ) ) 
      } catch ( exception ) {
        console.error( 'Failed to fetch updates' )
      }
    }

  fetchUpdates()
</script>

<template>
  <article class="papj-welcome">
    <header>
      <h1>Welcome</h1>
    </header>
    <div>
      <p>The website is under maintenance.</p>
    </div>
  </article>
  <nav class="papj-updates">
    <header>
      <h1>Maintenance Updates</h1>
    </header>
    <article v-for="update in updates" :key="update.id">
      <header>
        <h2 v-html="update.title"></h2>
      </header>
      <p v-html="update.excerpt"></p>
      <footer>
        <a :href="update.link">Read</a>
      </footer>
    </article>
  </nav>
</template>

<style scoped>
</style>