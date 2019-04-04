import axios from "axios";
import cookie from 'react-cookies';
import config from './index';

// window.loaders = [];
// console.log(axios.interceptors);
// credentials: false
axios.interceptors.request.use(cfg => {    
    
    if (cfg.url) {
        let access_token = cookie.load(config.constant.cookie_token);
        // cfg.headers['Content-Type'] = "application/json";
        // cfg.headers['Access-Control-Allow-Origin'] = '*';
        if (access_token) {
            cfg.headers['Authorization'] = access_token;
        } else {
            let token_anonymous = cookie.load(config.constant.cookie_token_anonymous);
            if(token_anonymous) {
                cfg.headers['Authorization'] = token_anonymous;
            }
        }

        // if (should_show_loader) {
        //     show_loader(url);
        // }
    }

    return cfg;
}, error => {
    // window.toastr.error(error);
    // hide_loader(error.config);
    // return Promise.reject(error);
});
axios.interceptors.response.use(response => {
    // hide_loader(response.config);
    // window.scrollTo(0,0);
    return response;
}, error => {
    // hide_loader(error.config);
    return Promise.reject(error);
});


// function hide_loader(xhr_config) {
//     if (xhr_config) {
//         const url = xhr_config.url;
//         const index = window.loaders.indexOf(url);
//         if (index >= 0) {
//             window.loaders.splice(index, 1);
//         }

//         if (window.loaders.length === 0) {
//             window.jQuery('.loading-block').hide();
//         }
//     }
// }
