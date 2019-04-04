import React from 'react';
import { Link } from 'react-router-dom';
import { custom_date } from "../helpers";
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import { PostAction, LoadingAction } from "../../actions";
import MostView from "../others/MostView";
import HotCategory from "../others/HotCategory";
// import Comment from "../comment";

class Detail extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data: '',
            id: '',
            slug: '',
            page: 1,
        }
    }
    async componentDidMount() {
        let { id, slug } = this.props.match.params;
        await this.setState({ id: id, slug: slug });
        let res = await this.props.get_detail_post(id, slug);
        this.setState({ data: res.payload.data });

    }
    async componentWillReceiveProps(nextProps) {
        let { id, slug } = nextProps.match.params;
        if (id != this.state.id) {
            await this.setState({ id: id, slug: slug });
            let res = await this.props.get_detail_post(id, slug);
            this.setState({ data: res.payload.data });
        }
    }
    render() {
        let { data } = this.state;

        return data != '' && (
            <React.Fragment>
                <header>
                    <div id="post-header" className="page-header">
                        <div className="background-img" style={{ backgroundImage: `url(${data.images})` }} />
                        <div className="container">
                            <div className="row">
                                <div className="col-md-10">
                                    <div className="post-meta">
                                        <Link className="post-category cat-2" to={`/${data.tag_slug}`}>{data.tag_name}</Link>
                                        <span className="post-date">{custom_date(data.created_at)}</span>
                                    </div>
                                    <h1>{data.title}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="page-header">
                        <div className="container">
                            <div className="row">
                                <div className="col-md-10">
                                    <ul className="page-header-breadcrumb">
                                        <li><Link to="/">Trang chủ</Link></li>
                                        <li>{data.tag_name}</li>
                                    </ul>
                                    <h1>{data.tag_name}</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                </header>
                <div className="section">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-8">
                                <div className="section-row sticky-container">
                                    <div className="main-post" style={{ overflowX: 'hidden' }}>
                                        <div contentEditable='true' dangerouslySetInnerHTML={{ __html: data.content }}></div>
                                    </div>
                                    <div className="post-shares sticky-shares">
                                        <a href="#" className="share-facebook"><i className="fa fa-facebook" /></a>
                                        <a href="#" className="share-twitter"><i className="fa fa-twitter" /></a>
                                        <a href="#" className="share-google-plus"><i className="fa fa-google-plus" /></a>
                                        <a href="#" className="share-pinterest"><i className="fa fa-pinterest" /></a>
                                        <a href="#" className="share-linkedin"><i className="fa fa-linkedin" /></a>
                                        <a href="#"><i className="fa fa-envelope" /></a>
                                    </div>
                                </div>

                            </div>
                            <div className="col-md-4">
                                <MostView />
                                <HotCategory />
                            </div>
                        </div>
                    </div>
                </div>

            </React.Fragment>
        ) || <div />
    }


}

const mapStateToProps = ({ post_results, loading_results }) => {
    return Object.assign({}, post_results, loading_results || {});
}

const mapDispatchToProps = (dispatch) => {
    let actions = bindActionCreators({
        get_detail_post: PostAction.get_detail_post,
        set_loading: LoadingAction.set_loading,

    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Detail));
