function padLeft(str, pad) {
    str = "" + str;
    if (typeof pad === "undefined") {
        pad = "00";
    }
    return pad.substring(0, pad.length - str.length) + str
}
const times_ago = (timestamp) => {
    let date = (new Date(timestamp).getTime()) / 1000;
    let today = (new Date().getTime()) / 1000;
    let times_ago = today - date;
    let time;
    let unix = '';
    if (times_ago < 60) {
        time = 'vài giây';

    } else if (times_ago < 60 * 60) {
        time = Math.round(times_ago / 60);
        unix = ' phút';
    } else if (times_ago < 3600 * 24) {
        time = Math.round(times_ago / 3600);
        unix = ' giờ';
    } else if (times_ago < 3600 * 24 * 30) {
        time = Math.round(times_ago / (3600 * 24));
        unix = ' ngày';
    } else if (times_ago < 3600 * 24 * 30 * 12) {
        time = Math.round(times_ago / (3600 * 24 * 30));
        unix = ' tháng';
    } else {
        time = Math.round(times_ago / (3600 * 24 * 30 * 12));
        unix = ' năm';
    }
    return time + unix;

}
function custom_date(timestamp, format) {
    
    if (!format) {
        format = "dd/mm/yyyy";
    }
    let today = new Date();
    let date = !isNaN(timestamp) ? new Date(timestamp * 1000) : new Date(timestamp) ;


    let dd = date.getDate();
    let mm = date.getMonth() + 1;
    let yyyy = date.getFullYear();
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let weekday = date.getDay();
    let day = '';
    let days = ["Chủ Nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"];
    if (weekday == today.getDay()) {
        day = 'Hôm nay';
    } else {
        day = days[weekday];
    }

    return format.replace("day", day).replace("hh", padLeft(hours)).replace("ii", padLeft(minutes)).replace("dd", padLeft(dd)).replace("mm", padLeft(mm)).replace("yyyy", yyyy);
}
const getMovie = async (_this, props, type, MovieAction) => {
    switch (type) {
        case 'banner_movies':
            if (!props[MovieAction.ACTION_GET_BANNER_MOVIES]) {
                await props.get_banner_movies().then((res) => {
                    let r = res.payload.data;
                    _this.setState({ banner_movies: r.data });
                });
            } else {
                let data = props[MovieAction.ACTION_GET_BANNER_MOVIES].data;
                _this.setState({ banner_movies: data });
            }
            break;
        case 'recommend_movies':
            break;
        case 'hot_movies':
            if (!props[MovieAction.ACTION_GET_HOT_MOVIES]) {
                await props.get_hot_movies().then((res) => {
                    let r = res.payload.data;
                    _this.setState({ hot_movies: r.data });
                });
            } else {
                let data = props[MovieAction.ACTION_GET_HOT_MOVIES].data;
                _this.setState({ hot_movies: data });
            }
            break;
        case 'hot_series_movies':
            if (!props[MovieAction.ACTION_GET_HOT_SERIES_MOVIES]) {
                await props.get_hot_series_movies().then((res) => {
                    let r = res.payload.data;
                    _this.setState({ hot_series_movies: r.data });
                });
            } else {
                let data = props[MovieAction.ACTION_GET_HOT_SERIES_MOVIES].data;
                _this.setState({ hot_series_movies: data });
            }
            break;
        case 'hot_retail_movies':
            if (!props[MovieAction.ACTION_GET_HOT_RETAIL_MOVIES]) {
                await props.get_hot_retail_movies().then((res) => {
                    let r = res.payload.data;
                    _this.setState({ hot_retail_movies: r.data });
                });
            } else {
                let data = props[MovieAction.ACTION_GET_HOT_RETAIL_MOVIES].data;
                _this.setState({ hot_retail_movies: data });
            }
            break;


        default:
            break;
    }
}
module.exports = {
    custom_date,
    times_ago,
    getMovie
};