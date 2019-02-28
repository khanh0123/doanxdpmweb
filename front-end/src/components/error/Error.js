import React from 'react';
import create_helmet_tag from "../seo/Helmet";

class Error extends React.Component {

    render() {
        return (
            <section>
                {create_helmet_tag('error')}
                404 NOT FOUND
            </section>
        );
    }
}

export default Error;