<!DOCTYPE html>
<html>

<head>
    <title>Event Registered</title>
</head>

<body>
    <h3>Event Registration Details:</h3>
    <p><strong>Name:</strong> {{ $event->name }}</p>
    <p><strong>Date:</strong> {{ $event->date }}</p>
    <p><strong>Mail:</strong> {{ $event->email }}</p>
    <p><strong>Message:</strong> {{ $event->description }}</p>
    <p>Your Enquiry Successfully submited. our team will get back to you shortly</p>

</body>

</html>