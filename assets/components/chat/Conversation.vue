<template>
    <va-card>
        <va-card-title>Chat</va-card-title>
        <va-card-content>
          <div class="va-chat">
              <div
                v-sticky-scroll="{
                  animate: true,
                  duration: 500,
                }"
                class="va-chat__body"
                :style="{ height: height }"
              >
                <div
                    v-for="(message, index) in state.messages"
                    :key="index" class="va-chat__message_content">
                  <va-avatar size="small">
                    <img src="https://randomuser.me/api/portraits/women/5.jpg">
                  </va-avatar>
                  <div
                    class="va-chat__message"
                    :style="{
                      backgroundColor: message.yours ? colors.primary : '#EBF1F4',
                    }"
                    :class="{ 'va-chat__message--yours': message.yours }"
                  >
                    <div style="display: flex; gap: 10px; margin-bottom: 2px;">
                      <span class="va-text-bold">Guillaume</span>
                      <span class="va-text-secondary">13:34</span>
                    </div>
                    <span class="va-chat__message-text" v-html="message.text"></span>
                  </div>
                </div>
              </div>
              <div class="va-chat__controls">
                <QuillEditor ref="editor" theme="snow"
                             v-model:content="inputMessage"
                             contentType="html"
                             :toolbar="[['bold', 'italic', 'underline','strike'],['link', 'image'],[{ 'list': 'ordered'}, { 'list': 'bullet' }],['blockquote', 'code-block']]"
                             :modules="modules"/>
                <!--
                <va-input
                  v-model="inputMessage"
                  placeholder="Type your message..."
                  class="va-chat__input mr-2"
                  @keypress.enter="sendMessage"
                />
                <va-button @click="sendMessage()">
                  Envoyer
                </va-button> -->
              </div>
          </div>
        </va-card-content>
    </va-card>
</template>

<script setup>
import {ref, reactive, watch} from 'vue'
import { useRoute } from 'vue-router'
import { useColors } from 'vuestic-ui'
import vStickyScroll from './StickyScroll'
import { QuillEditor, Quill } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import mention from 'quill-mention'
const { colors } = useColors()
const Keyboard  = Quill.import('modules/keyboard');
defineProps({
  height: {
    type: String,
    default: '25rem',
    require: false
  }
})

const state = reactive({ messages: [] })
const inputMessage = ref('')
let editor = ref(null);
const route = useRoute()

function sendMessage() {
    if (!inputMessage.value) {
      return
    }
    fetch('/publish/' + route.params.id, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({'message': inputMessage.value}),
    })
    inputMessage.value = ''
    editor.value.setHTML('')
}

function listenConversation(i) {
  const uri = '/conversations/' + i
  const mercureUrl = url + encodeURI(uri)
  const eventSource = new EventSource(mercureUrl)
  eventSource.onmessage = event => {
    state.messages.push({ text: (JSON.parse(event.data)).message, yours: false })
  }
}

const url = JSON.parse(document.getElementById("sse-url").textContent);
listenConversation(route.params.id)
watch(
    () => route.params.id,
    async newId => {
      state.messages = []
      listenConversation(newId)
    }
)
const atValues = [
  { id: 1, value: "Fredrik Sundqvist" },
  { id: 2, value: "Patrik Sjölin" }
];
const hashValues = [
  { id: 3, value: "Fredrik Sundqvist 2" },
  { id: 4, value: "Patrik Sjölin 2" }
];
const modules = [{
  name: 'mention',
  module: mention,
  options : {
    allowedChars: /^[A-Za-z\sÅÄÖåäö]*$/,
    mentionDenotationChars: ["@", "#"],
    source: function(searchTerm, renderList, mentionChar) {
      let values;

      if (mentionChar === "@") {
        values = atValues;
      } else {
        values = hashValues;
      }

      if (searchTerm.length === 0) {
        renderList(values, searchTerm);
      } else {
        const matches = [];
        for (let i = 0; i < values.length; i++)
          if (
              ~values[i].value.toLowerCase().indexOf(searchTerm.toLowerCase())
          )
            matches.push(values[i]);
        renderList(matches, searchTerm);
      }
    }
  }
},{
  name: 'keyboard',
  module: Keyboard,
  options: {
    bindings: {
      tab: false,
      handleEnter: {
        key: 13,
        handler() {
          sendMessage()
        }
      }
    }
  }
}]
</script>

<style lang="scss">
  // .chat {
  //   &__content {
  //     @include va-justify-center();
  //   }
  // }

  $chat-message-br: 0.875rem;

  .va-chat {
    width: 100%;

    &__body {
      min-height: 18.75rem;
      display: flex;
      flex-direction: column;
      margin-bottom: 1.5rem;
      overflow-y: auto;
    }

    &__message {
      position: relative;
      padding: 0.657rem 1.375rem;
      margin-bottom: 0.625rem;
      max-width: 70%;
      overflow-wrap: break-word;
      border-radius: 0.5rem;
      border-top-left-radius: 0;
      align-self: flex-start;
      // background-color: $light-gray2;

      &-text {
        display: block;
        transform: translateY(-2px);
      }

      &:last-child {
        margin-bottom: 0;
      }

      &--yours {
        color: white;
        align-self: flex-end;
        border-top-right-radius: 0;
        border-top-left-radius: 0.5rem;
      }
    }
    /**
    &__controls {
      display: flex;
      align-items: center;
    }*/
    &__controls {
      display: flex;
      flex-direction: column;
    }
    &__input {
      flex-grow: 1;
      margin-bottom: 0;
    }
    .va-chat__message_content{
      display: flex;
      gap: 0.5rem;
      margin-bottom: 3px;
    }
    /*.va-chat__message-text{
      overflow-x: auto;
    }*/
    .va-chat__message-text img{
      max-width: 100% !important;
    }
  }
</style>