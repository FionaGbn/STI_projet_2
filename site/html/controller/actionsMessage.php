<?php
session_start();
if (!(isset($_SESSION['email']))) {
    header("Location: /view/loginView.php");
}

require_once '../../databases/config.php';
global $connectionDb;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Delete message
    if (isset($_POST['deleteItem'])) {
        $sql = "DELETE FROM message WHERE id = :id AND receiver = :receiver";
        // Query the DB
        if ($stmt = $connectionDb->prepare($sql)) {
            $stmt->bindParam(':receiver', $email);
            $stmt->bindParam(':id', $id);
            $id = $_POST['id'];
            $email = $_SESSION['email'];
            if (!$stmt->execute()) {
                echo "ERROR";
            } else {
                header("Location: /view/webmail/webmailView.php");
            }
        }
    }

    // Display message
    else if (isset($_POST['displayItem'])) {
        $sql = "SELECT * FROM message WHERE receiver = :receiver AND id = :id ";
        // Query the DB
        if ($stmt = $connectionDb->prepare($sql)) {
            $stmt->bindParam(':receiver', $email);
            $stmt->bindParam(':id', $id);
            $id = $_POST['id'];
            $email = $_SESSION['email'];
            if (!$stmt->execute()) {
                echo "ERROR";
            } else {
                if ($data = $stmt->fetch()) {
                    include "../view/navigation.php";
                    echo "<div class=\"message\">";
                    echo "<h3>From: " . htmlspecialchars($data['sender'], ENT_QUOTES) . "</h3>";
                    echo "<h4>Subject: " . htmlspecialchars($data['subject'], ENT_QUOTES) . "</h4>";
                    echo "Date: " . htmlspecialchars($data['date_received'], ENT_QUOTES) . "<br/>";
                    echo "Body:<br/>" . htmlspecialchars($data['body'], ENT_QUOTES) . "<br/><br/>";
                    echo "<a href='../view/webmail/webmailView.php'>Return</a>";
                    echo "</div>";
                }
            }
        }
    }

    // New message
    else if (isset($_POST['writeMessage'])) {
        $sql = "INSERT INTO message (subject, body, sender, receiver) VALUES (:subject, :body, :sender, :receiver)";
        // Query the DB
        if (!isset($_POST['subject']) || !isset($_POST['body']) || !isset($_POST['target'])) {
            echo "MISSING NEEDED FIELD";
            print_r($_POST);
            echo "<a href='../view/webmail/webmailView.php'>Return</a>";
        }

        if ($stmt = $connectionDb->prepare($sql)) {
            $stmt->bindParam(':receiver', $target);
            $stmt->bindParam(':sender', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':body', $body);
            $target = $_POST['target'];
            $body = $_POST['body'];
            $subject = $_POST['subject'];
            $email = $_SESSION['email'];
            if (!$stmt->execute()) {
                echo "ERROR";
            } else {
                header("Location: /view/webmail/webmailView.php");
            }
        }
    }
}