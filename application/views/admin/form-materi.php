<div class="cols">
    <div class="col-10">
        <h2>FORM MATERI</h2>
    </div>
    <div class="cols">
        <?PHP 
            echo flashdata('success');
            echo $form
        ?>
            <div class="col-10">
                <div class="f-input">
                    <span>Judul Materi</span>
                    <?PHP echo form_error('judul'); ?>
                    <input placeholder="Masukkan Judul Materi..." name="judul" value="<?PHP echo $materi['name'] ?>">
                </div>
                <div class="f-input">
                    <span>Photo Materi <label class="no-required">(Boleh kosong)</label></span>
                    <input name="photo" accept="image/x-png,image/gif,image/jpeg" type="file">
                    <?PHP if($materi['photo_materi'] != NULL): ?>
                    <div class="preview-photo">
                        <a class="btn red" title="Hapus Photo?" href="<?PHP echo $hapus_photo . $materi['id'] ?>">X</a>
                        <img src="<?PHP echo photo_materi($materi['photo_materi']) ?>" alt="<?PHP echo $materi['name'] ?>">
                    </div>
                    <?PHP endif; ?>
                </div>
                <div class="f-input">
                    <span>Video Materi <label class="no-required">(Boleh kosong)</label></span>
                    <input name="video" type="text" value="<?PHP echo $materi['video_materi'] ?>" placeholder="Masukkan ID Link Video...">
                </div>
                <div class="f-input">
                    <span>Materi</span>
                    <?PHP echo form_error('materi'); ?>
                    <textarea name="materi" placeholder="Masukkan Materi..." cols="30" rows="10"><?PHP echo $materi['text'] ?></textarea>
                </div>
                <div class="f-input">
                    <span>Durasi Waktu <label class="no-required">(Dalam Menit, Contoh: 15)</label></span>
                    <?PHP echo form_error('duration'); ?>
                    <input placeholder="Masukkan Durasi Waktu Pengerjaan Soal..." name="duration" value="<?PHP echo $materi['duration'] ?>">
                </div>
            </div>
            <div class="col-10 center">
                <button class="btn green">SIMPAN</button>
                <a href="<?PHP echo $back ?>" class="btn blue">KEMBALI</a>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        tinymce.init({
            selector: 'textarea',
            height: 300,
            theme: 'modern',fileBrowserCallBack : "fileBrowserCallBack",
            toolbar: 'fontsizeselect',
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            forced_root_block: 'div',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    });
</script>