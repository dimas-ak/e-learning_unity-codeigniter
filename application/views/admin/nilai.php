<div class="cols">
    <div class="col-10">
        <h2>NILAI MAHASISWA</h2>
    </div>
    <div class="cols">
        <h2>PENCARIAN BERDASARKAN KELAS.</h2>
        <?PHP echo flashdata('success'); ?>
        <div class="cols cf">
            <div class="col-5 f-left">
                <?PHP echo $form ?>
                    <div class="f-input">
                        <span>Pilih Kelas</span>
                        <select name="kelas" id="kelas">
                            <option value="0" <?PHP echo selected(0, $id_kelas) ?>>Semua</option>
                            <?PHP foreach($kelas as $kel): ?>
                                <option value="<?PHP echo $kel->id ?>" <?PHP echo selected($kel->id, $id_kelas) ?>><?PHP echo $kel->name ?></option>
                            <?PHP endforeach; ?>
                        </select>
                    </div>
                    <button class="btn blue">CARI</button>
                <?PHP echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="mahasiswa"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".mahasiswa").table({
            url: "<?PHP echo $url ?>",
            thead: ["ID Mahasiswa", "Nama", "NIM", "Kelas", "BAB I", "BAB II", "BAB III", "BAB IV"],
            search: [
                { index: 1, type: "input", placeholder: "Search Nama..."},
                { index: 2, type: "input", placeholder: "Search NIM..."},
                { index: 3, type: "input", placeholder: "Search Kelas..."},
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
                    url: "<?PHP echo $detail ?>",
                    id : 0,
                    text: "detail"
                }
            }
        });
    });
    
</script>