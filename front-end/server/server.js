import express from "express";
import path from "path";

import React from "react";
import { renderToString } from "react-dom/server";
import { StaticRouter, matchPath } from "react-router-dom";
import { Provider as ReduxProvider } from "react-redux";
import Helmet from "react-helmet";
import Layout from "../src/components/Layout";
import Error from "../src/components/error/Error";
import routes from "../src/routes";
import createStore, { initializeSession } from "../src/store/reducers";
import htmlTemplate from "./template";

const DEFAULT_PORT = parseInt(process.env.PORT, 3000) || 3000;
const app = express();
const version = "1.0.0"; 

// app.use(express.static(path.resolve(__dirname, "../src/assets")));
app.use(express.static(path.resolve(__dirname, "../src/assets")));
app.get("*", (req, res) => {

    if (req.url.indexOf('js') === -1 && req.url.indexOf('css') === -1) {
        const context = {};
        const store = createStore();

        store.dispatch(initializeSession());
        let match_path = {};
        routes
            .filter(route => matchPath(req.url, route)) // filter matching paths
            .map(route => {
                match_path = matchPath(req.url, route)
                match_path['fullUrl'] = req.protocol + '://' + req.get('host') + req.originalUrl
                match_path['fullPath'] = req.originalUrl
            }) // get params from route 


        const dataRequirements =
            routes
                .filter(route => matchPath(req.url, route)) // filter matching paths
                .map(route => route.component) // map to components
                .filter(comp => comp.serverFetch) // check if components have data requirement
                .map(comp => comp.serverFetch({ store: store, 'request': match_path }))



        Promise.all(dataRequirements).then(() => {
            
            
            const jsx = (
                <ReduxProvider store={store}>
                    <StaticRouter context={context} location={req.url}>
                        <Layout />
                    </StaticRouter>
                </ReduxProvider>
            );
            
            const reactDom = renderToString(jsx);
            const reduxState = store.getState();
            const helmetData = Helmet.renderStatic();
                                   


            res.writeHead(200, { "Content-Type": "text/html" });
            
            res.end(htmlTemplate(reactDom, reduxState, helmetData, version));
            
        }).catch(function (err) {
            // console.log(err.message); // some coding error in handling happened
            const jsx = (
                <Error />
            );
            const reactDom = renderToString(jsx);
            const reduxState = store.getState();
            const helmetData = Helmet.renderStatic();

            reduxState.isError = true;

            res.writeHead(500, { "Content-Type": "text/html" });
            res.end(htmlTemplate(reactDom, reduxState, helmetData, version));
        });

    } else {
        console.log("request js file");
    }

});

app.listen(DEFAULT_PORT);
console.log(`App is listening at Port ${DEFAULT_PORT}`);