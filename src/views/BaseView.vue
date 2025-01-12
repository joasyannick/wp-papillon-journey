<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { onMounted, ref } from 'vue'
  import Two from 'two.js'

  const main = ref< HTMLElement | null >( null )

  onMounted( () => {
      const two = new Two( {
          type: Two.Types.canvas,
          fullscreen: true
        } ).appendTo( main.value! )

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
  <main id="papj-main" ref="main">
    <article id="pap-phone-app"></article>
    <aside id="papj-phone"></aside>
    <RouterView />
  </main>
</template>