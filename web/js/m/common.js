;

var common_ops = {
    init:function(){
        this.eventBind();
        this.setIconLight();
    },
    eventBind:function(){

    },
    setIconLight:function(){
        var pathname = window.location.pathname;
        var nav_name = null;

        if(  pathname.indexOf("/m/default") > -1 || pathname == "/m" || pathname == "/m/" ){
            nav_name = "default";
        }

        if(  pathname.indexOf("/m/product") > -1  ){
            nav_name = "product";
        }

        if(  pathname.indexOf("/m/user") > -1  ){
            nav_name = "user";
        }

        if( nav_name == null ){
            return;
        }

        $(".footer_fixed ."+nav_name).addClass("aon");
    },
    buildMUrl:function( path ,params){
        var url =   "/m" + path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url + _paramUrl

    },
    buildWwwUrl:function( path ,params){
        var url =    path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url + _paramUrl

    },
    buildPicUrl:function( bucket,img_key ){
        var upload_config = eval( '(' + $(".hidden_layout_warp input[name=upload_config]").val() +')' );
        var domain = "http://" + window.location.hostname;
        return domain + upload_config[ bucket ] + "/" + img_key;
    },
    notlogin:function( referer ){
        if ( ! referer) {
            alert('授权过期,系统将引导您重新授权');
            referer = location.pathname + location.search;
        }
        window.location.href = this.buildMUrl("/user/bind",{ referer:referer });
    }
};

$(document).ready( function() {
    common_ops.init();
});