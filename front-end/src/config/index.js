let domain_api = "//lvtn.tk/api/v1/";

let config = {
    domain: {
        fe: 'http://luanvantotnghiep.design',
    },
    time: {
    },
    constant: {
        cookie_token: 'access_token',
        cookie_token_anonymous: 'token_anonymous',
        platform: "web",
        version: "1.0",
    },
    app_config: domain_api + "cas/public/getconfig",
    api: {
        menu: domain_api + "menu",
        post: domain_api + "posts",
        post_detail: domain_api + "posts",
        get_comment: domain_api + "post",
        user_comment: domain_api + "user/comment",


    },
    title: {
        webtitle: "ViePlay - ",
        livetv: "Xem trực tuyến - ",
        dvr: "Xem lại - ",
        post: "Xem phim - ",
        search: "Tìm kiếm - ",
        vodpage: "Kho Video",
        userpage: "Thông tin cá nhân",
        history: "Lịch sử xem phim"
    },
    msg: {
        
    },
    images: {
        empty_thumbnail: "/assets/images/post-thumbnail.jpg",
        empty_poster: "/assets/images/post-poster.png",
        empty_avatar: "/assets/images/empty_avatar.jpg"
    },
    seo_default: {
        
    },
};

module.exports = config;