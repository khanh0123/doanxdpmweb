import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router } from "react-router-dom";
import { Provider as ReduxProvider } from "react-redux";
import Layout from "./components/Layout";
import Error from "./components/error/Error";
import createStore from "./store/reducers/";


const store = createStore(window.__REDUX_DATA__ || "");
let jsx;

if(window.__REDUX_DATA__ && window.__REDUX_DATA__.isError === true){
	
	jsx = (
	    <Error />
	);
} else {
	jsx = (
	    <ReduxProvider store={store}>
	        <Router>
	            <Layout />
	        </Router>
	    </ReduxProvider>
	);
}

const app = document.getElementById("app");
ReactDOM.hydrate(jsx, app);
