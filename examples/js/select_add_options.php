<?php
/*
 * @file: select_add_options.php
 * @info: agregar opciones con js a elemento select
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Add options to select element useing js</title>
</head>
<body>
<h1>Add options to select element useing js</h1>
<form method="post" action="">
    <label for="sel-example">Example:</label><br/>
    <select id="sel-example"></select>
</form>
<script type="module">
const values = [
  {id:1, text:"value 1"},
  {id:2, text:"value 2"},
  {id:3, text:"value 3"},
  {id:4, text:"value 5"},
]
const $select = document.getElementById("sel-example")

//empty option
const $option = document.createElement("option")
$option.value = ""
$option.innerHTML = "Please choose an option :)"
$select.appendChild($option)

values.forEach(obj => {
  const $option = document.createElement("option")
  $option.value = obj.id
  $option.innerHTML = obj.text
  $select.appendChild($option)
})
</script>
</body>
</html>