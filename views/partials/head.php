<!doctype html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>Demo</title>
    <link rel="stylesheet" href="/resources/style.css">

</head>

<body>
    <header class="header">
        <a href="/login" class="logo">Login</a>

        <i class='bx bx-menu' id="menu-icon"></i>

        <nav class="navbar">
            <a class="<?= urlIs(value: '/') ? 'active' : '' ?>" href="/">Home</a>
            <a class="<?= urlIs(value: '/event') ? 'active' : '' ?>" href="/event">Events</a>
            <a class="<?= urlIs('/location') ? 'active' : '' ?>" href="/location">Locations</a>
            <a class="<?= urlIs('/participant') ? 'active' : '' ?>" href="/participant">Participants</a>

            <a class="<?= urlIs('/event-participant') ? 'active' : '' ?>" href="/event-participant">Event Participants</a>
            <a class="<?= urlIs('/user') ? 'active' : '' ?>" href="/user">Users</a>
        </nav>
    </header>
    <!-- <div class="nav-bg"></div> -->

    <div class="section-header head">
    <h2><?= $title ?></h2>
    <p><?= $subTitle?></p>
</div>
