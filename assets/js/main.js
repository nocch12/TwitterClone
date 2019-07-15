{
    'use strict';

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

}