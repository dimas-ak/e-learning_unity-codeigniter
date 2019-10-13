<div class="cols">
    <div class="col-10">
        <h2>MAHASISWA</h2>
    </div>
    <div class="cols">
        <h2>TAMBAH KELAS</h2>
        <?PHP echo flashdata('success'); ?>
        <div class="cols cf">
            <div class="col-5 f-left">
                <?PHP echo $form ?>
                    <div class="f-input">
                        <span>Nama Kelas</span>
                        <?PHP echo form_error('nama') ?>
                        <input name="nama" placeholder="Masukkan Nama Kelas...">
                    </div>
                    <button class="btn blue">SIMPAN</button>
                <?PHP echo form_close(); ?>
            </div>
        </div>
        <div class="cols cf">
            <div class="col-10">
                <h2>Info Kelas</h2>
            </div>
            <?PHP foreach($kelas as $kel): ?>
                <div class="col-10 cf">
                    <div class="col-5 f-left" style="border-bottom: 2px solid #444">
                        <span><?PHP echo $kel->name ?></span>
                    </div>
                    <div class="col-5 f-left">
                        <a class="btn red" href="<?PHP echo $hapus_kelas . $kel->id?>">HAPUS</a>
                    </div>
                </div>
            <?PHP endforeach; ?>
        </div>
    </div>
    <div class="col-10">
        <a href="<?PHP echo $add ?>" class="btn green">TAMBAH MAHASISWA</a>
    </div>
    <div class="evaluasi"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".evaluasi").table({
            url: "<?PHP echo $url ?>",
            thead: ["ID Mahasiswa", "Kelas", "Nama", "NIM"],
            search: [
                { index: 1, type: "input", placeholder: "Search Kelas..."},
                { index: 2, type: "input", placeholder: "Search Nama..."},
                { index: 3, type: "input", placeholder: "Search NIM..."},
            ],
            // array_info: { index: 1, value: { 
            //     1: "BAB I",
            //     2: "BAB II",
            //     3: "BAB III",
            //     4: "BAB IV"
            // }},
            hidden_index: [0],
            theadFixed: true,
            theadFixedTop: 53,
            order_by: [0, "ASC"],
            action: {
                edit:{
                    url: "<?PHP echo $edit ?>",
                    id : 0,
                },
                del:{
                    url: "<?PHP echo $delete ?>",
                    id : 0,
                    field: 1,
                    msg: "Do you really want to delete this %s?"
                }
            }
        });
    });
    
</script>