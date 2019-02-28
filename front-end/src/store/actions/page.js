import Api from '../../apis/api';

const ACTION_GET_CONTENT_HOME = 'GET_CONTENT_HOME';

const get_content_home = (obj) => {

    let {page ,limit} = obj;
    if(!page){
        page = 1;
    }
    if(!limit){
        limit = 12;
    }
    if (obj && obj.store) {
        return Api.content.get_content_home(page,limit).then(res => {   
                                 
            let data = res.data;
            const action = {
                type: ACTION_GET_CONTENT_HOME,
                payload: { data }
            };            
            return obj.store.dispatch(action);
        });
    }
    return (dispatch) => {
        return Api.content.get_content_home(page,limit).then(res => {
            let data = res.data;
            const action = {
                type: ACTION_GET_CONTENT_HOME,
                payload: { data }
            }            
            dispatch(action);

            return action;
        })
    }
}


module.exports = {
    ACTION_GET_CONTENT_HOME,
    get_content_home,
};