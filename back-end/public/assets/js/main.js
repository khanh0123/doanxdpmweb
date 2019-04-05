function create_slug(input)
{
  
    //Đổi chữ hoa thành chữ thường
    var slug = input.toLowerCase();
    
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    // slug = '@' + slug + '@';
    // slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    $.trim(slug);
    //In slug ra textbox có id “slug”
    return slug;
}
function showNotification(type = 'success' , messsage = '' , timer = 4000 , icon = 'notifications' , from = 'top', align = 'right'  ){
    // type = ['','info','success','warning','danger','rose','primary'];

    // color = Math.floor((Math.random() * 6) + 1);

    $.notify({
        icon: icon,
        message: messsage
    },{
        type: type,
        delay:1,
        timer: timer,
        placement: {
            from: from,
            align: align
        },
        z_index: 9999,
    });
}
!function(e){"use strict";var a=0;e(window).on("scroll",function(){var s=e(this).scrollTop();s>e("#nav").height()&&(s<a?e("#nav-fixed").removeClass("slide-up").removeClass("slide-down").addClass("slide-down"):e("#nav-fixed").removeClass("slide-up").removeClass("slide-down").addClass("slide-down")),a=s}),e(".search-btn").on("click",function(){e(".search-form").addClass("active")}),e(".search-close").on("click",function(){e(".search-form").removeClass("active")}),e(document).click(function(s){e(s.target).closest(e("#nav-aside")).length||(e("#nav-aside").hasClass("active")?(e("#nav-aside").removeClass("active"),e("#nav").removeClass("shadow-active")):e(s.target).closest(".aside-btn").length&&(e("#nav-aside").addClass("active"),e("#nav").addClass("shadow-active")))}),e(".nav-aside-close").on("click",function(){e("#nav-aside").removeClass("active"),e("#nav").removeClass("shadow-active")});var o,s,t,i,n,c=e(".sticky-container .sticky-shares"),l=c.height(),d=e(".sticky-container");function v(){0<c.length&&(o=c.offset().top,s=d.offset().top,t=d.offset().left,i=d.height(),n=i+s)}function r(s){0<c.length&&(n-l-80<s?c.css({position:"absolute",top:i-l,left:0}):o<s+80?c.css({position:"fixed",top:80,left:t}):c.css({position:"absolute",top:0,left:0}))}e(window).on("scroll",function(){r(e(this).scrollTop())}),e(window).resize(function(){v(),r(e(this).scrollTop())}),v()}(jQuery);
