import {combineReducers} from 'redux';
import MenuReducer from './menu';
import PostReducer from './post';
import LoadingReducer from './loading';
import CommentReducer from "./comment";

const rootReducer = combineReducers({
    menu_results: MenuReducer,
    post_results: PostReducer,
    loading_results: LoadingReducer,
    comment_results:CommentReducer,
});

export default rootReducer;