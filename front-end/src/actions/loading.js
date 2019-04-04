const ACTION_SET_LOADING = 'ACTION_SET_LOADING';

function set_loading(status) {
    return {
        type: ACTION_SET_LOADING,
        payload:{
            data:status
        }
    };
}
module.exports =  {
    ACTION_SET_LOADING,
    set_loading,
};