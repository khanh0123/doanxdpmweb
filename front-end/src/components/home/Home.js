import React from "react";
import { custom_date } from "../helpers";
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import { PostAction, LoadingAction } from "../../actions";
import MostView from "../others/MostView";
import HotCategory from "../others/HotCategory";
import { Link } from "react-router-dom";

class Home extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            new_posts: [],
            anm_posts: [],
            hot_posts: [],
            most_read_posts: [],
        };

    }
    componentDidMount() {
        Promise.all([
            this._get_post('new_posts'),
            this._get_post('anm_posts')
        ]).then(() => {
            this.props.set_loading(false);
        }).catch(() => {
            this.props.set_loading(false);
        });
        this._get_post('hot_posts')
        this._get_post('most_read_posts')
    }
    _get_post = async (type) => {
        switch (type) {
            case 'new_posts':
                let condition = {
                    limit: 2,
                    is_new: 1,
                    is_hot: 0,
                };
                await this.props.get_posts(condition).then((res) => {
                    let r = res.payload.data.data;
                    this.setState({ new_posts: r });
                });
                break;
            case 'anm_posts':
                condition = {
                    limit: 6,
                    tag_slug: 'an-ninh-mang',
                    orderBy: 'view',
                };
                await this.props.get_posts(condition).then((res) => {
                    let r = res.payload.data.data;
                    this.setState({ anm_posts: r });
                });
                break;
            case 'hot_posts':
                condition = {
                    limit: 7,
                    is_hot: 1,
                };
                await this.props.get_posts(condition).then((res) => {
                    let r = res.payload.data.data;
                    this.setState({ hot_posts: r });
                });
                break;

            default:
                break;
        }
    }
    componentWillReceiveProps(nextProps) {


    }
    render() {
        let { new_posts, anm_posts, hot_posts } = this.state;


        return (
            <React.Fragment>
                <div className="section">
                    <div className="container">
                        <div className="row">
                            {new_posts.map((post) => {
                                return <div className="col-md-6" key={post.id}>
                                    <div className="post post-thumb">
                                        <Link className="post-img" to={`/chi-tiet/${post.slug}/${post.id}`}><img src={post.images} alt={post.title} /></Link>
                                        <div className="post-body">
                                            <div className="post-meta">
                                                <Link className="post-category cat-2" to={`/${post.tag_slug}`}>{post.tag_name}</Link>
                                                <span className="post-date">{custom_date(post.created_at)}</span>
                                            </div>
                                            <h3 className="post-title"><Link to={`/chi-tiet/${post.slug}/${post.id}`}>{post.title}</Link></h3>
                                        </div>
                                    </div>
                                </div>
                            })}
                        </div>
                        <div className="row">
                            <div className="col-md-12">
                                <div className="section-title">
                                    <h2>Chủ đề HOT</h2>
                                </div>
                            </div>
                            {anm_posts.map((post, i) => {

                                let html = [];
                                html.push(<div className="col-md-4" key={post.id}>
                                    <div className="post">
                                        <Link className="post-img" to={`/chi-tiet/${post.slug}/${post.id}`}><img src={post.images} alt={post.title} /></Link>
                                        <div className="post-body">
                                            <div className="post-meta">
                                                <Link className="post-category cat-1" to={`/${post.tag_slug}`}>{post.tag_name}</Link>
                                                <span className="post-date">{custom_date(post.created_at)}</span>
                                            </div>
                                            <h3 className="post-title"><Link to={`/chi-tiet/${post.slug}/${post.id}`}>{post.title}</Link></h3>
                                        </div>
                                    </div>
                                </div>)
                                if ((i + 1) % 3 == 0) html.push(<div className="clearfix visible-md visible-lg" key={i}></div>);
                                return html;
                            })}



                        </div>
                        <div className="row">
                            <div className="col-md-8">
                                <div className="row">
                                    {hot_posts.length > 0 &&
                                        <div className="col-md-12">
                                            <div className="post post-thumb">
                                                <Link className="post-img" to={`/chi-tiet/${hot_posts[0].slug}/${hot_posts[0].id}`}><img src={hot_posts[0].images} alt={hot_posts[0].title} /></Link>
                                                <div className="post-body">
                                                    <div className="post-meta">
                                                        <Link className="post-category cat-2" to={`/${hot_posts[0].tag_slug}`}>{hot_posts[0].tag_name}</Link>
                                                        <span className="post-date">{custom_date(hot_posts[0].created_at)}</span>
                                                    </div>
                                                    <h3 className="post-title"><Link to={`/chi-tiet/${hot_posts[0].slug}/${hot_posts[0].id}`}>{hot_posts[0].title}</Link></h3>
                                                </div>
                                            </div>
                                        </div>
                                    }
                                    {hot_posts.map((post, i) => {
                                        let html = [];
                                        if (i == 0) return html;
                                        html.push(<div className="col-md-6" key={post.id}>
                                            <div className="post">
                                                <Link className="post-img" to={`/chi-tiet/${post.slug}/${post.id}`}><img src={post.images} alt={post.title} /></Link>
                                                <div className="post-body">
                                                    <div className="post-meta">
                                                        <Link className="post-category cat-4" to={`/${post.tag_slug}`}>{post.tag_name}</Link>
                                                        <span className="post-date">{custom_date(post.created_at)}</span>
                                                    </div>
                                                    <h3 className="post-title"><Link to={`/chi-tiet/${post.slug}/${post.id}`}>{post.title}</Link></h3>
                                                </div>
                                            </div>
                                        </div>);
                                        if (i % 2 == 0) html.push(<div key={i} className="clearfix visible-md visible-lg" />);
                                        return html;
                                    })}


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
        )
    }



}
function mapStateToProps({ post_results, loading_results, menu_results }) {
    return Object.assign({}, post_results, loading_results, menu_results || {});
}

function mapDispatchToProps(dispatch) {
    let actions = bindActionCreators({
        get_posts: PostAction.get_posts,
        set_loading: LoadingAction.set_loading,

    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Home));
