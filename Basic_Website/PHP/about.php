<?php
    session_start();
    $username = isset($_SESSION['username'])? $_SESSION['username'] : NULL;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/about.css">
    <link rel="icon" href="../icon.webp" type='image/jpg'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
</head>
<body>
    <div class="container">
        <p class="greeting"><?php echo ($username? "Dear ".$username.',': '' );?></p>

        <p>We’re thrilled to invite you to join our vibrant community on <strong>Pluse Blog</strong>. Your unique voice and valuable insights are exactly what we need to spark inspiring conversations and drive meaningful engagement.</p>

        <p>Why should you post with us? Here’s why:</p>

        <ul>
            <li><strong>Reach a Wider Audience:</strong> Connect with a global audience who are eager to hear from industry experts like you.</li>
            <li><strong>Build Your Brand:</strong> Establish yourself as a thought leader and gain recognition by sharing your knowledge and perspectives.</li>
            <li><strong>Engage with the Community:</strong> Participate in dynamic discussions and network with individuals who share your interests and passions.</li>
        </ul>

        <p>Getting started on Pluse Blog is effortless. Our team is dedicated to helping you every step of the way, from refining your ideas to publishing your posts. We’re here to support you and ensure your content shines!</p>

        <div class="inspiration">
            <h2>Inspire and Be Inspired</h2>
            <p>Your stories and insights have the power to motivate and educate others. By sharing your experiences, you’re not only contributing to our community but also setting the stage for others to follow. Let’s work together to make a positive impact and create something extraordinary!</p>
        </div>

        <p>Have questions or need assistance? Don’t hesitate to reach out. We’re excited to see what you’ll bring to our platform!</p>

        <div class="signature">
            <img src="../Images/Ziad.jpg" alt="Ziad Mohammad Abdelhakam">
            <p class="closing">We eagerly anticipate your contributions to our platform.</p>
            <p class="name">Ziad Mohammad Abdelhakam</p>
            <p class="position">Chief Executive Officer & Designer</p>
            <p class="contact">Phone: +20 102 205 6761</p>
        </div>
        
    </div>
</body>
</html>
