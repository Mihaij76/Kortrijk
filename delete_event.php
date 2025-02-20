<?php
// Start the session
session_start();

// Include database connection file
require_once 'forgot-password/database.php'; // Adjust the path as needed

// Function to redirect to the events page
function redirectToEventsPage() {
    header('Location: events.php');
    exit();
}

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If not, redirect to the login page or an error page
    redirectToEventsPage();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    // The ID of the event to delete
    $eventId = $_POST['event_id'];

    // Connect to the database
    $connect = mysqli_connect('localhost', 'root', '', 'it_project'); // Adjust with your database credentials

    // Check for a successful connection
    if (!$connect) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Prepare the delete query
    $deleteQuery = "DELETE FROM events WHERE id = ?";

    // Prepare a statement
    if ($stmt = mysqli_prepare($connect, $deleteQuery)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = $eventId;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success, redirect to events page
            redirectToEventsPage();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($connect);
} else {
    // If the method is not POST or event_id is not set, redirect to the events page
    redirectToEventsPage();
}

