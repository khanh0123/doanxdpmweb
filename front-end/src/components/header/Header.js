import React, { } from 'react';
// import { Link } from 'react-router-dom';
import Menu from './Menu';
// import cookie from "react-cookies";
// import LoginModal from "../popup/LoginModal";
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';

class Header extends React.Component {
    constructor(props) {
        super(props);
        this.state = {            

        };
    }

    componentDidMount() {

    }


    render() {
        return (
            <header id="header">
                <Menu />
            </header>

        )
    }
    
}

const mapStateToProps = ({ user_result }) => {
    return Object.assign({}, user_result || {});
}

const mapDispatchToProps = (dispatch) => {
    let actions = bindActionCreators({
    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Header));