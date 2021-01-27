import Index from "./components/dashboard/index.vue";

import User from "./components/user/index.vue";
import userEdit from "./components/user/edit.vue";
import userAdd from "./components/user/add.vue";

import languageList from "./components/langugage/list.vue";
import languageAdd from "./components/langugage/add.vue";
import languageEdit from "./components/langugage/edit.vue";

import strachList from "./components/strach/list.vue";
import strachAdd from "./components/strach/add.vue";
import strachEdit from "./components/strach/edit.vue";

import trouserList from "./components/trouser/list.vue";
import trouserAdd from "./components/trouser/add.vue";
import trouserEdit from "./components/trouser/edit.vue";

import typeList from "./components/detergenttype/list.vue";
import typeAdd from "./components/detergenttype/add.vue";
import typeEdit from "./components/detergenttype/edit.vue";

import scentList from "./components/detergentscent/list.vue";
import scentAdd from "./components/detergentscent/add.vue";
import scentEdit from "./components/detergentscent/edit.vue";

import temperatureList from "./components/temperature/list.vue";
import temperatureAdd from "./components/temperature/add.vue";
import temperatureEdit from "./components/temperature/edit.vue";

import fabrictypeList from "./components/fabrictype/list.vue";
import fabrictypeAdd from "./components/fabrictype/add.vue";
import fabrictypeEdit from "./components/fabrictype/edit.vue";

import productList from "./components/product/list.vue";
import productAdd from "./components/product/add.vue";
import productEdit from "./components/product/edit.vue";

import statusList from "./components/orderstatus/list.vue";
import statusAdd from "./components/orderstatus/add.vue";
import statusEdit from "./components/orderstatus/edit.vue";

import orderList from "./components/order/list.vue";
import orderAdd from "./components/order/add.vue";
import orderView from "./components/order/view.vue";

import NotFoundPage from "./components/notfound.vue";

export const routes = [
    {
        name: "home",
        path: "/home",
        component: Index
    },
    {
        path: "/users",
        component: User
    },
    {
        path: "/user/add",
        component: userAdd
    },
    {
        path: "/user/edit/:id?",
        component: userEdit
    },
    {
        path: "/languages",
        component: languageList
    },
    {
        path: "/languages/add",
        component: languageAdd
    },
    {
        path: "/languages/edit/:id?",
        component: languageEdit
    },
    {
        path: "/straches",
        component: strachList
    },
    {
        path: "/strach/add",
        component: strachAdd
    },
    {
        path: "/strach/edit/:id?",
        component: strachEdit
    },
    {
        path: "/trousers",
        component: trouserList
    },
    {
        path: "/trouser/add",
        component: trouserAdd
    },
    {
        path: "/trouser/edit/:id?",
        component: trouserEdit
    },
    {
        path: "/types",
        component: typeList
    },
    {
        path: "/type/add",
        component: typeAdd
    },
    {
        path: "/type/edit/:id?",
        component: typeEdit
    },
    {
        path: "/scents",
        component: scentList
    },
    {
        path: "/scent/add",
        component: scentAdd
    },
    {
        path: "/scent/edit/:id?",
        component: scentEdit
    },
    {
        path: "/temperatures",
        component: temperatureList
    },
    {
        path: "/temperature/add",
        component: temperatureAdd
    },
    {
        path: "/temperature/edit/:id?",
        component: temperatureEdit
    },
    {
        path: "/fabrictypes",
        component: fabrictypeList
    },
    {
        path: "/fabrictype/add",
        component: fabrictypeAdd
    },
    {
        path: "/fabrictype/edit/:id?",
        component: fabrictypeEdit
    },
    {
        path: "/products",
        component: productList
    },
    {
        path: "/product/add",
        component: productAdd
    },
    {
        path: "/product/edit/:id?",
        component: productEdit
    },
    {
        path: "/statuses",
        component: statusList
    },
    {
        path: "/orderstatus/add",
        component: statusAdd
    },
    {
        path: "/orderstatus/edit/:id?",
        component: statusEdit
    },
    {
        path: "/orders",
        component: orderList
    },
    {
        path: "/order/add",
        component: orderAdd
    },
    {
        path: "/order/view/:id?",
        component: orderView
    },
    {
        path: "*",
        component: NotFoundPage
    }
];
