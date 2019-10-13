<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style type="text/css">
        table{border-collapse: collapse;}
    </style>
    <title>Evaluasi | <?PHP echo $evaluasi['soal'] ?></title>
</head>
<body>
    <div class="cols">
        <div class="col-10">
            <strong>Soal Evaluasi : </strong>
            <span><?PHP echo $evaluasi['soal'] ?></span>
        </div>
        <div class="col-10 center">
            <img src="<?PHP echo photo_pembahasan($evaluasi['photo_pembahasan'])?>">
        </div>
        <div class="col-10">
            <?PHP echo $evaluasi['pembahasan'] ?>
        </div>
    </div>
</body>
</html>