import Api from '../../apis/api';

const ACTION_GET_CONTENT_DETAIL = 'GET_CONTENT_DETAIL';

const get_content_detail = (obj) => {
    if (obj && obj.store) {
        let path = obj.request.fullPath.replace("/detail/","");
        return Api.content.get_content_detail(path).then(res => {
            let data = res.data;
            const action = {
                type: ACTION_GET_CONTENT_DETAIL,
                payload: { data }
            }
            return obj.store.dispatch(action)
        })
    }
    return (dispatch) => {

        return Api.content.get_content_detail(obj.path).then(res => {
            let data = res.data;
            const action = {
                type: ACTION_GET_CONTENT_DETAIL,
                payload: { data }
            }
            dispatch(action);

            return action;
        })
    }
}

module.exports = {
    ACTION_GET_CONTENT_DETAIL,
    get_content_detail,
};