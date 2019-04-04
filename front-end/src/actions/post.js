import Api from '../apis/api';

const ACTION_GET_POSTS = 'ACTION_GET_POSTS';
const ACTION_GET_DETAIL_POST = 'ACTION_GET_DETAIL_POST';

async function get_posts(condition) {
    let res = await Api.get_posts(condition);
    return {
        type: ACTION_GET_POSTS,
        payload: {
            data:res.data.info
        } 
    };
}

async function get_detail_post(id) {
    let res =  await Api.get_detail_post(id);
    return {
        id:id,
        type: ACTION_GET_DETAIL_POST,
        payload: {
            data:res.data.info
        } 
    };
}


module.exports =  {
    ACTION_GET_POSTS,
    ACTION_GET_DETAIL_POST,
    get_posts,
    get_detail_post,
};