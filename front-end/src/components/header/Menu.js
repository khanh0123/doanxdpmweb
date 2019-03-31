import React from "react";
import { MenuAction } from "../../actions"
import { Link } from 'react-router-dom';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';

class Menu extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data_menu: []
        }
        props.get_menu().then(res => {
            let data = res.payload.data;
            this.setState({ data_menu: data });
        })


    }

    render() {
        let { data_menu } = this.state;
        return (
            <div id="nav">
                <div id="nav-fixed">
                    <div className="container">
                        <div className="nav-logo">
                            <Link to="/" className="logo"><img width="114px" height="100px" src="/assets/img/logo.png" alt="" /></Link>
                        </div>
                        <ul className="nav-menu nav navbar-nav">
                            {data_menu.map(item => {
                                return <li key={item.id}><Link to={'/'+item.tag_slug}>{item.name}</Link></li>
                            })}
                            
                        </ul>
                    </div>
                </div>
            </div>
        );
    }

}
function mapStateToProps({ menu_results }) {
    return Object.assign({}, menu_results || {});
}

function mapDispatchToProps(dispatch) {
    let actions = bindActionCreators({
        get_menu: MenuAction.get_menu,
    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Menu));