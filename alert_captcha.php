<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Default empty alert
$captchaError = ["status" => "", "alert" => ""];

// Only process if form is submitted
if (isset($_POST['submit'])) {
    $captcha_text = trim($_POST['captcha'] ?? '');

    if ($captcha_text === '') {
        $captchaError = [
            "status" => "alert-danger",
            "alert" => "Please enter the characters in the image."
        ];
    } elseif ($_SESSION['captcha'] === $captcha_text) {
        $captchaError = [
            "status" => "alert-success",
            "alert" => "Correct CAPTCHA!"
        ];
    } else {
        $captchaError = [
            "status" => "alert-warning",
            "alert" => "Invalid CAPTCHA, please try again."
        ];
    }
}
?>
