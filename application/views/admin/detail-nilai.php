<div class="cols">
    <div class="col-10">
        <h2>NILAI MAHASISWA :</h2>
    </div>
    <div class="cols cf">
        <div class="col-5">
            <div class="col-10">
                <strong>Nama : </strong>
                <span><?PHP echo $mahasiswa['name'] ?></span>
            </div>
        </div>
        <div class="col-5">
            <div class="col-10">
                <strong>NIM : </strong>
                <span><?PHP echo $mahasiswa['nim'] ?></span>
            </div>
        </div>
        <div class="col-5">
            <div class="col-10">
                <strong>Kelas : </strong>
                <span><?PHP echo $mahasiswa['nama_kelas'] ?></span>
            </div>
        </div>
        <div class="cols">
            <div class="col-10">
                <?PHP echo flashdata('success'); ?>
            </div>
            <?PHP echo $form ?>
                <?PHP for($i = 1; $i <= 4; $i++) {?>
                <div class="col-10 cf" style="border-bottom: 1px solid #444;">
                    <div class="col-5 f-left">
                        <div class="col-10">
                            <strong>Nilai BAB <?PHP echo $i ?> : </strong>
                            <span><?php echo $mahasiswa['nilai_bab_' . $i] ?></span>
                        </div>
                    </div>
                    <div class="col-5 f-left">
                        <div class="f-input">
                            <span>Update Nilai BAB <?PHP echo $i ?></span>
                            <?PHP echo form_error('nilai_bab_' . $i); ?>
                            <input type="text" name="nilai_bab_<?PHP echo $i ?>" value="<?php echo $mahasiswa['nilai_bab_' . $i] ?>">
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <div class="col-10 center">
                    <button class="btn green">SIMPAN</button>
                    <a href="<?PHP echo $back ?>" class="btn blue">KEMBALI</a>
                </div>
            </form>
        </div>
    </div>
</div>