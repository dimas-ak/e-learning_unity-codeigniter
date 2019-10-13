<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style type="text/css">
        table{border-collapse: collapse;}
    </style>
    <title>Materi | <?PHP echo $materi['name'] ?></title>
</head>
<body>
    <div class="cols">
        <div class="col-10" style="margin-bottom:20px;">
            <button onclick="Export2Doc('exportContent', '<?PHP echo $materi['name'] ?>')" style="padding:10px;">DOWNLOAD <strong>[ <?php echo $materi['name'] ?> ]</strong></button>
        </div>
    </div>
    <?PHP if($materi['video_materi'] != NULL):?>
        <div class="col-10 center">
            <strong>Video Materi : </strong><br>
            <iframe width="420" height="340" src="//www.youtube.com/embed/<?PHP echo $materi['video_materi'] ?>" frameborder="0" allowfullscreen>
            </iframe>
        </div>
    <?PHP endif; ?>
    <div class="cols" id="exportContent">
        <div class="col-10">
            <strong>Materi : </strong>
            <span><?PHP echo $materi['name'] ?></span>
        </div>
        <div class="col-10 center">
            <img src="<?PHP echo photo_materi($materi['photo_materi'])?>">
        </div>
        <div class="col-10">
            <?PHP echo $materi['text'] ?>
        </div>
    </div>
    <script type="text/javascript">var close = "</body>";</script>
    <script type="text/javascript">
            
        function Export2Doc(element, filename = ''){
            var head = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
            var close2 = '</body></html>';
            var html = head+document.getElementById(element).innerHTML + close2;

            var blob = new Blob(['\ufeff', html], {
                type: 'application/msword'
            });
            
            // Specify link url
            var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
            
            // Specify file name
            filename = filename?filename+'.doc':'document.doc';
            
            // Create download link element
            var downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);
            
            if(navigator.msSaveOrOpenBlob ){
                navigator.msSaveOrOpenBlob(blob, filename);
            }else{
                // Create a link to the file
                downloadLink.href = url;
                
                // Setting the file name
                downloadLink.download = filename;
                
                //triggering the function
                downloadLink.click();
            }
            
            document.body.removeChild(downloadLink);
        }
    </script>
</body>
</html>