<script setup>
import { useRouter, RouterLink } from 'vue-router'
import SectionTitle from '@/components/SectionTitle.vue'

const router = useRouter()

const routes = router.getRoutes()

const screens = []

for (const routeIndex in routes) {
  const path = routes[routeIndex].path
  const title = routes[routeIndex].meta && routes[routeIndex].meta.title ? routes[routeIndex].meta.title : null

  if (title) {
    screens.push({
      path,
      title
    })
  }
}
</script>

<template>
  <SectionTitle last>
    Check other components and layouts:<br>
    <template
      v-for="(screen, index) in screens"
      :key="screen.path"
    >
      <RouterLink
        :to="screen.path"
        class="text-blue-500"
      >
        {{ screen.title }}
      </RouterLink>
      <template v-if="index + 1 < screens.length">
        ,
      </template>
    </template>
  </SectionTitle>
</template>
