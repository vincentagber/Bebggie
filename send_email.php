<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Check if data is valid
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Set email recipient
    $recipient = "VicBade@bebggieglobal.com";
    $subject = "New Contact Us Message from $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        // Set a 500 (internal server error) response code
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>