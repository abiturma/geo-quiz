import Vue from 'vue';
import Router from 'vue-router';
import BaseLayout from "@/layouts/BaseLayout";
import HomePage from "@/pages/HomePage";

Vue.use(Router)

const router = new Router({
    mode: 'history',

    routes: [

        {
            path: '/',
            component: BaseLayout,
            children: [

                {
                    path: '/',
                    name: 'home',
                    component: HomePage,
                }



            ],
        },




    ]
})

export default router;
