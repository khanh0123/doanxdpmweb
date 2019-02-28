import React from 'react';
import SEO from "./Seo";
import config from "../../config";


function create_helmet_tag(page, data, url, episodeId) {
    switch (page) {
        case 'home':
            let description = 'Đánh giá sản phẩm công nghệ, tin tức công nghệ, tư vấn sản phẩm, điện thoại di động, smartphone, TV, laptop, đồ gia dụng, máy tính bảng, máy ảnh số';
            return (
                <SEO
                    title={config.name_site + " - Đánh giá, tin tức, tư vấn sản phẩm công nghệ"}
                    description={description}
                    url={url ? url : '/'}
                />
            )
        case 'detail':
            return (
                <SEO
                    title={data.title ? (data.title + config.name_site ) : config.seo_default.title}
                    description={data.title ? data.title : config.seo_default.description}
                    url={url ? url : '/'}
                    contentType="article"
                    img={data.image ? data.image : ''}
                    
                />
            )

        default:
            return (
                <SEO
                    title={''}
                    description={''}
                    path="/"
                />
            )
    }

}
export default create_helmet_tag;