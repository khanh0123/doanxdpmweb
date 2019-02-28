import axios from 'axios';
// import promise_finally from 'promise.prototype.finally';
import config from '../config';

// Create class
class Api {
    static get_content_home(page,limit) {

        const url = config.domain_api + "index.php?limit="+limit+"&page="+page;
        return axios.get(url);
    }
    static get_content_detail(path) {
        const url = config.domain_api +"detail.php?l=" + path;
        return axios.get(url);
    }


    static get content() {
        return {
            get_content_home: this.get_content_home,
            get_content_detail: this.get_content_detail,
        }
    }

}

// Export component
export default Api;