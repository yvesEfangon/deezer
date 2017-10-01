<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Challenge DEEZER</title>
    <link rel="stylesheet" type="text/css" href="asset/deezer.css">
</head>
<body>
<div class="row">
    <h1 class="center"><span style="color: #FF0000;">PHP DEEZER</span> <span style="color: #00C6F4">CHALLENGE</span></h1>
</div>
<div class="row">
    <div class="row-3" id="form-create-user">
        <h4 class="center">Add a user</h4>
       <label for="username">Username</label> <input type="text" name="username" id="username"><br>
       <label for="email">Email</label> <input type="text" name="email" id="email"><br>
       <label for="name">Name</label> <input type="text" name="name" id="name"><br>
        <button id="add-user">Add</button>
    </div>
    <div class="row-6">
        le milieu!!
    </div>
    <div class="row-3">
        La droite
    </div>
</div>

</body>
<script src="asset/deezer.js"></script>

<script>
    if (
        document.readyState === "complete" ||
        (document.readyState !== "loading" && !document.documentElement.doScroll)
    ) {
        callback();
    } else {
        document.addEventListener("DOMContentLoaded", callback);
    }
</script>
</html>