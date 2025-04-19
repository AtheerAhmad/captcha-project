<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Text-Based CAPTCHA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <?php include('assets/alert_captcha.php'); ?>
    
    <?php if (!empty($captchaError['alert'])): ?>
      <div class="form-group text-center mt-3">
        <div class="alert <?php echo $captchaError['status']; ?>" role="alert">
          <?php echo $captchaError['alert']; ?>
        </div>
      </div>
    <?php endif; ?>

    <form action="" method="post" class="mt-4">
      <div class="form-group text-center mb-3">
        <!-- Centered CAPTCHA image -->
        <img src="assets/generate_captcha.php" alt="CAPTCHA Image" class="mx-auto d-block">
      </div>
      <div class="form-group mb-3">
        <label for="captcha" class="form-label">Type the characters above:</label>
        <input type="text" class="form-control" name="captcha" id="captcha">
      </div>
      <button type="submit" name="submit" class="btn btn-dark w-100">Submit</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
