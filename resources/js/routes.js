import Index from "./components/dashboard/index.vue";

import placeList from "./components/place/index.vue";
import placeAdd from "./components/place/add.vue";
import placeEdit from "./components/place/edit.vue";

import NotFoundPage from "./components/notfound.vue";

export const routes = [
    {
        name: "home",
        path: "/home",
        component: Index
    },
    {
        path: "/places",
        component: placeList
    },
    {
        path: "/place/add",
        component: placeAdd
    },
    {
        path: "/place/edit/:id?",
        component: placeEdit
    },
    {
        path: "*",
        component: NotFoundPage
    }
];
