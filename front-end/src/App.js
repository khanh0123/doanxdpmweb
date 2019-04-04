import React from 'react';
import ReactDOM from "react-dom";
import promise from 'redux-promise';
import reducers from './reducers';
import { Route, Switch, BrowserRouter as Router } from 'react-router-dom';
import { applyMiddleware, createStore } from 'redux';
import { Provider } from 'react-redux';
import routes from './setup/routes';
import Layout from "./components/layout";

const createStoreWithMiddleware = applyMiddleware(promise)(createStore);

ReactDOM.render(
    <Provider store={createStoreWithMiddleware(reducers)}>
        <Router >
            <Layout>
                <Switch>
                    {routes.map((route,i) => {
                        return <Route key={i} exact path={route.path} component={route.component} />
                    })}

                </Switch>
            </Layout>
        </Router>
    </Provider>
    , document.getElementById('root')
);