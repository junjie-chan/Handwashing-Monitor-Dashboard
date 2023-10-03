<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G'Day</title>
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/common.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/login .css') ?>">

</head>

<body style="background-color: #7fbed7;">
  <div id="container">
    <div id="form_box">
      <!-- <form action="check" method="post"> -->
      <?php echo form_open(base_url('check')); ?>
      <h1>Access Code</h1>
      <div class="form-field">
        <input type="password" placeholder="Enter the code here" required name="code" />
      </div>

      <div class="form-field">
        <button class="btn" type="submit" id="btn">Login</button>
      </div>
      <!-- </form> -->
      <?php echo form_close(); ?>
      <div>
        <?php echo $error; ?>
      </div>
    </div>
  </div>


  <script>
    var button = document.getElementById("btn");

    // Position the form
    var box = document.getElementById('form_box');
    var form = document.querySelector('form');
    var box_style = window.getComputedStyle(box);
    var form_style = window.getComputedStyle(form);
    var box_width = parseFloat(box_style.getPropertyValue('width'));
    var box_height = parseFloat(box_style.getPropertyValue('height'));
    var form_width = parseFloat(form_style.getPropertyValue('width'));
    var form_height = parseFloat(form_style.getPropertyValue('height'));
    box.style.paddingLeft = String((box_width - form_width) / 2) + 'px';
    box.style.paddingTop = String((box_height - form_height) / 2) + 'px';
  </script>

</body>