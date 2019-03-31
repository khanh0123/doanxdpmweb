import React from "react";
class Loading extends React.Component {
    
    constructor(props){
        super(props);
        this.state = {
            display:'',
            opacity:1,
            title:'Chào mừng bạn đến với Movie Star. Vui lòng đợi trong giây lát ..'
        }
    }
    render() {
        return (
            <div className="preloader" style={{display:this.state.display,opacity:this.state.opacity}}>
                <div className="preloader-lod" style={{display:this.state.display,opacity:this.state.opacity}}/>
                <div className="preloader-lod" style={{display:this.state.display,opacity:this.state.opacity}}/>
                <div className="preloader-lod" style={{display:this.state.display,opacity:this.state.opacity}}/>
                <div className="preloader-loding">{this.state.title}</div>
                <div className="large-square" />
            </div>

        )
    }
}

export default Loading;