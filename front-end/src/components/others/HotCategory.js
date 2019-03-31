import React from "react";
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import { MenuAction } from "../../actions";
import { Link } from 'react-router-dom';

class HotCategory extends React.Component {
    constructor(props) {
        super(props);

    }


    componentWillReceiveProps(nextProps) {


    }
    render() {
        let menu = this.props[MenuAction.ACTION_GET_MENU];

        return (

            <div className="aside-widget">
                <div className="section-title">
                    <h2>Danh mục hot</h2>
                </div>
                <div className="category-widget">
                    <ul>
                        {menu && menu.map((m) => {
                            return <li key={m.id}><Link to={`${m.tag_slug}`} className="cat-1">{m.tag_name}<span>{m.num_post}</span></Link></li>
                        })}

                    </ul>
                </div>
            </div>

        )
    }



}
function mapStateToProps({ menu_results }) {
    return Object.assign({}, menu_results || {});
}

function mapDispatchToProps(dispatch) {
    let actions = bindActionCreators({

    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(HotCategory));
