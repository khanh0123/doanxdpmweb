import React from "react";
import {Link} from "react-router-dom";

class Header extends React.Component {

    constructor(props) {
        super(props)
        this.state = {
        };
    }

    render() {
        return (
            <header>
                <div className="container-fluid position-relative no-side-padding">
                    <Link to="/" className="logo"><img src="/images/logo.png" alt="Logo Image" /></Link>
                    <div className="menu-nav-icon" data-nav-menu="#main-menu"><i className="ion-navicon" /></div>
                    <ul className="main-menu visible-on-click" id="main-menu">
                        <li><Link to="/">Trang chủ</Link></li>
                    </ul>
                    <div className="src-area">
                        <form>
                            <button className="src-btn" type="submit"><i className="ion-ios-search-strong" /></button>
                            <input className="src-input" type="text" placeholder="Tìm kiếm" />
                        </form>
                    </div>
                </div>
            </header>

        )
    }
}

export default Header;
