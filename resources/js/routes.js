import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent.vue";

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name: "home"
    }
];

const router = new VueRouter({
    mode: "history",
    routes,
})

export default router;