<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="myForm">
  <input type="text" name="username" placeholder="Enter username" required>
  <input type="email" name="email" placeholder="Enter email" required>
  <button type="submit">Submit</button>
</form>

<div id="result"></div>

<script>
document.getElementById("myForm").addEventListener("submit", function (event) {
  event.preventDefault(); // prevent the normal form submission

  // Create a FormData object from the form
  const formData = new FormData(this);

  // Send it using fetch (modern AJAX)
  fetch("submit.php", {
    method: "POST",
    body: formData
  })
    // .then(response => response.text())
    .then(data => {
      document.getElementById("result").innerHTML = data;
    })
    .catch(error => {
      document.getElementById("result").innerHTML = "Error: " + error;
    });
});
</script>

</body>
</html>