/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'vuestic-ui/css'

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {faGauge, faAngleDown, faAngleUp, faMessage} from "@fortawesome/free-solid-svg-icons";
library.add(faGauge)
library.add(faAngleDown)
library.add(faAngleUp)
library.add(faMessage)

import { createApp } from 'vue'
import { createVuestic } from 'vuestic-ui'

import App from './App.vue'
import router from "./router"

createApp(App)
    .use(createVuestic())
    .use(router)
    .mount('#app')
