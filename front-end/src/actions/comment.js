import Api from '../apis/api';

const ACTION_GET_COMMENT = 'ACTION_GET_COMMENT';
const ACTION_USER_COMMENT = 'ACTION_USER_COMMENT';

async function get_comment(mov_id,limit,page) {
    let response = await Api.get_comment(mov_id,limit,page);
    return {
        type: ACTION_GET_COMMENT,
        payload: {
            data:response.data.info
        }
    };
}

async function user_comment(mov_id,content,reply_id) {
    let response = await Api.user_comment(mov_id,content,reply_id);
    return {
        type: ACTION_USER_COMMENT,
        payload: {
            data:response.data
        }
    };
}

module.exports =  {
    ACTION_GET_COMMENT,
    ACTION_USER_COMMENT,
    get_comment,
    user_comment,
};