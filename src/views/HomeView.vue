<script setup lang="ts">
  import { RouterLink } from 'vue-router'
  import { ref } from 'vue'

  const perPage = 100
  const updates = ref( [] as { id: number, title: string, excerpt: string, link: string }[] )
  const current = ref( undefined as undefined | number )

  const fetchUpdates = async () => {
      try {
        for ( let [ page, more ] = [ 1, true ]; more; page++ ) {
          const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/papj-updates?per_page=' + perPage + '&page=' + page + '&_fields=id,title.rendered,excerpt.rendered,slug' )
          const json = await response.json()
          json.forEach( ( update: any ) => updates.value.push( { id: update.id, title: update.title.rendered, excerpt: update.excerpt.rendered, link: '/updates/' + update.slug } ) )
          more = page < parseInt( response.headers.get( 'X-WP-TotalPages' )! )
        }
        if ( updates.value.length ) {
          current.value = 0
        }
      } catch ( exception ) {
        console.error( 'Failed to fetch updates: ' + exception )
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
      <div v-show="current && updates[ current ].id === update.id" v-html="update.excerpt"></div>
      <footer>
        <RouterLink :to="update.link">Read</RouterLink>
      </footer>
    </article>
  </nav>
</template>

<style scoped>
</style>