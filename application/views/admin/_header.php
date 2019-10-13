<header>

    <?PHP $menu = '<div class="menu">AKUN<div class="sub">'?>
    <?PHP foreach($link as $l): ?>

    <?PHP $aktif = uri_segment(2) == $l[2] ? " aktif" : ""?>

        <?PHP if($l[0] == "KELOLA AKUN" || $l[0] == "UBAH PASSWORD"): ?>

            <?PHP $menu .= '<a href="' . $l[1] . '">' . $l[0] . '</a>' ?>

        <?php elseif($l[0] == "NILAI"): ?>
            <?PHP 
            
            $menu .= '</div></div>';
            echo $menu;

             ?>
            <a href="<?PHP echo $l[1] ?>" class="menu <?PHP echo $aktif ?>"><?PHP echo $l[0] ?></a>

        <?PHP else: ?>

            <a href="<?PHP echo $l[1] ?>" class="menu <?PHP echo $aktif ?>"><?PHP echo $l[0] ?></a>

        <?PHP endif; ?>
    <?PHP endforeach; ?>
</header>