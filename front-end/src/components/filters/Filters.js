import React from 'react';
import { Link } from 'react-router-dom';
import { PostAction } from "../../actions";
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import Pagination from "react-js-pagination";
import queryString from 'query-string';
import { custom_date } from "../helpers";
import MostView from "../others/MostView";
import HotCategory from "../others/HotCategory";


class Filters extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data: [],
            tag: '',
            page: 1,
            per_page: 10,
            total: 0,

        }
        this._handlePageChange = this._handlePageChange.bind(this);
        this._resetDataPage = this._resetDataPage.bind(this);
        this._getDataPage = this._getDataPage.bind(this);
    }



    async componentDidMount() {
        let { tag } = this.props.match.params;
        let { page } = queryString.parse(this.props.location.search);
        if (!page) page = 1;
        await this.setState({ tag: tag, page: page });
        await this._getDataPage(page);


    }
    async componentWillReceiveProps(nextProps) {
        let { tag } = nextProps.match.params;
        let { page } = queryString.parse(nextProps.location.search);
        if (!page) page = 1;
        if (tag != this.state.tag) {
            await this.setState({ tag: tag, page: page });
            await this._getDataPage(page);
        }




    }


    render() {
        let { data, per_page, total } = this.state;
        let { page } = queryString.parse(this.props.location.search);
        page = !page ? 1 : parseInt(page);
        return data.length > 0 && (
            <React.Fragment>
                <header>
                    <div className="page-header">
                        <div className="container">
                            <div className="row">
                                <div className="col-md-10">
                                    <ul className="page-header-breadcrumb">
                                        <li><Link to="/">Trang chủ</Link></li>
                                        <li>{data[0].tag_name}</li>
                                    </ul>
                                    <h1>{data[0].tag_name}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div className="section">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-8">
                                <div className="row">
                                    {data.map((post, i) => {
                                        let html = [];
                                        if (i == 0) html.push(<div className="col-md-12" key={post.id}>
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

                                        </div>)
                                        else if (i < 3) html.push(<div className="col-md-6" key={post.id}>
                                            <div className="post">
                                                <Link className="post-img" to={`/chi-tiet/${post.slug}/${post.id}`}><img src={post.images} alt={post.title} /></Link>
                                                <div className="post-body">
                                                    <div className="post-meta">
                                                        <Link className="post-category cat-2" to={`/${post.tag_slug}`}>{post.tag_name}</Link>
                                                        <span className="post-date">{custom_date(post.created_at)}</span>
                                                    </div>
                                                    <h3 className="post-title"><Link to={`/chi-tiet/${post.slug}/${post.id}`}>{post.title}</Link></h3>
                                                </div>
                                            </div>

                                        </div>)
                                        else html.push(<div className="col-md-12" key={post.id}>
                                            <div className="post post-row">
                                                <Link className="post-img" to={`/chi-tiet/${post.slug}/${post.id}`}><img src={post.images} alt={post.title} /></Link>
                                                <div className="post-body">
                                                    <div className="post-meta">
                                                        <Link className="post-category cat-2" to={`/${post.tag_slug}`}>{post.tag_name}</Link>
                                                        <span className="post-date">{custom_date(post.created_at)}</span>
                                                    </div>
                                                    <h3 className="post-title"><Link to={`/chi-tiet/${post.slug}/${post.id}`}>{post.title}</Link></h3>
                                                </div>
                                            </div>

                                        </div>)
                                        return html;
                                    })}
                                    <div className="col-md-12">
                                        <div className="section-row" style={{ textAlign: 'center' }}>
                                            <Pagination
                                                activePage={page}
                                                itemsCountPerPage={per_page}
                                                totalItemsCount={total}
                                                pageRangeDisplayed={5}
                                                onChange={this._handlePageChange}
                                            />
                                        </div>
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

    _getDataPage = async (page) => {
        const { tag, per_page } = this.state;
        let p = page != '' ? page : this.state.page;
        if (tag != '') {
            let condition = {
                page: p,
                tag_slug: tag,
                limit: per_page,
            }
            let data = await this.props.get_posts(condition);
            let res = data.payload.data;
            await this.setState({
                data: res.data,
                total: res.total,
                per_page: res.per_page,
            });
            window.scrollTo(0, 0);
        }
    }
    _handlePageChange = async (pageNumber) => {
        await this.setState({ page: pageNumber });
        this.props.history.push({
            pathname: window.location.pathname,
            search: "?" + new URLSearchParams({ page: pageNumber }).toString()
        })
        this._getDataPage(pageNumber);
    }
    _resetDataPage = async () => {
        await this.setState({
            data: [],
            tag: '',
            page: 1,
            per_page: 10,
            total: 0,
        });
    }
}
const mapStateToProps = ({ post_results }) => {
    return Object.assign({}, post_results || {});
}

const mapDispatchToProps = (dispatch) => {
    let actions = bindActionCreators({
        get_posts: PostAction.get_posts,

    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Filters));