import React from "react";
import { CommentAction } from "../../actions"
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router';
import { times_ago } from "../helpers";

class Comment extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            postID:this.props.postID,
            data:[],
            page:1,
        }
        this._inputComment = this._inputComment.bind(this);
        this._getComment = this._getComment.bind(this);
        this._postComment = this._postComment.bind(this);
        this._commentItem = this._commentItem.bind(this);
        this._initBoxReply = this._initBoxReply.bind(this);
        this._replyComment = this._replyComment.bind(this);
        // this.display_reply = { 0: true };
    }

    async componentDidMount() {
        let { postID, page } = this.state;
        this._getComment(this.props);
    }
    async componentWillReceiveProps(nextProps) {

        if (nextProps.postID !== this.state.postID) {
            this.setState({ postID: nextProps.postID }, () => {
                this._getComment(nextProps);
            });
        }
    }

    render() {
        let { data } = this.state;
        // console.log(this.display_reply);

        return (
            <React.Fragment>
                <div className="section-row">
                    <div className="section-title">
                        <h2>3 Comments</h2>
                    </div>
                    <div className="post-comments">
                        <div className="media">
                            <div className="media-left">
                                <img className="media-object" src="./img/avatar.png" alt />
                            </div>
                            <div className="media-body">
                                <div className="media-heading">
                                    <h4>John Doe</h4>
                                    <span className="time">March 27, 2018 at 8:00 am</span>
                                    <a href="#" className="reply">Reply</a>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                {/* comment */}
                                <div className="media">
                                    <div className="media-left">
                                        <img className="media-object" src="./img/avatar.png" alt />
                                    </div>
                                    <div className="media-body">
                                        <div className="media-heading">
                                            <h4>John Doe</h4>
                                            <span className="time">March 27, 2018 at 8:00 am</span>
                                            <a href="#" className="reply">Reply</a>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="media">
                            <div className="media-left">
                                <img className="media-object" src="./img/avatar.png" alt />
                            </div>
                            <div className="media-body">
                                <div className="media-heading">
                                    <h4>John Doe</h4>
                                    <span className="time">March 27, 2018 at 8:00 am</span>
                                    <a href="#" className="reply">Reply</a>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </React.Fragment>

        )
    }
    _openPopupLogin = async () => {
        await this.setState({ is_openPopupLogin: true });
    }
    _closePopupLogin = async () => {
        await this.setState({ is_openPopupLogin: false });
    }
    _getMoreComment = async () => {
        // await this.setState({page:this.state.page+1});
        await this._getComment(this.props, this.state.page + 1);
    }
    _getComment = async (props, page) => {
        let { postID , data,page } = this.state;
        props.get_comment(postID,page).then((res) => {
            let response = res.payload.data;

            let new_data = response.current_page == 1 ? response.data : [...data, ...response.data];
            this.setState({
                data: new_data,
                page: response.current_page,
                total: response.total,
                last_page: response.last_page,
            });
        })
    }
    _postComment = async (reply_id, event) => {

        if (event.key === 'Enter' && event.target.value != '') {
            let { mov_id, data } = this.state;
            let content = event.target.value;
            this.props.post_comment(mov_id, content, reply_id).then(async (res) => {
                let response = res.payload.data;
                if (response.success) {
                    let info = response.info;
                    data = this._addNewCommentToData(data, reply_id, info);

                    await this.setState({ data: data, limit: this.state.limit + 1 });
                }
            })
            event.target.value = '';
        }
    }
    _initBoxReply = async (data) => {
        let { display_reply } = this.state;
        for (let i = 0; i < data.length; i++) {
            display_reply[data[i].id] = false;
        }
        await this.setState({ display_reply: display_reply });

    }
    _replyComment = async (id) => {
        // e.preventDefault();
        // e.stopPropagation();
        let { display_reply } = this.state;
        display_reply[id] = true;
        await this.setState({ display_reply: display_reply })


    }
    _addNewCommentToData = (data, reply_id, item) => {
        if (reply_id == 0) {
            data.unshift(item);
        } else {
            for (let i = 0; i < data.length; i++) {
                if (data[i].id == reply_id) {
                    data[i].reply.push(item);
                    break;
                }
            }
        }
        return data;
    }

    _inputComment = (reply_id) => {
        let info_user = this.props[UserAction.ACTION_GET_STATUS_LOGIN].info || this.props[UserAction.ACTION_USER_LOGIN_FB].info || this.props[UserAction.ACTION_USER_LOGIN].info;
        if (!reply_id) reply_id = 0;
        return (
            <div className="comment-input">
                <div className="comment-img">
                    <span className="avatar-area">
                        <img className="avatar-img" alt={info_user.name} src={info_user.avatar} />
                    </span>
                </div>
                <div className="comment-content">
                    <input maxLength="255" type="text" className="form-control" placeholder="Nhập bình luận" onKeyPress={this._postComment.bind(event, reply_id)
                    } />
                    {/* <button className="comment-btn" onClick={this._postComment.bind(reply_id)}><span className="fa fa-reply"></span></button> */}
                </div>
            </div>
        );
    }
    _commentItem = (item) => {
        return (
            <ol className={`comment-list`} key={item.id}>
                <li className="single-comment">
                    <div className="comment-body">
                        <div className="comment-img">
                            <img src={item.avatar} alt={`avatar of ${item.name}`} />
                        </div>
                        <div className="comment-content">
                            <div className="comment-header">
                                <h3 className="comment-title">{item.name}</h3>
                            </div>
                            <p>{item.content}</p>
                            <div className="blog-details-reply-box">
                                <div className="comment-time">{times_ago(item.created_at)}</div>
                                {this.state.is_login &&
                                    <div className="comment-reply">
                                        <b className="reply" onClick={() => this._replyComment(item.id)}>Trả lời</b>
                                    </div>
                                }

                            </div>
                        </div>

                        {item.reply.length > 0 && item.reply.map((sub_cmt) => {
                            return <ol className={`comment-list-reply`} key={sub_cmt.id}>
                                <li className="single-comment">
                                    <div className="comment-body">
                                        <div className="comment-img">
                                            <img src={sub_cmt.avatar} alt={`avatar of ${sub_cmt.name}`} />
                                        </div>
                                        <div className="comment-content">
                                            <div className="comment-header">
                                                <h3 className="comment-title">{sub_cmt.name}</h3>
                                            </div>
                                            <p>{sub_cmt.content}</p>
                                            <div className="blog-details-reply-box">
                                                <div className="comment-time">{times_ago(sub_cmt.created_at)}</div>
                                                {/* <div className="comment-reply">
                                                    <a href="#" className="reply">Trả lời</a>
                                                </div> */}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        })}
                        {this.state.display_reply[item.id] && this._inputComment(item.id)}

                    </div>
                </li>
            </ol>
        );
    }

}
const mapStateToProps = ({ comment_results, user_results }) => {
    return Object.assign({}, comment_results, user_results || {});
}

const mapDispatchToProps = (dispatch) => {
    let actions = bindActionCreators({
        get_comment: CommentAction.get_comment,
        post_comment: CommentAction.user_comment,
        get_status_login: UserAction.user_get_status_login,
        // get_status_login:UserAction.user_get_status_login


    }, dispatch);
    return { ...actions, dispatch };
}
export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Comment));

