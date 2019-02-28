import React from "react";
import { bindActionCreators } from 'redux';
import { connect } from "react-redux";
import { page_action, init_home_action } from "../../store/actions";
import Item from "../card/item";
// import { Link } from "react-router-dom";
// import { build_link, shootGa } from "../../helpers/common";
// import Banner from "../slider/Banner";
// import Item from "../slider/Item";
import create_helmet_tag from "../seo/Helmet";
// import config from "../../config";


class Home extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            data_home: [],
            page: 1,
            limit: 12,
            is_loadMore: false,
            is_loading: true,
        }
    }

    _checkGetData() {

    }
    componentWillMount(){
        // if (this.props[page_action.ACTION_GET_CONTENT_HOME]) {
        //     let data = this.props[page_action.ACTION_GET_CONTENT_HOME];
        //     this.setState({ data_home: data.data })
        // }
    }
    componentDidMount() {
        
        let { page, limit } = this.state;
        

        if (!this.props[page_action.ACTION_GET_CONTENT_HOME]) {
            this.props.get_content_home({ page: page, limit: limit })
                .then(res => res.payload.data)
                .then(payload => this.setState({
                    data_home: payload.success,
                    is_loading:false,
                    is_loadMore: (payload.success.length == 0 || payload.count < limit) ? false : true }))
                .catch(err => console.log(err))
        } else {
            let data = this.props[page_action.ACTION_GET_CONTENT_HOME];            
            this.setState({ 
                data_home: data.success,
                is_loading:false,
                is_loadMore: (data.length == 0 || data.count < limit) ? false : true })
        }
    }
    componentWillUnmount(){
        this.props.dispatch({type:page_action.ACTION_GET_CONTENT_HOME,payload:{}});
        this.setState({data_home:[]});
            
    }

    loadMore() {
        let { page, limit , data_home } = this.state;
        
        this.setState({is_loadMore:false,is_loading:true});
        this.props.get_content_home({ page: page + 1, limit: limit })
            .then(res => res.payload.data)
            .then(data => this.setState({
                        page:page+1,
                        data_home: data_home.concat(data.success), 
                        is_loading:false,
                        is_loadMore: (data.success.length == 0 || data.count < limit) ? false : true })
            )
            .catch(err => console.log(err))
    }

    render() {
        let data_home = this.state.data_home.length > 0 ? this.state.data_home : (this.props[page_action.ACTION_GET_CONTENT_HOME] ? this.props[page_action.ACTION_GET_CONTENT_HOME]['success'] : []);
        
        return (
            
            <React.Fragment>
            {create_helmet_tag('home')}
                {/* <div className="slider" /> */}
                <section className="blog-area section">
                    <div className="container">
                        <div className="row">
                            {data_home.length > 0 && data_home.map((item, i) => {
                                return (<div className="col-lg-4 col-md-6" key={i}>
                                    <Item data={item} />
                                </div>)
                            })}

                        </div>
                        {this.state.is_loadMore &&
                            <a className="load-more-btn" href="javascript:void(0)" onClick={this.loadMore.bind(this)}><b>Thêm tin</b></a>
                        }
                        {this.state.is_loading &&
                            <div className="fa-3x">
                                <i className="fas fa-spinner fa-pulse"></i>
                            </div>
                        }
                    </div>
                </section>
            </React.Fragment>

        )
    }
}

Home.serverFetch = init_home_action.init_home;

const mapStateToProps = ({page_results}) => {

    // return {
    //     page_results: {
    //         GET_CONTENT_HOME:state.page_results.GET_CONTENT_HOME
    //     },
    // }
    return Object.assign({}, page_results || {});
}

function mapDispatchToProps(dispatch) {

    let actions = bindActionCreators(
        Object.assign({},
            page_action
        ), dispatch);

    return { ...actions, dispatch };
}

export default connect(mapStateToProps, mapDispatchToProps)(Home);
