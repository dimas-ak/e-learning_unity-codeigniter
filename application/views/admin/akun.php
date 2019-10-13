<div class="cols">
    <div class="col-10">
        <h2>PENGATURAN AKUN</h2>
    </div>
    <div class="cols cf">
        <?PHP echo $form ?>
            <?PHP if(!userdata('akun')): ?>
                <div class="col-5">
                    <div class="f-input">
                        <span>Username Lama</span>
                        <?PHP echo form_error('username_lama') ?>
                        <input placeholder="Masukkan Username Lama" name="username_lama">
                    </div>
                </div>
                <div class="col-5">
                    <div class="f-input">
                        <span>Password Lama</span>
                        <?PHP echo form_error('password_lama') ?>
                        <input placeholder="Masukkan Password Lama" name="password_lama">
                    </div>
                </div>
            <?PHP else: ?>
                <div class="col-5">
                    <div class="f-input">
                        <span>Username Baru</span>
                        <?PHP echo form_error('username_baru') ?>
                        <input placeholder="Masukkan Username Lama" name="username_baru">
                    </div>
                </div>
                <div class="col-5">
                    <div class="f-input">
                        <span>Password Baru</span>
                        <?PHP echo form_error('password_baru') ?>
                        <input placeholder="Masukkan Password Baru" name="password_baru">
                    </div>
                </div>
                <div class="col-5">
                    <div class="f-input">
                        <span>Password Baru</span>
                        <?PHP echo form_error('password_baru') ?>
                        <input placeholder="Masukkan Password Baru" name="password_baru">
                    </div>
                </div>
            <?PHP endif; ?>
            <div class="cols center">
                <button class="btn green"><?PHP echo userdata("akun") ? "SIMPAN" : "SUBMIT" ?></button>
            </div>
        </form>
    </div>
</div>