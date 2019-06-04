<?php
$message = $data['error'];
?>
<div id="background"></div>
<div class="top">
    <h1 class="h1-404">500</h1>
    <h3 class="h3-404">unexpected error</h3>
</div>
<div class="container-ghost">
    <div class="ghost-copy">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
        <div class="four"></div>
    </div>
    <div class="ghost">
        <div class="face">
            <div class="eye"></div>
            <div class="eye-right"></div>
            <div class="mouth-sad"></div>
        </div>
    </div>
    <div class="shadow"></div>
</div>
<div class="bottom">
    <p class="p-404">Произошла ошибка: <?=$message?></p>
</div>

