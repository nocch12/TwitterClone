{
    'use strict';

    // textareaの高さを可変にする
    $(function () {

        $("#ta").height(28);//init
        $("#ta").css("lineHeight", "20px");//init

        $("#ta").on("input", function (evt) {
            if (evt.target.scrollHeight > evt.target.offsetHeight) {
                $(evt.target).height(evt.target.scrollHeight);
            } else {
                var lineHeight = Number($(evt.target).css("lineHeight").split("px")[0]);
                while (true) {
                    $(evt.target).height($(evt.target).height() - lineHeight);
                    if (evt.target.scrollHeight > evt.target.offsetHeight) {
                        $(evt.target).height(evt.target.scrollHeight);
                        break;
                    }
                }
            }
        });
    });


    $(function () {
        let $goodBtn = $('.good_btn');
        let cancelFlg = 0;

        $goodBtn.on('click', function () {
            if (cancelFlg === 0) {
                cancelFlag = 1;
                let $this = $(this);
                let $postId = $(this).data('id');

                $.post("_ajaxGood.php", { postId: $postId }, function (res) {
                    console.log(res);
                    $this.toggleClass('active');
                }).fail(function () {
                    console.log('err');
                });


                setTimeout(function () {
                    cancelFlag = 0;
                }, 10000);
            };
        });
    });

}