<div class="cols">
    <div class="col-10">
        <h2>MATERI</h2>
    </div>
    <div class="cols cf">
        <?PHP foreach($materi as $m): ?>
            <a href="<?PHP echo $url . $m->id ?>" class="btn blue f-left"><?PHP echo $m->name ?></a>
        <?PHP endforeach; ?>
    </div>
</div>