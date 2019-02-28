import { page_action } from '../actions';
export default function (state = {}, action) {
    let result = { ...state };

    switch (action.type) {
        case page_action.ACTION_GET_CONTENT_HOME:
            result[action.type] = action.payload.data;
            break;
        default:
            break;
    }

    return result;
}