import { createRouter, createWebHashHistory } from 'vue-router'
import AppLayout from './layouts/Applayout.vue'

const routes = [{
    path: '/',
    name: 'root',
    component: AppLayout,
    redirect: '/dashboard',
    children: [
        { path: '/dashboard', name: 'dashboard', component: () => import('./components/dashboard/Dashboard.vue')},
        { path: '/chat', name: 'chat', component: () => import('./components/chat/Chat.vue'), children: [
                { path: '/chat/:id', name: 'conversation', component: () => import('./components/chat/Conversation.vue')}
            ]},
    ]
}]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router