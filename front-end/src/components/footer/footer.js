import React from "react";
import { Link } from "react-router-dom";
class Footer extends React.Component {
    render() {
        return (
            <footer id="footer">
                <div className="container">
                    <div className="row">
                        <div className="col-md-5">
                            <div className="footer-widget">
                                <div className="footer-logo">
                                    <Link to={"/"} className="logo"><img width="114px" height="100px" src="/assets/img/logo.png" alt="LOGO" /></Link>
                                </div>
                                <ul className="footer-nav">
                                    <li><a href="javascript:void(0)">Chính sách</a></li>
                                    <li><a href="javascript:void(0)">Quảng Cáo</a></li>
                                </ul>
                                <div className="footer-copyright">
                                    <span>© Copyright © 2019</span>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="footer-widget">
                                        <h3 className="footer-title">Giới thiệu</h3>
                                        <ul className="footer-links">
                                            <li><a href="javascript:void(0)">Về chúng tôi</a></li>
                                            <li><a href="javascript:void(0)">Liên hệ</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                </div>
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="footer-widget">
                                <h3 className="footer-title">Nhận thông báo khi có bài viết mới</h3>
                                <div className="footer-newsletter">
                                    <form>
                                        <input className="input" type="email" name="newsletter" placeholder="Enter your email" />
                                        <button className="newsletter-btn"><i className="fa fa-paper-plane" /></button>
                                    </form>
                                </div>
                                <ul className="footer-social">
                                    <li><a href="javascript:void(0)"><i className="fa fa-facebook" /></a></li>
                                    <li><a href="javascript:void(0)"><i className="fa fa-twitter" /></a></li>
                                    <li><a href="javascript:void(0)"><i className="fa fa-google-plus" /></a></li>
                                    <li><a href="javascript:void(0)"><i className="fa fa-pinterest" /></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>


        )
    }
}

export default Footer;