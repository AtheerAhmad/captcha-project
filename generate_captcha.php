<?php
session_start();

// Number of characters in CAPTCHA
$length = 6;

// Generate a random CAPTCHA string
$captcha_code = substr(generateString($length), 0, $length);
$_SESSION['captcha'] = $captcha_code;

// Image dimensions
$width = 150;
$height = 50;
$image_captcha = imagecreatetruecolor($width, $height);

// Colors
$bg_color = imagecolorallocate($image_captcha, 255, 255, 255); // white
$text_color = imagecolorallocate($image_captcha, 0, 0, 0);      // black
$pixel_color = imagecolorallocate($image_captcha, 0, 0, 255);   // blue dots
$line_color = imagecolorallocate($image_captcha, 0, 0, 64);     // dark blue lines

// Fill background
imagefill($image_captcha, 0, 0, $bg_color);

// Add random dots
for ($i = 0; $i < 200; $i++) {
    imagesetpixel($image_captcha, rand() % $width, rand() % $height, $pixel_color);
}

// Add random lines
for ($i = 0; $i < 4; $i++) {
    imageline($image_captcha, 0, rand() % $height, $width, rand() % $height, $line_color);
}

// Font settings
$local_font = __DIR__ . '/fonts/Roboto-Regular.ttf';
$system_font = '/System/Library/Fonts/Supplemental/Arial.ttf';
$font_path = file_exists($local_font) ? $local_font : (file_exists($system_font) ? $system_font : null);

$font_size = 20;

// Measure the text box
$bbox = imagettfbbox($font_size, 0, $font_path, $captcha_code);
$text_width = $bbox[2] - $bbox[0];
$text_height = $bbox[1] - $bbox[7];

// Calculate center coordinates
$x = ($width - $text_width) / 2;
$y = ($height + $text_height) / 2;

// Draw the text
imagettftext($image_captcha, $font_size, 0, $x, $y, $text_color, $font_path, $captcha_code);

// Output image
header("Content-Type: image/jpeg");
imagejpeg($image_captcha);
imagedestroy($image_captcha);

// Function to generate random string
function generateString($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789[{(!@#$%^/&*_+;?:)}]";
    $charLength = strlen($chars);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $chars[rand(0, $charLength - 1)];
    }
    return $randomString;
}
?>
