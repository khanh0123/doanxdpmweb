let domain_api = window.DOMAIN_API ? window.DOMAIN_API : "//lvtn.tk/api/v1/";

let config = {
    domain: {
        fe: 'http://luanvantotnghiep.design',
    },
    time: {
    },
    constant: {
        cookie_token: 'access_token',
        platform: "web",
        version: "1.0",
    },
    api: {
        menu: domain_api + "menu",
        post: domain_api + "posts",
        post_detail: domain_api + "posts",
        get_comment: domain_api + "post",
        user_comment: domain_api + "user/comment",


    },
};

module.exports = config;