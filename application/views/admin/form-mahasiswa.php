<div class="cols">
    <div class="col-10">
        <h2>FORM MAHASISWA</h2>
    </div>
    <div class="cols">
        <?PHP 
            echo flashdata('success');
            echo $form
        ?>
            <div class="col-10">
                <div class="f-input">
                    <span>Nama Mahasiswa</span>
                    <?PHP echo form_error('name'); ?>
                    <input placeholder="Masukkan Nama Mahasiswa..." name="name" value="<?PHP echo $name ?>">
                </div>
                <div class="f-input">
                    <span>Kelas</span>
                    <?PHP echo form_error('id_kelas'); ?>
                    <select name="id_kelas">
                        <option value="">Pilih Kelas</option>
                        <?PHP foreach($kelas as $kelas): ?>
                            <option <?PHP echo selected($kelas->id, $id_kelas)?> value="<?PHP echo $kelas->id ?>"><?PHP echo $kelas->name ?></option>
                        <?PHP endforeach; ?>
                    </select>
                </div>
                <div class="f-input">
                    <span>NIM Mahasiswa</span>
                    <?PHP echo form_error('nim'); ?>
                    <input placeholder="Masukkan NIM Mahasiswa..." name="nim" value="<?PHP echo $nim ?>">
                </div>
                <div class="f-input">
                    <span>Password</span>
                    <?PHP echo form_error('password'); ?>
                    <input placeholder="Masukkan Password Mahasiswa..." name="password" value="<?PHP echo $password ?>">
                </div>
            </div>
            <div class="col-10 center">
                <button class="btn green">SIMPAN</button>
                <a href="<?PHP echo $back ?>" class="btn blue">KEMBALI</a>
            </div>
        </form>
    </div>
</div>