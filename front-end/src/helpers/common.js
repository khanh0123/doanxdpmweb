import ReactGA from 'react-ga';

function build_link(type_link, data) {
    let link = '/';
    switch (type_link) {
        case 'home':
            link = "/trang/" + data.id;
            break;
        case 'detail':
            link = data.seo.url !== undefined ? data.seo.url : "/";
            break;
        default:
            link = '/';
            break;
    }
    return link;
}

function shootGa(category, action, label, nonInteraction) {
    ReactGA.initialize('UA-117114757-4');
    ReactGA.event({
        category: category ? category : "VieOn",
        action: action ? action : "VieOn",
        label: label ? label : "VieOn",
        nonInteraction: nonInteraction ? true : false
    });
}

function random_string(length) {
    length = length || 10;
    return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
}

function has(obj, key) {
    return (obj && obj[key] !== undefined && obj[key] !== '');
}

function has_id(obj) {
    return has(obj, 'id');
}

function padLeft(str, pad) {
    str = "" + str;
    if (typeof pad === "undefined") {
        pad = "00";
    }
    return pad.substring(0, pad.length - str.length) + str
}

function current_date_custom(format, date) {
    if (!format) {
        format = "yyyy-mm-dd";
    }
    let today = new Date();

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
function current_date(format, date) {
    if (!format) {
        format = "yyyy-mm-dd";
    }
    let today = new Date();

    if (typeof date !== "undefined") {
        today = date;
    }
    let dd = today.getDate();
    let mm = today.getMonth() + 1;
    let yyyy = today.getFullYear();
    let hours = today.getHours();
    let minutes = today.getMinutes();
    return format.replace("hh", padLeft(hours)).replace("ii", padLeft(minutes)).replace("dd", padLeft(dd)).replace("mm", padLeft(mm)).replace("yyyy", yyyy);
}

function current_time_now() {
    return Math.floor(Date.now() / 1000);
}


function date_of_week(date) {
    if (typeof date === "number") {
        date = new Date(date * 1000);
    }
    let weekday = new Array(7);
    weekday[0] = "Chủ Nhật";
    weekday[1] = "Thứ Hai";
    weekday[2] = "Thứ Ba";
    weekday[3] = "Thứ Tư";
    weekday[4] = "Thứ Năm";
    weekday[5] = "Thứ Sáu";
    weekday[6] = "Thứ Bảy";

    return weekday[date.getDay()];
}

function format24HoursTime(date) {
    if (typeof date === "number") {
        date = new Date(date * 1000);
    }
    let hours = date.getHours();
    let minutes = date.getMinutes();
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return padLeft(hours) + ':' + padLeft(minutes);
}

function formatAMPM(date) {
    if (typeof date === "number") {
        date = new Date(date * 1000);
    }
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12;
    return padLeft(hours) + ':' + padLeft(minutes) + ' ' + padLeft(ampm);
}

function json_to_query_string(json) {
    return Object.keys(json).map(function (key) {
        return encodeURIComponent(key) + '=' +
            encodeURIComponent(json[key]);
    }).join('&');
}

function formatPlayerTime(totalSeconds) {
    if (totalSeconds === Infinity) {
        totalSeconds = 0;
    }
    totalSeconds = Math.round(totalSeconds);
    let hour = Math.floor(totalSeconds / 3600);
    totalSeconds %= 3600;
    let min = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;
    return padLeft(hour) + ':' + padLeft(min) + ':' + padLeft(seconds);
}

function isLiveTime(start, end) {
    let ndate = new Date();
    let nowtime = ndate.getTime() / 1000;
    return nowtime >= start && nowtime <= end;

}

function hideElement(el) {
    if (el) {
        el.style.opacity = 0;
        el.style.pointerEvents = "none";
    }
}
function showElement(el) {
    if (el) {
        el.style.opacity = 1;
        el.style.pointerEvents = "auto";
    }
}

function check_split_subtitle(str, index) {
    if (typeof str !== "string") {
        return str;
    }
    let _schar = "-";
    if (str.indexOf(_schar) > -1) {
        return str.split(_schar)[index] || str;
    }
    return (index < 1 ? str : "");
}

function is_undefined_empty(str) {
    return (typeof str === "undefined" || str === null || str.length === 0 || typeof str === '') ? undefined : str;
}

function outerHeight(el) {
    let elmHeight, elmMargin, elmPadding;
    if (document.all) { // IE
        elmHeight = el.currentStyle.height;
        elmMargin = parseInt(el.currentStyle.marginTop, 10) + parseInt(el.currentStyle.marginBottom, 10);
        elmPadding = parseInt(el.currentStyle.paddingTop, 10) + parseInt(el.currentStyle.addingBottom, 10);
    }
    else { // Mozilla
        elmHeight = document.defaultView.getComputedStyle(el, '').getPropertyValue('height');
        elmMargin = parseInt(document.defaultView.getComputedStyle(el, '').getPropertyValue('margin-top')) + parseInt(document.defaultView.getComputedStyle(el, '').getPropertyValue('margin-bottom'));
        elmPadding = parseInt(document.defaultView.getComputedStyle(el, '').getPropertyValue('padding-top')) + parseInt(document.defaultView.getComputedStyle(el, '').getPropertyValue('padding-bottom'));
    }
    return (parseInt(elmHeight) + parseInt(elmMargin) + parseInt(elmPadding));
}

function isMobile() {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        let _location = window.location.href;
        if (_location.indexOf("validate_register") === -1 && _location.indexOf("update_forget_password") === -1) {
            return true;
        }
    }
    return false;
}
function getModelDevice() {
    var OSName = "Unknown";
    if (window.navigator.userAgent.indexOf("Windows NT 10.0") != -1) OSName = "Windows 10";
    if (window.navigator.userAgent.indexOf("Windows NT 6.2") != -1) OSName = "Windows 8";
    if (window.navigator.userAgent.indexOf("Windows NT 6.1") != -1) OSName = "Windows 7";
    if (window.navigator.userAgent.indexOf("Windows NT 6.0") != -1) OSName = "Windows Vista";
    if (window.navigator.userAgent.indexOf("Windows NT 5.1") != -1) OSName = "Windows XP";
    if (window.navigator.userAgent.indexOf("Windows NT 5.0") != -1) OSName = "Windows 2000";
    if (window.navigator.userAgent.indexOf("Mac") != -1) OSName = "Mac/iOS";
    if (window.navigator.userAgent.indexOf("X11") != -1) OSName = "UNIX";
    if (window.navigator.userAgent.indexOf("Linux") != -1) OSName = "Linux";
    return OSName;
}
function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
}

function getResolution(resolution) {
    var nameResolution = '';
    switch (resolution) {
        case 1:
            nameResolution = 'SD';
            break;
        case 2:
            nameResolution = 'HD';
            break;
        case 3:
            nameResolution = 'HD';
            break;
        case 4:
            nameResolution = '4K';
            break;
        default:
            nameResolution = 'SD';
            break;
    }
    return nameResolution;
}
function TimeToolTip(seconds, guide) {
      seconds = seconds < 0 ? 0 : seconds;
      let s = Math.floor(seconds % 60);
      let m = Math.floor(seconds / 60 % 60);
      let h = Math.floor(seconds / 3600);
      const gm = Math.floor(guide / 60 % 60);
      const gh = Math.floor(guide / 3600);

      // handle invalid times
      if (isNaN(seconds) || seconds === Infinity) {
        // '-' is false for all relational operators (e.g. <, >=) so this setting
        // will add the minimum number of fields specified by the guide
        h = m = s = '-';
      }

      // Check if we need to show hours
      h = (h > 0 || gh > 0) ? h + ':' : '';

      // If hours are showing, we may need to add a leading zero.
      // Always show at least one digit of minutes.
      m = (((h || gm >= 10) && m < 10) ? '0' + m : m) + ':';

      // Check if leading zero is need for seconds
      s = (s < 10) ? '0' + s : s;

      return h + m + s;
}

module.exports = {
    build_link,
    shootGa,
    random_string,
    has,
    has_id,
    current_date,
    current_time_now,
    formatAMPM,
    date_of_week,
    json_to_query_string,
    formatPlayerTime,
    isLiveTime,
    hideElement,
    showElement,
    is_undefined_empty,
    check_split_subtitle,
    outerHeight,
    format24HoursTime,
    isMobile,
    current_date_custom,
    getModelDevice,
    getRandomInt,
    getResolution,
    TimeToolTip
};