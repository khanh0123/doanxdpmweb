import {MenuAction} from '../actions';

export default function (state = {}, action) {
    let result = {...state};
    switch (action.type) {
        case MenuAction.ACTION_GET_MENU:
            result[action.type] = action.payload.data;
            break;
        default:
            break;
    }

    return result;
}