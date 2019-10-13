$(document).ready(function () {
    var click = "click";
    $(document).on(click, '.form-error', function () {
        $(this).remove();
    });
    $(document).on(click, '.hapus-video', function (x) {
        x.preventDefault();
        if(confirm("Apakah Anda yakin ingin menghapus Video tersebut?"))
        {
            var ini = $(this),
                url = ini.attr('href'),
                preview = $('.form-video'); 
            $.ajax({
                url: url,
                type: "POST",
                success: function (data) 
                {
                    var json = JSON.parse(data);
                    if(json.success)
                    {
                        preview.remove();
                    }
                }
            });
        }
    });
    $(document).on(click, '.preview-photo a', function (x) {
        x.preventDefault();
        if(confirm("Apakah Anda yakin ingin menghapus photo tersebut?"))
        {
            var ini = $(this),
                url = ini.attr('href'),
                preview = ini.parent(); 
            $.ajax({
                url: url,
                type: "POST",
                success: function (data) 
                {
                    var json = JSON.parse(data);
                    if(json.success)
                    {
                        preview.remove();
                    }
                }
            });
        }
    });
});