<template>
    <va-accordion v-model="accordionValue" class="sidebar-accordion va-sidebar__menu__inner" multiple>
        <va-collapse v-for="(route, idx) in items" :key="idx">
        <template #header>
            <va-sidebar-item :active="isRouteActive(route)" :to="route.children ? undefined : route.routeUrl">
            <va-sidebar-item-content>
                <font-awesome-icon class="va-sidebar-item__icon" :icon="route.meta.icon" />
                <va-sidebar-item-title>
                {{ route.displayName }}
                </va-sidebar-item-title>

                <va-icon v-if="route.children" :name="accordionValue[idx] ? 'expand_less' : 'expand_more'" />
            </va-sidebar-item-content>
            </va-sidebar-item>
        </template>
        <template v-for="(child, index) in route.children" :key="index">
            <va-sidebar-item :active="isRouteActive(child)" :to="child.routeUrl">
            <va-sidebar-item-content>
                <div class="va-sidebar-item__icon" />

                <va-sidebar-item-title>
                {{ child.displayName }}
                </va-sidebar-item-title>
            </va-sidebar-item-content>
            </va-sidebar-item>
        </template>
        </va-collapse>
    </va-accordion>
</template>

<script setup>
    defineProps({
      items: {
        type: Array,
        required: false,
        default: []
      }
    })

    const accordionValue = true
    
    function isRouteActive(item) {
        return item.name === useRoute().name
    }

</script>