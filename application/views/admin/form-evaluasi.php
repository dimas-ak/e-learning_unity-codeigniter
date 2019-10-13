<div class="cols">
    <div class="col-10">
        <h2>FORM EVALUASI</h2>
    </div>
    <div class="cols">
        <?PHP 
        echo validation_errors();
            echo flashdata('error');
            echo flashdata('success');
            echo $form 
        ?>
            <div class="col-10">
                <div class="f-input">
                    <span>Pertanyaan / Soal</span>
                    <?PHP echo form_error('soal'); ?>
                    <textarea name="soal" placeholder="Masukkan Pertanyaan / Soal..." cols="30" rows="10"><?PHP echo $soal ?></textarea>
                </div>
                <div class="f-input">
                    <div class="col-5">
                        <span>Photo Soal</span>
                        <input type="file" name="photo_soal" accept="image/x-png,image/gif,image/jpeg">
                        <?PHP if($photo_soal != NULL): ?>
                        <div class="preview-photo">
                            <a class="btn red" title="Hapus Photo?" href="<?PHP echo $hapus_photo_soal . $evaluasi['id'] ?>">X</a>
                            <img src="<?PHP echo photo_soal($photo_soal) ?>" alt="<?PHP echo $soal ?>">
                        </div>
                        <?PHP endif; ?>
                    </div>
                </div>
                <div class="f-input">
                    <div class="col-5">
                        <span>Soal untuk Materi BAB</span>
                        <?PHP echo form_error('materi'); ?>
                        <select name="materi">
                            <option value="">Pilih Materi</option>
                            <?PHP foreach($materi as $m): ?>
                            <option <?PHP echo selected($m->id, $val_materi) ?> value="<?PHP echo $m->id ?>"><?PHP echo $m->name ?></option>
                            <?PHP endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="f-input">
                    <div class="col-5">
                        <span>Tipe Jawaban</span>
                        <?PHP echo form_error('type_jawaban'); ?>
                        <select name="type_jawaban" id="type-jawaban">
                            <option value="">Pilih Tipe</option>
                            <option <?PHP echo selected($type_jawaban, "1") ?> value="1">ABCDE</option>
                            <option <?PHP echo selected($type_jawaban, "2") ?> value="2">Essay</option>
                        </select>
                    </div>
                </div>
                <?PHP $dis_abc = $type_jawaban == 1 ? "dis-block" : "dis-none" ?>
                <div class="f-input abc <?PHP echo $dis_abc ?>">
                    <div class="col-10">
                        <strong>Jawaban ABC :</strong>
                    </div>
                    <div class="cols cf">
                        <div class="col-5 f-left jawaban">
                            <span>Jawaban A:</span>
                            <input name="opsi_a" type="text" value="<?PHP echo $opsi_a ?>">
                            <span>Jawaban B:</span>
                            <input name="opsi_b" type="text" value="<?PHP echo $opsi_b ?>">
                            <span>Jawaban C:</span>
                            <input name="opsi_c" type="text" value="<?PHP echo $opsi_c ?>">
                            <span>Jawaban D:</span>
                            <input name="opsi_d" type="text" value="<?PHP echo $opsi_d ?>">
                        </div>
                        <div class="col-5 f-left">
                            <span>Pilih Jawaban Yang Benar.</span>
                            <input type="radio" name="jawaban_abc" <?PHP echo checked($jawaban_abc, 0) ?> value="0"><label>A</label>
                            <input type="radio" name="jawaban_abc" <?PHP echo checked($jawaban_abc, 1) ?> value="1"><label>B</label>
                            <input type="radio" name="jawaban_abc" <?PHP echo checked($jawaban_abc, 2) ?> value="2"><label>C</label>
                            <input type="radio" name="jawaban_abc" <?PHP echo checked($jawaban_abc, 3) ?> value="3"><label>D</label>
                        </div>
                    </div>
                </div>
                <?PHP $dis_essay = $type_jawaban == 2 ? "dis-block" : "dis-none" ?>
                <div class="f-input essay <?PHP echo $dis_essay ?>">
                    <div class="col-5">
                        <span>Jawaban Essay</span>
                        <input placeholder="Masukkan Jawaban Essay yang benar..." name="essay" value="<?PHP echo $essay?>">
                    </div>
                </div>
                <div class="f-input">
                    <span>Pembahasan Pertanyaan / Soal</span>
                    <?PHP echo form_error('pembahasan'); ?>
                    <textarea id="pembahasan" name="pembahasan" placeholder="Masukkan Pembahasan Pertanyaan / Soal..." cols="30" rows="10"><?PHP echo $pembahasan ?></textarea>
                </div>
                <div class="f-input">
                    <div class="col-5">
                        <span>Photo Pembahasan</span>
                        <input type="file" name="photo_pembahasan" accept="image/x-png,image/gif,image/jpeg">
                        <?PHP if($photo_pembahasan != NULL): ?>
                        <div class="preview-photo">
                            <a class="btn red" title="Hapus Photo?" href="<?PHP echo $hapus_photo_pembahasan . $evaluasi['id'] ?>">X</a>
                            <img src="<?PHP echo photo_pembahasan($photo_pembahasan) ?>" alt="<?PHP echo $pembahasan ?>">
                        </div>
                        <?PHP endif; ?>
                    </div>
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

        $('#type-jawaban').on('change', function () {
            var ini             = $(this),
                val             = ini.val(),
                abc             = $('.abc'),
                essay           = $('.essay'),
                jawaban_essay   = $('.essay input'),
                jawaban_abc     = $('.jawaban input');
            // opsi pilih ABC
            if(val === "1")
            {
                abc.removeClass('dis-none');
                abc.addClass('dis-block');

                essay.removeClass('dis-block');
                essay.addClass('dis-none');
            }
            // OPSI Pilih essay
            else if(val === "2")
            {
                essay.removeClass('dis-none');
                essay.addClass('dis-block');

                abc.removeClass('dis-block');
                abc.addClass('dis-none');
            }
            // tidak sama sekali
            else
            {
                essay.removeClass('dis-block');
                essay.addClass('dis-none');

                abc.removeClass('dis-block');
                abc.addClass('dis-none');
            }
            
            // clear radio button
            $('input[name=jawaban_abc]').attr('checked',false);
            for(var i = 0; i < jawaban_abc.length; i++)
            {
                jawaban_abc.eq(i).val("");
            }
            jawaban_essay.val("");
        });

        $('#form-evaluasi').on("submit", function () {
            
            var jawaban_abc     = $('.jawaban input'),
                tipe            = $('#type-jawaban'),
                jawaban_essay   = $('.essay input');
            
            if(tipe.val() === "1")
            {
                for(var i = 0; i < jawaban_abc.length; i++)
                {
                    var ini = jawaban_abc.eq(i);
                    if(ini.val().trim().length === 0) 
                    {
                        alert("Harap semua jawaban ABCDE di isi.");
                        return false;
                    }
                }
                if(!$('input[name=jawaban_abc]').is(":checked"))
                {
                    alert("Harap pilih jawaban yang benar.");
                    return false;
                }
            }
            else if(tipe.val() === "2")
            {
                if(jawaban_essay.val().trim().length === 0) 
                {
                    alert("Harap essay di isi.");
                    return false;
                }
            }
            
        });

        
        tinymce.init({
            selector: '#pembahasan',
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