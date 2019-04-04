import Api from '../apis/api';

const ACTION_GET_MENU = 'ACTION_GET_MENU';

async function get_menu() {
    let response = await Api.get_menu();
    return {
        type: ACTION_GET_MENU,
        payload: {
            data:response.data.info
        }
    };
}

module.exports =  {
    ACTION_GET_MENU,
    get_menu
};