<template>
    <div class="app-navbar-actions">
        <div class="profile-dropdown-wrapper">
            <va-dropdown v-model="isShown" class="profile-dropdown" stick-to-edges placement="bottom" :offset="[13, 0]">
                <template #anchor>
                    <span class="profile-dropdown__anchor">
                    <span>{{ userName }}</span>
                    <font-awesome-icon class="px-2" :icon="isShown ? 'fa-solid fa-angle-up' : 'fa-solid fa-angle-down'" :color="colors.primary" />
                    </span>
                </template>
                <va-dropdown-content class="profile-dropdown__content">
                    <va-list-item class="pa-2">
                        <router-link class="profile-dropdown__item" to="/profile">My profile</router-link>
                    </va-list-item>
                    <va-list-item class="pa-2">
                      <router-link class="profile-dropdown__item" to="/logout">Logout</router-link>
                    </va-list-item>
                </va-dropdown-content>
            </va-dropdown>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { useColors } from 'vuestic-ui'
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    const { colors } = useColors()
    const isShown = ref(false)

    defineProps({
      userName: {
        required: false,
        type: String,
        default: ''
      }
    })

</script>

<style lang="scss">
  .app-navbar-actions {
    display: flex;
    align-items: center;

    .va-dropdown__anchor {
      color: var(--va-primary);
      fill: var(--va-primary);
    }

    &__item {
      padding: 0;
      margin-left: 1.25rem;
      margin-right: 1.25rem;

      svg {
        height: 24px;
      }

      &:last-of-type {
        margin-right: 0;
      }

      &--profile {
        display: flex;
        justify-content: center;
        margin: auto 0 auto 1.25rem;
      }

      .va-dropdown-content {
        background-color: var(--va-white);
      }

      @media screen and (max-width: 640px) {
        margin-right: 0;

        &:first-of-type {
          margin-left: 0;
        }

        &--profile {
          position: absolute;
          right: 0.75rem;
          top: 1.25rem;
          height: fit-content;
          margin: auto;
        }
      }
    }
  }
  .profile-dropdown {
    cursor: pointer;

    &__anchor {
      display: inline-block;
    }

    &__item {
      display: block;
      color: var(--va-gray);

      &:hover,
      &:active {
        color: var(--va-primary);
      }
    }
  }
</style>