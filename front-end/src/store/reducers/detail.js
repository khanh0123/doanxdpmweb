import { detail_action } from '../actions';

export default function (state = {}, action) {
    let result = { ...state };
    switch (action.type) {
        case detail_action.ACTION_GET_CONTENT_DETAIL:
            result[action.type] = action.payload.data;
            break;
        default:
            break;
    }

    return result;
}