<template>
    <va-navbar class="app-layout-navbar">
        <template #left>
            <div class="left">
                <va-icon-menu-collapsed
                :class="{ 'x-flip': isSidebarMinimized }"
                class="va-navbar__item"
                :color="colors.primary"
                @click="isSidebarMinimized = !isSidebarMinimized"
                />
              <router-link class="logo" to="/">WORKWEET</router-link>
            </div>
        </template>
        <template #center>
            <va-input v-model="simple" placeholder="search..." />
        </template>
        <template #right>
            <AppNavbarActions class="app-navbar__actions md5 lg4" :user-name="userName" />
        </template>
    </va-navbar>
</template>

<script setup>
    import VaIconMenuCollapsed from '../icons/VaIconMenuCollapsed.vue'
    import AppNavbarActions from './AppNavbarActions.vue'
    import { useColors } from 'vuestic-ui'
    import { ref, computed } from 'vue'
    
    const { getColors } = useColors()
    const colors = computed(() => getColors())
    const simple = ref('')
    //const userName = useUserName()
    //const isSidebarMinimized = useIsSidebarMinimized()
    const userName = 'Guillaume B.'
    const isSidebarMinimized = true
</script>

<style>
    .left{
        display: flex;
    }
    .logo{
        font-size: x-large;
        font-weight: bold;
        color: #154ec1;
        margin-left: 1rem;
    }
    .app-layout-navbar{
        box-shadow: var(--va-box-shadow);
        z-index: 2;
    }

</style>