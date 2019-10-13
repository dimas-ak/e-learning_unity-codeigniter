<div class="cols">
    <div class="col-10">
        <h2>EVALUASI</h2>
    </div>
    <div class="col-10">
        <a href="<?PHP echo $add ?>" class="btn green">TAMBAH SOAL</a>
    </div>
    <div class="evaluasi"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".evaluasi").table({
            url: "<?PHP echo $url ?>",
            thead: ["ID Soal", "BAB Materi", "Pertanyaan", "Jawaban"],
            search: [
                { index: 1, type: "select", value: [
                    ["", "Semua"], 
                    [1, "BAB I"],
                    [2, "BAB II"],
                    [3, "BAB III"],
                    [4, "BAB IV"]
                ]},
                { index: 2, type: "input", placeholder: "Search Pertanyaan..."},
                { index: 3, type: "select", value: [
                    ["", "Semua"], 
                    ["Essay", "Essay"],
                    ["ABC", "ABC"],
                ]}
            ],
            array_info: { index: 1, value: { 
                1: "BAB I",
                2: "BAB II",
                3: "BAB III",
                4: "BAB IV"
            }},
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