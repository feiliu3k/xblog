jQuery(function(){
//选项卡滑动切换通用
jQuery(function(){
    jQuery(".hoverTag .chgBtn").hover(function(){
        jQuery(this).parent().find(".chgBtn").removeClass("chgCutBtn");
        jQuery(this).addClass("chgCutBtn");
        var cutNum=jQuery(this).parent().find(".chgBtn").index(this);
        jQuery(this).parents(".hoverTag").find(".chgCon").hide();
        jQuery(this).parents(".hoverTag").find(".chgCon").eq(cutNum).show();
    })
})

//选项卡点击切换通用
jQuery(function(){
    jQuery(".clickTag .chgBtn").click(function(){
        jQuery(this).parent().find(".chgBtn").removeClass("chgCutBtn");
        jQuery(this).addClass("chgCutBtn");
        var cutNum=jQuery(this).parent().find(".chgBtn").index(this);
        jQuery(this).parents(".clickTag").find(".chgCon").hide();
        jQuery(this).parents(".clickTag").find(".chgCon").eq(cutNum).show();
    })
})



$(".btnDelPic").click(function(event) {
    var sure=confirm('你确定要删除吗?');

    if (sure==true){
        var bstid=$(this).attr("data-bstid");
        var temppath=$(this).attr("data-picpath");
        var startpos=temppath.lastIndexOf("/")+1;
        var picname=temppath.substring(startpos);



        var url="src/picdele.php";

        $.post(url,
            {
                picname:picname,
                bstid:bstid,
            },
            function(data,status){
                if (data==="success"){
                    location.reload(true);
                }
            });
    }
    return false;
});


//图库弹出层
$(".mskeLayBg").height($(document).height());
$(".mskeClaose").click(function(){
    $(".mskeLayBg,.mskelayBox").hide()
});
$(".msKeimgBox li").click(function(){
    $(".mske_html").html($(this).find(".hidden").html());
    $(".mskeLayBg").show();
    $(".mskelayBox").fadeIn(300)
});
$(".mskeTogBtn").click(function(){
    $(".msKeimgBox").toggleClass("msKeimgBox2");
    $(this).toggleClass("mskeTogBtn2")});
})
//屏蔽页面错误
jQuery(window).error(function(){
  return true;
});

jQuery("img").error(function(){
  $(this).hide();
});



$("[name='btnDeletebst']").click(function(event) {
    var sure=confirm('你确定要删除吗?');

    if (sure==true){
        var bstid=$("#bstid").val();
        var cpage=$("[name='page']").val();

        var url="src/bstdele.php";

        $.post(url,
            {
                bstid:bstid,
            },
            function(data,status){
                if (data==="success"){
                    window.location.href="bst.php?page="+cpage;
                }
            });
    }
});

