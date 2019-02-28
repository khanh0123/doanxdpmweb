import React from "react";
import { Switch, Route } from "react-router-dom";
import Header from "./header/Header";
import Footer from "./footer/Footer";
import routes from "../routes";
import { withRouter } from "react-router";

class Layout extends React.Component {
    constructor(props){
        super(props);
    }
    componentDidUpdate(prevProps) {
        
        if (this.props.location.pathname !== prevProps.location.pathname) {
            window.scrollTo(0, 0);
        }
    }
    render() {

        return (
            <React.Fragment>
                <Header />
                <Switch>
                    {routes.map(route => <Route key={route.path} {...route} />)}
                </Switch>
                <Footer/>
            </React.Fragment>
        );
    }
}

export default withRouter(Layout);

