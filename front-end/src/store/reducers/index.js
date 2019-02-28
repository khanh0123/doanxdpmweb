import { createStore, combineReducers, applyMiddleware } from "redux";
import thunkMiddleware from "redux-thunk";
import PageReducer from "./page";
import DetailReducer from "./detail";
import ErrorReducer from "./error";

export const initializeSession = () => ({
    type: "INITIALIZE_SESSION",
});
const reducers = combineReducers({
    page_results: PageReducer,
    detail_results: DetailReducer,
    isError: ErrorReducer
});

export default (initialState = {}) =>
    createStore(reducers, initialState, applyMiddleware(thunkMiddleware));
