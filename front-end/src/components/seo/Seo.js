import React from 'react';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';
import config from "../../config";

const getMetaTags = ({
    title, description, url, contentType, img, robots, deep_link
}) => {
    const metaTags = [
        { name: 'og:title', content: title ? title : ''},
        { name: 'og:type', content: contentType ? contentType : ''},
        { name: 'og:url', content: url ? url: ''},
        { name: 'og:image', content: img ?img : ''},
        { name: 'og:description', content: description ? description : ''},
        { name: 'og:site_name', content: '' },
        { name: 'og:image:width', content: "600" },
        { name: 'og:image:height', content: "315" },
        { name: 'fb:app_id', content:123 },
        { name: 'robots', content: 'index,follow' },
        { name: 'theme-color', content: '' },
        { name: 'description', content: description ? description : '' },
       
        
    ];
    return metaTags;
};

const SEO = (
    {
        title, description, url, contentType, robots, img, datePublished, schema, ratingValue, ratingCount, director_name, deep_link
    }
) => (
        <Helmet
            title={title ? title : ''}
            link={[
                { rel: 'canonical', href: url ? url : config.domain_web },
            ]}
            meta={getMetaTags({
                title,
                description,
                contentType,
                img,
                url,
                robots,
                deep_link,
            })}

            script={
                (title != '' || description != '') ?
                    schema === 'Movie' ?
                        [
                            {
                                type: 'application/ld+json',
                                innerHTML: JSON.stringify({
                                    '@context': 'http://schema.org/',
                                    '@type': schema,
                                    description: description ? description : config.seo_default.description,
                                    name: title ? title : config.seo_default.title,
                                    image: img ? img : config.seo_default.img,
                                    thumbnailUrl: img ? img : config.seo_default.img,
                                    dateCreated: datePublished,
                                    
                                    director: {
                                        '@type': 'Person',
                                        name: director_name
                                    }
                                })
                            },
                            {
                                type: 'application/ld+json',
                                innerHTML: JSON.stringify({
                                    '@context': 'http://schema.org',
                                    '@type': 'BreadcrumbList',
                                    itemListElement: [
                                        {
                                            '@type': 'ListItem',
                                            position: 1,
                                            item: {
                                                '@id': config.seo_default.url,
                                                name: 'Trang chủ'
                                            },
                                        },
                                        {
                                            '@type': 'ListItem',
                                            position: 2,
                                            item: {
                                                '@id': url,
                                                name: title ? title : config.seo_default.title
                                            },
                                        },

                                    ]
                                })
                            }
                        ]
                        :
                        [
                            {
                                type: 'application/ld+json',
                                innerHTML: JSON.stringify({
                                    '@context': 'http://schema.org',
                                    '@type': 'WebSite',
                                    description: description ? description : config.seo_default.description,
                                    name: title ? title : config.seo_default.title,
                                    url: url,
                                    thumbnailUrl: img ? img : config.seo_default.img,                                   
                                })
                            },

                            {
                                type: 'application/ld+json',
                                innerHTML: JSON.stringify({
                                    '@context': 'http://schema.org',
                                    '@type': 'BreadcrumbList',
                                    itemListElement: [
                                        {
                                            '@type': 'ListItem',
                                            position: 1,
                                            item: {
                                                '@id': config.seo_default.url,
                                                name: 'Trang chủ'
                                            },
                                        },
                                        {
                                            '@type': 'ListItem',
                                            position: 2,
                                            item: {
                                                '@id': url ? url : config.seo_default.url,
                                                name: title ? title : config.seo_default.title
                                            },
                                        },

                                    ]
                                })
                            }
                        ]
                    :
                    []
            }

        />

    );

SEO.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
    url: PropTypes.string,
    contentType: PropTypes.string,
    img: PropTypes.string,
    schema: PropTypes.string,
    robots: PropTypes.string,
    deep_link: PropTypes.string,
};

export default SEO;

