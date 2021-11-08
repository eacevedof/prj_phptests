<?php
/*
 * @file: toast_raw.php
 * @info: Crea toast desde 0
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Toast raw</title>
</head>
<body>
<!-- toast -->
<div class="notification-container top-right">
    <div class="notification toast-raw top-right" style="background-color: rgb(92, 184, 92);">
        <button>X</button>
        <div class="notification-image">
            <img src="/images/toast_raw/check.svg" alt="">
        </div>
        <div>
            <p class="notification-title">Success</p>
            <p class="notification-message">This is a success toast component</p>
        </div>
    </div>
</div>

<script type="module">
</script>
<style>
@import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');
body {
    margin: 0;
    font-family: 'Roboto', 'sans-serif';
}

.notification-container {
    font-size: 14px;
    box-sizing: border-box;
    position: fixed;
    z-index: 10;
}

.top-right {
    top: 12px;
    right: 12px;
    transition: transform .6s ease-in-out;
    animation: toast-in-right .7s;
}

.bottom-right {
    bottom: 12px;
    right: 12px;
    transition: transform .6s ease-in-out;
    animation: toast-in-right .7s;
}

.top-left {
    top: 12px;
    left: 12px;
    transition: transform .6s ease-in;
    animation: toast-in-left .7s;
}

.bottom-left {
    bottom: 12px;
    left: 12px;
    transition: transform .6s ease-in;
    animation: toast-in-left .7s;
}

.notification {
    background: #fff;
    transition: .3s ease;
    position: relative;
    pointer-events: auto;
    overflow: hidden;
    margin: 0 0 6px;
    padding: 30px;
    margin-bottom: 15px;
    width: 300px;
    max-height: 100px;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 0 10px #999;
    color: #000;
    opacity: .9;
    background-position: 15px;
    background-repeat: no-repeat;
}

.notification:hover {
    box-shadow: 0 0 12px #fff;
    opacity: 1;
    cursor: pointer
}

.notification-title {
    font-weight: 700;
    font-size: 16px;
    text-align: left;
    margin-top: 0;
    margin-bottom: 6px;
    width: 300px;
    height: 18px;
}

.notification-message {
    margin: 0;
    text-align: left;
    height: 18px;
    margin-left: -1px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.notification-image {
    float: left;
    margin-right: 15px;
}

.notification-image img {
    width: 30px;
    height: 30px;
}

.toast-raw {
    width: 365px;
    color: #fff;
    padding: 15px 15px 15px 10px;
}

.notification-container button {
    position: relative;
    right: -.3em;
    top: -.3em;
    float: right;
    font-weight: 700;
    color: #fff;
    outline: none;
    border: none;
    text-shadow: 0 1px 0 #fff;
    opacity: .8;
    line-height: 1;
    font-size: 16px;
    padding: 0;
    cursor: pointer;
    background: 0 0;
    border: 0
}

@keyframes toast-in-right {
    from {
        transform: translateX(100%);

    }
    to {
        transform: translateX(0);
    }
}

@keyframes toast-in-left {
    from {
        transform: translateX(-100%);

    }
    to {
        transform: translateX(0);
    }
}
</style>
</body>
</html>