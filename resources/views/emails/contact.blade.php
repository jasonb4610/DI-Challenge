<html>
<head></head>
<body style="background: black; color: white">
<h1>Contact Request</h1>
<h2>Contact Name: {{$name}}</h2>
<h2>Contact Email: {{$email}}</h2>
<?php if (isset($phone)) { ?>
<h2>Contact Phone: {{$phone}}</h2>
<?php } ?>
<p>User Message: {{$userMessage}}</p>
</body>
</html>
