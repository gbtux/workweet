<template>
    <va-sidebar :width="width" :minimized="minimized" :minimizedWidth="minimizedWidth" :animated="animated" :color="color">
        <menu-minimized v-if="minimized" :items="items" />
        <menu-accordion v-else :items="items" />
    </va-sidebar>
</template>

<script setup>
    import { ref } from 'vue'
    import routes from './NavigationRoutes'
    import MenuAccordion from './menu/MenuAccordion.vue'
    import MenuMinimized from './menu/MenuMinimized.vue'

    defineProps({
      width: {
        required: false,
        type: String,
        default: '16rem'
      },
      color: {
        required: false,
        type: String,
        default: 'background-secondary'
      },
      animated: {
        required: false,
        type: Boolean,
        default: true
      },
      minimized: {
        required: false,
        type: Boolean,
        default: true
      },
      minimizedWidth: {
        required: false,
        type: String,
        default: undefined
      }
    })

  const items = routes
</script>

<style lang="scss">
  .va-sidebar {
    &__menu {
      padding: 2rem 0;
    }

    &-item {
      &__icon {
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    }
  }
</style>
