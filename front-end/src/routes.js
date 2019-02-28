import Home from "./components/home/Home";
import Detail from "./components/detail/detail";
import Error from "./components/error/Error";

export default [
    {
        path: "/",
        component: Home,
        exact: true,
    },

    {
        path: "/detail/:path",
        component: Detail,
        // exact: false,
    },
    {
        path: "/:slug",
        component: Error,
        exact: true,
    }

];