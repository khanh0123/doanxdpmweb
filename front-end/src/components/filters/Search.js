import React from 'react';
import { Link } from 'react-router-dom';
// import SliderScroll from "../sliders/SliderScroll";
// import FacebookProvider, { Comments } from 'react-facebook';
import { getMovie } from "../helpers";
import { MovieAction, LoadingAction } from "../../actions"
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
// import config from "../../config";
import SlideItem from "../Sliders/SlideItem";
import SliderScroll from "../sliders/SliderScroll";
import Pagination from "react-js-pagination";
import queryString from 'query-string';


class Search extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data: [],
            keyword: '',
            page: 1,
            per_page: 12,
            total: 0,
            hot_series_movies: [],
            hot_retail_movies: [],
        }
        this._handlePageChange = this._handlePageChange.bind(this);
        this._resetDataPage = this._resetDataPage.bind(this);
        this._getDataPage = this._getDataPage.bind(this);
    }



    async componentDidMount() {
        let { page, q } = queryString.parse(this.props.location.search);
        if (!page) page = 1;
        await this.setState({ page: page, keyword: q });
        try {
            await this._getDataPage(page);
            await this.props.set_loading(false);
        } catch (error) {
            await this.props.set_loading(false);
        }
        getMovie(this, this.props, 'hot_series_movies', MovieAction);
        getMovie(this, this.props, 'hot_retail_movies', MovieAction);

    }
    async componentWillReceiveProps(nextProps) {
        let { page, q } = queryString.parse(nextProps.location.search);
        if (q && q !== this.state.keyword && this.props.location.search != nextProps.location.search) {
            await this._resetDataPage();
            await this.setState({ page: page, keyword: q });
            try {
                await this._getDataPage();
                await this.props.set_loading(false);
            } catch (error) {
                await this.props.set_loading(false);
            }
        }


    }


    render() {
        let { data, keyword, hot_series_movies, hot_retail_movies } = this.state;
        let { page } = queryString.parse(this.props.location.search);
        page = !page ? 1 : parseInt(page);



        return (
            <React.Fragment>
                <div className="breadcrumbs">
                    <div className="container">
                        <ul className="breadcrumb">
                            <li><Link to="/"><span className="fa fa-home" /> Trang chủ</Link></li>
                            <li><Link to="/tim-kiem"><span className="fa fa-home" /> Tìm kiếm</Link></li>
                            {this._renderBreadcrumbs()}
                        </ul>
                    </div>
                </div>
                <div className="inner-page details-page filter-page">
                        <div className="container">
                            <div className="row" >

                                <div className="col-lg-9 col-md-9" style={{ marginTop: '2em', display: 'inline-block', }}>
                                    {data.length > 0 &&
                                        (
                                            <React.Fragment>
                                                {data.map((item, i) => {
                                                    return (
                                                        <div className="owl-item cloned col-lg-3 col-xs-6" key={item.id}>
                                                            <SlideItem item={item} />
                                                        </div>
                                                    )
                                                })}

                                                <div className="text-center">
                                                    <Pagination
                                                        activePage={page}
                                                        itemsCountPerPage={10}
                                                        totalItemsCount={this.state.total}
                                                        pageRangeDisplayed={5}
                                                        onChange={this._handlePageChange}
                                                    />
                                                </div>
                                            </React.Fragment>
                                        )
                                        ||
                                        <h3 style={{ textAlign: "center", color: "black", margin: "1em 0" }}>Không có kết quả</h3>
                                    }

                                </div>
                                <div className="col-lg-3 col-md-3 hidden-xs">
                                    <SliderScroll title="Phim Lẻ Hot" data={hot_retail_movies} />
                                    <SliderScroll title="Phim Bộ Hot" data={hot_series_movies} />
                                </div>
                            </div>
                        </div>
                </div>
            </React.Fragment>
        )
    }
    _renderBreadcrumbs = () => {
        let data = [];
        data.push(<li key={100}>{`Từ khóa: ${this.state.keyword}`}</li>)
        // for (let i = 0; i < tags.length; i++) {
        //     for (let j = 0; j < tags_info.length; j++) {
        //         if(tags_info[j].slug == tags[i]) {
        //             if(i == tags.length - 1)
        //                 data.push(<li key={i}>{tags_info[j].name}</li>)
        //             else data.push(<li key={i}><Link to={`/${tags[i]}`}> {tags_info[j].name}</Link></li>)
        //         }

        //     }

        // }
        return data;
    }
    _getDataPage = async (page) => {
        let { keyword } = this.state;
        let p = page != '' ? page : this.state.page;
        if (keyword) {
            let data = await this.props.get_movie_search(keyword, p);
            let res = data.payload.data;
            await this.setState({
                data: res.data,
                total: res.total,
                per_page: res.per_page,
            });
        }
    }
    _handlePageChange = async (pageNumber) => {
        await this.setState({ page: pageNumber });
        let { keyword } = this.state;
        this.props.history.push({
            pathname: window.location.pathname,
            search: "?" + new URLSearchParams({ q: keyword, page: pageNumber }).toString()
        })
        this._getDataPage(pageNumber);
    }
    _resetDataPage = async () => {
        await this.setState({
            data: [],
            keyword: '',
            page: 1,
            per_page: 12,
            total: 0,
        });
    }
}
const mapStateToProps = ({ movie_results, loading_results }) => {
    return Object.assign({}, movie_results, loading_results || {});
}

const mapDispatchToProps = (dispatch) => {
    let actions = bindActionCreators({
        get_movie_search: MovieAction.get_movie_search,
        set_loading: LoadingAction.set_loading,

    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Search));