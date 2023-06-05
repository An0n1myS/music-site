<?php

$conn = new mysqli("localhost", "root", "", "music_database");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$url = isset($_GET['url']) ? $_GET['url'] : 'home';

switch ($url) {
    case 'home':
        include('includes/header.php');
        include('pages/home.php');
        include('includes/footer.php');

        break;
    case 'add-song':
        include('includes/header.php');
        include('pages/add_song.php');
        include('includes/footer.php');

        break;
    case 'login':
        include('includes/header.php');
        include('includes/log-forms.php');
        include('includes/footer.php');

        break;
    case 'register':
        include('includes/header.php');
        include('includes/reg-forms.php');
        include('includes/footer.php');

        break;
    case 'profile':
        include('includes/header.php');
        include('pages/profile.php');
        include('includes/footer.php');

        break;
    case 'genres':
        include('includes/header.php');
        include('pages/genres.php');
        include('includes/footer.php');

        break;
    case 'artists':
        include('includes/header.php');
        include('pages/artists.php');
        include('includes/footer.php');

        break;
    default:
        include('includes/header.php');
        include('pages/home.php');
        include('includes/footer.php');
        break;
}
?>



