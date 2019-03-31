import React from "react";
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import { PostAction } from "../../actions";
import { Link } from 'react-router-dom';

class MostView extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            most_read_posts: [],
        };

    }
    componentDidMount() {
        this._get_post('most_read_posts')
    }
    _get_post = async (type) => {
        switch (type) {
            case 'most_read_posts':
                let condition = {
                    orderBy: 'view',
                    limit: 10,
                };
                await this.props.get_posts(condition).then((res) => {
                    let r = res.payload.data.data;
                    this.setState({ most_read_posts: r });
                });
                break;

            default:
                break;
        }
    }
    componentWillReceiveProps(nextProps) {


    }
    render() {
        let { most_read_posts } = this.state;

        return (
            <React.Fragment>
                <div className="aside-widget">
                    <div className="section-title">
                        <h2>Lượt xem nhiều</h2>
                    </div>
                    {most_read_posts.map((post) => {
                        return <div className="post post-widget" key={post.id}>
                            <Link className="post-img" to={`/chi-tiet/${post.slug}/${post.id}`}>
                                <img src={post.images} alt="" />
                                </Link>
                            <div className="post-body">
                                <h3 className="post-title"><Link to={`/chi-tiet/${post.slug}/${post.id}`}>{post.title}</Link></h3>
                            </div>
                        </div>
                    })}

                </div>

                <div className="aside-widget text-center">
                    <a href="#" style={{ display: 'inline-block', margin: 'auto' }}>
                        <img className="img-responsive" src="https://media.sproutsocial.com/uploads/2018/06/Facebook-Ad-Targeting.png" alt="" />
                    </a>
                </div>
            </React.Fragment>
        )
    }



}
function mapStateToProps({ post_results, loading_results }) {
    return Object.assign({}, post_results, loading_results || {});
}

function mapDispatchToProps(dispatch) {
    let actions = bindActionCreators({
        get_posts: PostAction.get_posts,

    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(MostView));
