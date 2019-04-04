import React from 'react'
import { Link } from 'react-router-dom';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import { LoadingAction } from "../../actions"

class NotFound extends React.Component {
    constructor(props) {
        super(props);
    }
    render(){
        this.props.set_loading(false)
        return<div className="inner-page">
        <div className="error-page">
            <div className="error-bg">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div className="error-content text-center">
                                <h2><span>404</span></h2>
                                <ul>
                                    <li><span>Đường dẫn không tồn tại</span></li>
                                </ul>
                                <p>Trang bạn đang tìm kiếm không tồn tại. Vui lòng kiểm tra lại đường dẫn và thử lại.</p>
                                <div className="buttons">
                                    <Link to="/" className="btn btn-button green-bg button-1">Quay lại trang chủ</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    }
}

function mapStateToProps({  loading_results }) {
    return Object.assign({},  loading_results || {});
}

function mapDispatchToProps(dispatch) {
    let actions = bindActionCreators({
        set_loading: LoadingAction.set_loading,
    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(NotFound));