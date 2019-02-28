import React from "react";
import { bindActionCreators } from 'redux';
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import { detail_action, init_home_action } from "../../store/actions";
import create_helmet_tag from "../seo/Helmet";
import config from "../../config";


class Detail extends React.Component {

    constructor(props) {
        super(props)
        this.state = {
            data: ''
        }
    }


    componentDidMount() {

        if (!this.props[detail_action.ACTION_GET_CONTENT_DETAIL]) {
            let path = this.props.location.pathname.replace("/detail/", "");
            this.props.get_content_detail({ path: path })
                .then(res => res.payload.data)
                .then(payload => this.setState({ data: payload.success }))
                .catch(err => console.log(err))
        } else {
            let data = this.props[detail_action.ACTION_GET_CONTENT_DETAIL]['success'];
            this.setState({ data: data })
        }
    }
    componentWillReceiveProps(nextProps) {

        if (this.props.location.pathname !== nextProps.location.pathname) {
            let path = nextProps.location.pathname.replace("/detail/", "");
            nextProps.get_content_detail({ path: path })
                .then(res => res.payload.data)
                .then(payload => this.setState({ data: payload.data }))
                .catch(err => console.log(err))
        }

    };

    componentWillUnmount() {
        this.props.dispatch({ type: detail_action.ACTION_GET_CONTENT_DETAIL, payload: {} });
        this.setState({ data: [] });
    }

    createMarkup(content) {
        return { __html: content };
    }



    render() {
        let data = this.state.data !== '' ? this.state.data : (this.props[detail_action.ACTION_GET_CONTENT_DETAIL] ? this.props[detail_action.ACTION_GET_CONTENT_DETAIL]['success'] : '');


        return (
            <React.Fragment>
                {create_helmet_tag("detail", data)}
                <div className="slider" style={{ backgroundImage: "url(/images/banner-1.jpg)" }}>
                    <div className="display-table  center-text">
                        <h1 className="title display-table-cell"><b>TIN TỨC</b></h1>
                    </div>
                </div>{/* slider */}
                <section className="post-area section">
                    <div className="container">
                        {data != '' &&
                            <div className="row">
                                <div className="col-lg-8 col-md-12 no-right-padding">
                                    <div className="main-post">
                                        <div className="blog-post-inner">
                                            <div className="post-info">
                                                <div className="left-area">
                                                    <a className="avatar" href="javascript:void(0)"><img src="/images/avatar-1-120x120.jpg" alt="Profile Image" /></a>
                                                </div>
                                                <div className="middle-area">
                                                    <a className="name" href="javascript:void(0)"><b>{data.author} </b></a>
                                                    <h6 className="date">{data.timeCreated}</h6>
                                                </div>
                                            </div>{/* post-info */}
                                            <h3 className="title"><a href="javascript:void(0)"><b>{data.title}</b></a></h3>
                                            <div dangerouslySetInnerHTML={this.createMarkup(data.content)} />
                                            <ul className="tags">
                                                {
                                                    data.tags.map((tag,i) => {
                                                        return <li key={i}><a href="javascript:void(0)">{tag}</a></li>
                                                    })
                                                }
                                            </ul>
                                        </div>{/* blog-post-inner */}
                                        <div className="post-icons-area">
                                            <ul className="post-icons">
                                                <li><a href="javascript:void(0)"><i className="ion-heart" />57</a></li>
                                                <li><a href="javascript:void(0)"><i className="ion-chatbubble" />6</a></li>
                                                <li><a href="javascript:void(0)"><i className="ion-eye" />138</a></li>
                                            </ul>
                                            <ul className="icons">
                                                <li>Chia sẻ : </li>
                                                <li><a href="javascript:void(0)"><i className="ion-social-facebook" /></a></li>
                                                <li><a href="javascript:void(0)"><i className="ion-social-twitter" /></a></li>
                                                <li><a href="javascript:void(0)"><i className="ion-social-pinterest" /></a></li>
                                            </ul>
                                        </div>
                                        <div className="post-footer post-info">
                                            <div className="left-area">
                                                <a className="avatar" href="javascript:void(0)"><img src="/images/avatar-1-120x120.jpg" alt="Profile Image" /></a>
                                            </div>
                                            <div className="middle-area">
                                                <a className="name" href="javascript:void(0)"><b>{data.author} </b></a>
                                                <h6 className="date">{data.timeCreated}</h6>
                                            </div>
                                        </div>{/* post-info */}
                                    </div>{/* main-post */}
                                </div>{/* col-lg-8 col-md-12 */}
                                <div className="col-lg-4 col-md-12 no-left-padding">
                                    <div className="single-post info-area">
                                        <div className="sidebar-area about-area">
                                            <h4 className="title"><b>Về chúng tôi</b></h4>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus repellat voluptates rerum sunt, blanditiis nostrum.</p>
                                        </div>
                                        <div className="sidebar-area subscribe-area">
                                            <h4 className="title"><b>Đăng ký nhận tin</b></h4>
                                            <div className="input-area">
                                                <form>
                                                    <input className="email-input" type="text" placeholder="Vui lòng nhập email" />
                                                    <button className="submit-btn" type="submit"><i className="icon ion-ios-email-outline" /></button>
                                                </form>
                                            </div>
                                        </div>{/* subscribe-area */}
                                        <div className="tag-area">
                                            <h4 className="title"><b>Từ khóa</b></h4>
                                            <ul>
                                                {
                                                    data.tags.map((tag,i) => {
                                                        return <li key={i}><a href="javascript:void(0)">{tag}</a></li>
                                                    })
                                                }
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        }
                    </div>
                </section>
            </React.Fragment>

        )
    }
}

Detail.serverFetch = init_home_action.init_detail;

const mapStateToProps = ({ detail_results }) => {
    // return {
    //     detail_results: state.detail_results.GET_CONTENT_DETAIL,
    // }
    return Object.assign({}, detail_results || {});
}

function mapDispatchToProps(dispatch) {

    let actions = bindActionCreators(
        Object.assign({},
            init_home_action,
            detail_action
        ), dispatch);

    return { ...actions, dispatch };
}


export default connect(mapStateToProps, mapDispatchToProps)(Detail);
