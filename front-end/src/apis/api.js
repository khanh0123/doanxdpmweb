// import "../config/custom_request";
import axios from 'axios';
import config from '../config';

class Api {

    // Menu
    static get_menu() {
        const url = `${config.api.menu}`;

        return axios({
            method: 'get',
            url: url,
            data: {},
        })

    }
    static get_posts(condition) {
        
        const url = `${config.api.post}`;

        return axios({
            method: 'get',
            url: url,
            data: {},
            params: condition
        })
    }
    
    static get_detail_post(id) {
        const url = `${config.api.post_detail}/${id}`;

        return axios({
            method: 'get',
            url: url,
            data: {},
            params:{}
        })
    }

    static get_comment(mov_id,limit,page) {
        const url = `${config.api.get_comment}/${mov_id}/get_comment`;
        return axios({
            method: 'get',
            url: url,
            data: {
                
            },
            params: {
                page:page,
                limit:limit,
            }
        })
    }
    static user_comment(mov_id,content,reply_id) {        
        if(!reply_id) reply_id = 0;
        const url = `${config.api.user_comment}`;
        let data = {
            mov_id:mov_id,
            content:content
        };
        if(reply_id != 0){
            data.reply_id = reply_id;
        }
        return axios({
            method: 'post',
            url: url,
            data: data,
            params: {}
        })
    }


    

    

    


}

// Export component
export default Api;