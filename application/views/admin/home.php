<div class="cols">
    <h2>BERANDA</h2>
    <div class="cols">
        <div class="cols center" style="font-size:20pt">
            <h1>SELAMAT DATANG ADMINISTRATOR</h1>
        </div>
        <div class="col center">
            <img style="width:300px;" src="<?PHP echo photo_main("arjunane.png") ?>" alt="Arjunane">
        </div>
        
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            url: "<?PHP echo $url?>",
            type: "POST",
            success: function (data) {
                var json = JSON.parse(data);
                console.log(json);
            }
        });
    });
</script>