<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G'Day</title>
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/common.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/login.css') ?>">

</head>

<body>

  <form>
    <h1>Access Code</h1>
    <div class="form-field">
      <input type="password" placeholder="Enter the code here" required />
    </div>

    <div class="form-field">
      <button class="btn" type="submit" id="btn">Log in</button>
    </div>
  </form>

  <script>
    var button = document.getElementById("btn");
    // Add a click event listener
    button.addEventListener("click", function() {
      window.location.href = "<?= base_url('summary') ?>";
    });
  </script>

</body>

</html>