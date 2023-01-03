<template>
  <div class="chat">
    <div class="row">
      <div class="flex xs12 md12">
        <div class="row">
          <div class="flex xs12 md4">
            <va-card>
              <va-card-content>
                <div class="row pr-2 pl-2 m-0 mt-0 mb-5">
                  <va-list fit>
                    <va-list-label>
                      Contacts
                    </va-list-label>
                    <va-list-item
                        class="list__item mb-2"
                        v-for="(contact, index) in contacts"
                        :key="index"
                        :to="'/chat/' + index"
                    >
                      <va-list-item-section avatar>
                        <va-avatar size="small">
                          <img :src="contact.img">
                        </va-avatar>
                      </va-list-item-section>

                      <va-list-item-section>
                        <va-list-item-label>
                          {{ contact.name }}
                        </va-list-item-label>

                        <!--<va-list-item-label caption>
                        {{ contact.address }}
                        </va-list-item-label> -->
                      </va-list-item-section>
                      <!--
                      <va-list-item-section icon>
                          <va-icon
                          name="remove_red_eye"
                          color="background-tertiary"
                          />
                      </va-list-item-section>
                      -->
                    </va-list-item>
                  </va-list>
                </div>
                <div class="row">
                  <va-list fit>
                    <va-list-label>
                      Channels
                    </va-list-label>
                  </va-list>
                </div>
              </va-card-content>
            </va-card>
          </div>
          <div class="flex xs12 md8">
            <router-view></router-view>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const contacts = ref([
  { name: 'Audrey Clay', address: '644 Vermont Court, Freelandville, Kentucky, 2619', img: 'https://randomuser.me/api/portraits/women/5.jpg' },
  { name: 'Aguirre Klein', address: '626 Carroll Street, Roulette, Ohio, 1477', img: 'https://randomuser.me/api/portraits/men/1.jpg' },
  { name: 'Tucker Kaufman', address: '887 Winthrop Street, Tryon, Florida, 3912', img: 'https://randomuser.me/api/portraits/men/3.jpg' },
  { name: 'Herbert Keller', address: '286 NW. Shore St.Longwood, FL 32779', img: 'https://randomuser.me/api/portraits/men/5.jpg' },
])
</script>

<style scoped>

</style>