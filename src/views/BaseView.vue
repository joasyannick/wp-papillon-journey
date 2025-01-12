<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { onMounted, ref } from 'vue'
  import Two from 'two.js'

  const game = ref< HTMLElement | null >( null )

  onMounted( () => {
      const two = new Two( {
          type: Two.Types.canvas,
          fullscreen: true
        } ).appendTo( game.value! )

      // Create a triangle
      const triangle = two.makePolygon( 400, 300, 50, 3 ) // x, y, radius, sides
      triangle.stroke = "#ff0000"
      triangle.fill = "#ffcccc"
      triangle.linewidth = 4

      two.bind( "update", () => {
          triangle.rotation += 0.02 // Rotate the triangle
        } ).play()
    } )
</script>

<template>
  <main id="papj-main">
    <article id="papj-phone-app">
    </article>
    <aside id="papj-phone">
      <RouterView />
    </aside>
    <article id="papj-game" ref="game">
    </article>
  </main>
</template>