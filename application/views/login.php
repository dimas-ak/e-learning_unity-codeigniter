<div class="col cf">
    <div class="col-5 m-auto">
        <?PHP   echo flashdata("error");
                echo $form 
        ?>
            <div class="cols center">
                <strong>LOGIN</strong>
            </div>
            <div class="f-input">
                <span>Username</span>
                <?PHP echo form_error('username') ?>
                <input name="username" placeholder="Masukkan Username...">
            </div>
            <div class="f-input">
                <span>Password</span>
                <?PHP echo form_error('password') ?>
                <input name="password" placeholder="Masukkan Password..." type="password">
            </div>
            <div class="col center">
                <button class="btn blue">LOGIN</button>
            </div>
        <form>
    </div>
</div>