<template>
    <div>
        <v-navigation-drawer v-model="drawer" app clipped color="primary" dark>
            <v-list dense>
                <v-list-item v-for="menu in mainItems" link :to="menu.link" :key="menu.id">
                    <v-list-item-action>
                        <v-icon>{{menu.icon}}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{menu.title}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                
                <v-list-group
                    v-for="item in items"
                    :key="item.title"
                    :prepend-icon="item.action"
                    no-action
                    active-class="black elevation-16  white--text"
                >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.title"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item
                        v-for="child in item.items"
                        :key="child.title"
                        link
                        :to="child.link"
                        active-class=" elevation-16  white--text"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="child.title"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

                <v-list-item  href="/logoutuser" >
                    <v-list-item-action>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app clipped-left color="primary" dark>
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>Jareer</v-toolbar-title>
        </v-app-bar>
    </div>
</template>

<script>
export default {
    props: {
        source: String
    },
    data: () => ({
        drawer: null,
        items: [
            {
                action: "mdi-star",
                items: [
                    { title: "Languages", link: "/languages" },
                    { title: "Straches", link: "/straches" },
                    { title: "Trousers", link: "/trousers" },
                    { title: "Detergent Types", link: "/types" },
                    { title: "Detergent Scents", link: "/scents" },
                    { title: "Temperatures", link: "/temperatures" },
                    { title: "Fabric Softener Type", link: "/fabrictypes" }
                ],
                title: "Modules"
            }
        ],
     mainItems:[
         {id:'1',title:'Dashboard',link:'/home',icon:'mdi-view-dashboard'},
         {id:'2',title:'User List',link:'/users',icon:'mdi-account'},
         {id:'3',title:'Product List',link:'/products',icon:'mdi-buffer'},
         {id:'4',title:'Order List',link:'/orders',icon:'mdi-newspaper'},
         {id:'5',title:'Order Status List',link:'/statuses',icon:'mdi-spotlight'},
     ]   
        
    }),
    created() {
       // this.$vuetify.theme.dark = true;
    }
};
</script>

<style>
.container-fluid {
    padding-left: 0px;
    padding-right: 0px;
}
</style>
