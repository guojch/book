;
var weixin_jssdk_ops = {
    init:function(){
        this.initJSconfig();
    },
    initJSconfig:function(){
        var that = this;
        $.ajax({
            url:'/weixin/jssdk/index?url='+encodeURIComponent(location.href.split('#')[0]),
            type:'GET',
            dataType:'json',
            success:function( res ){
                if( res.code != 200 ){
                    return ;
                }

                var data = res.data;
                wx.config({
                    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                    appId: data['appId'], // 必填，公众号的唯一标识
                    timestamp: data['timestamp'], // 必填，生成签名的时间戳
                    nonceStr: data['nonceStr'], // 必填，生成签名的随机串
                    signature: data['signature'],// 必填，签名，见附录1
                    jsApiList: [ 'onMenuShareTimeline','onMenuShareAppMessage' ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
                });

                wx.ready(function(){

                    var share_info =  eval( '(' + $("#share_info").val() + ")" );
                    var title = share_info.title;
                    var link = encodeURIComponent(  location.href.split('#')[0] );
                    var desc = share_info.desc;
                    var img_url = share_info.img_url;
                    wx.onMenuShareTimeline({
                        title: title, // 分享标题
                        link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                        imgUrl: img_url, // 分享图标
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            that.sharedSuccess();
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });

                    wx.onMenuShareAppMessage({
                        title: title, // 分享标题
                        desc: desc, // 分享描述
                        link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                        imgUrl: img_url, // 分享图标
                        type: 'link', // 分享类型,music、video或link，不填默认为link
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            that.sharedSuccess();
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                });

                wx.error(function(res){

                });
            }
        });
    },
    wxPay:function(json_data){
        wx.ready(function(){
            wx.chooseWXPay(json_data);
        });
    },
    sharedSuccess:function(){
        $.ajax({
            url:common_ops.buildMUrl("/default/shared"),
            type:'POST',
            dataType:'json',
            data:{
                url:window.location.href
            }
        });
    }
};

$(document).ready(function(){
    weixin_jssdk_ops.init();
});
