// import React , {  lazy } from 'react';
import Home from "../components/Home";
import Detail from "../components/details/Detail";
import Filters from "../components/filters/Filters";
// import Search from "../components/filters/Search";
import NotFound from "../components/Notfound/";
export default [
    {
        path:"/",
        component:Home,
        exact:true
    },
    {
        path:"/chi-tiet/:slug/:id([0-9]+)",
        component:Detail,
        exact:true
        
    },
    {
        path:"/:tag([a-zA-Z-]+)",
        component:Filters,
        exact:false
    },
    {
        path: '*',
        component: NotFound,
        exact:false
    }
]