require("./bootstrap");

// import { createApp } from 'vue'
// import HelloWorld from './pages/Welcome.vue'
// const app = createApp({})
// app.component('hello-world', HelloWorld)
// app.component('App', HelloWorld)
// app.mount('#app')

import { createApp } from "vue";
import { createBootstrap } from 'bootstrap-vue-next'
import { createRouter, createWebHistory } from "vue-router";
import MyLayout from "./components/Layout.vue";
import routes from "./routes";


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

const app = createApp({});
app.use(router);
app.use(createBootstrap({components: true, directives: true}))
app.component('App', MyLayout)
app.mount('#app');
