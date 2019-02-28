import React from "react";
import {Link} from "react-router-dom";
class Item extends React.Component {

    constructor(props) {
        super(props)
        this.state = {
        }
    }

    render() {
        let { data } = this.props;
        
        return data !== '' && (
            <div className="card h-100">
                <div className="single-post post-style-1">
                    <div className="blog-image"><img src={data.image} alt="Blog Image" /></div>
                    <Link className="avatar" to={"/detail/"+data.link}><img src="images/icons8-team-355979.jpg" alt="Profile Image" /></Link>
                    <div className="blog-info">
                        <h4 className="title"><Link to={"/detail/"+data.link}><b>{data.title}</b></Link></h4>
                        <ul className="post-footer">
                            <li><a href="javascript:void(0)"><i className="ion-heart" />57</a></li>
                            <li><a href="javascript:void(0)"><i className="ion-chatbubble" />6</a></li>
                            <li><a href="javascript:void(0)"><i className="ion-eye" />138</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        )
    }
}

export default Item;