import Page_Action from "./page";
import Detail_Action from "./detail";

const init_home = (obj) => {
    
    if (obj) {        
        return Page_Action.get_content_home(obj);
    }
}

const init_detail = (obj) => {
        
    if (obj) {
        
        return Detail_Action.get_content_detail(obj);

    }
}

module.exports = {
    init_home,
    init_detail
};