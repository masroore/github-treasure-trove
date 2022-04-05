<div id="hd_pop">
        <h2>팝업레이어 알림</h2>
    
    
        <div id="hd_pops_1" class="hd_pops" style="top:450px;left:50px">
            <div class="hd_pops_con" style="width:320px;height:220px">
                <p><a href="http://betmoa03.com" rel="nofollow"><img src="/data/editor/1910/702b6777ffc88b023a965d10aa5658c1_1572363446_7876.gif" title="702b6777ffc88b023a965d10aa5658c1_1572363446_7876.gif" alt="702b6777ffc88b023a965d10aa5658c1_1572363446_7876.gif" /></a><br style="clear:both;" /> </p>        </div>
            <div class="hd_pops_footer">
                <button class="hd_pops_reject hd_pops_1 4"><strong>4</strong>시간 동안 다시 열람하지 않습니다.</button>
                <button class="hd_pops_close hd_pops_1">닫기</button>
            </div>
        </div>
    </div>
    
    <script>
    $(function() {
        $(".hd_pops_reject").click(function() {
            var id = $(this).attr('class').split(' ');
            var ck_name = id[1];
            var exp_time = parseInt(id[2]);
            $("#"+id[1]).css("display", "none");
            set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
        });
        $('.hd_pops_close').click(function() {
            var idb = $(this).attr('class').split(' ');
            $('#'+idb[1]).css('display','none');
        });
        $("#hd").css("z-index", 1000);
    });
    </script>
    <!-- } 팝업레이어 끝 -->
    