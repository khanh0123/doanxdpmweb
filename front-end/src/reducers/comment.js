import {CommentAction} from '../actions';

export default function (state = {}, action) {
    let result = {...state};
    switch (action.type) {
        case CommentAction.ACTION_GET_COMMENT:
            result[action.type] = action.payload.data;
            break;
        default:
            break;
    }

    return result;
}