jQuery(function($){

    var switcher = ' \
        <form> \
            <div id="uxms-backend-theme-setting"> \
                <a href="#"><i class="icon-gears icon-2x"></i></a> \
                <ul> \
                    <li> \
                        <span>Backend Skin</span> \
                    </li> \
                    <li> \
                        <select class="colors" name="skin"> \
                            <option value="default">-- Default --</option> \
                            <option value="Disco">Disco</option> \
                            <option value="Material">Material</option> \
                            <option value="Church">Church</option> \
                            <option value="BlueLight">BlueLight</option> \
                            <option value="OrangeDark">OrangeDark</option> \
                            <option value="OrangeLight">OrangeLight</option> \
                        </select> \
                        <a \
                            href="javascript:;"  \
                            style="margin-left: 15px;"  \
                            data-request="onChangeSkin"  \
                            class="btn btn-default"> \
                            Apply \
                        </a> \
                    </li> \
                </ul> \
            </div> \
        </form> \
    ';

    $("body").append(switcher);

    // Toggle showing theme setting box
    $("#uxms-backend-theme-setting > a").click(function(){
        $(this).next().animate({width:'toggle'}, 500, function(){
            if ($(this).is(":hidden")) {
                $('#uxms-backend-theme-setting > a > i').attr('class', 'icon-gears icon-2x');
            } else {
                $('#uxms-backend-theme-setting > a > i').attr('class', 'icon-times icon-2x');
            }
        });
        $(this).next().css('display', 'inline-block');
    });
});
