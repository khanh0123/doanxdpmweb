// import { clearScreenDown } from 'readline';

export default function htmlTemplate(reactDom, reduxState, helmetData, version) {
    require('dotenv').config()
    let staticDomain = process.env.STATIC_DOMAIN || '';
    return `<!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-capable" content="yes">
            <link rel="manifest" href="/manifest.json">
            <link rel="shortcut icon" href="${staticDomain}/img/favicon.ico">
            <link rel="apple-touch-icon" href="/img/icons-192.png">
            <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet" />
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


            <link href="${staticDomain}/common-css/bootstrap.css?v=${version}" rel="stylesheet" />
            <link href="${staticDomain}/common-css/ionicons.css?v=${version}" rel="stylesheet" />
            <link href="${staticDomain}/layout-1/css/styles.css?v=${version}" rel="stylesheet" />
            <link href="${staticDomain}/layout-1/css/responsive.css?v=${version}" rel="stylesheet" />
            <link href="${staticDomain}/single-post-1/css/styles.css?v=${version}" rel="stylesheet">
	        <link href="${staticDomain}/single-post-1/css/responsive.css?v=${version}" rel="stylesheet">

            
            ${ helmetData && helmetData.title ? helmetData.title.toString() : ''}
            ${ helmetData && helmetData.meta ? helmetData.meta.toString() : ''}
            ${ helmetData && helmetData.script ? helmetData.script.toString() : ''}
            ${ helmetData && helmetData.link  ? helmetData.link.toString() : ''}
        </head>
        
        <body>
            
            <div id="app">${ reactDom}</div>
            <script>
                window.__REDUX_DATA__ = ${ JSON.stringify(reduxState)}
            </script>

            <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                navigator.serviceWorker.register('sw.js').then(function(registration) {
                    console.log('Service Worker registration successful', registration.scope);
                }, function(err) {
                    console.log('Service Worker registration failed', err);
                }).catch(function(err) {
                    console.log(err);
                });
                });
            } else {
                console.log('Service Worker is not supported by browser.');
            }
             </script>
            <script src="${staticDomain}/common-js/jquery-3.1.1.min.js?v=${version}"></script>

            <script src="${staticDomain}/common-js/tether.min.js?v=${version}"></script>

            <script src="${staticDomain}/common-js/bootstrap.js?v=${version}"></script>

            <script src="${staticDomain}/common-js/scripts.js?v=${version}"></script>

            <script src="${staticDomain}/app.bundle.js?v=${version}" type="text/javascript"></script>
        </body>
        </html>
    `;
}