<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reset Password</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .form-container {
        max-width: 400px;
        margin: 50px auto;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 4px;
    }
    label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }
    input[type="password"],
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
    }
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        display: none;
    }
    .success-message {
        color: green;
        font-size: 16px;
        margin-top: 5px;
        display: none;
    }
    button[type="submit"] {
        margin-top: 15px;
        padding: 10px 15px;
    }
</style>
</head>
<body>

<div class="form-container">
    <h2>Reset Your Password</h2>
    <form id="resetPasswordForm">
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        <div id="passwordHelp" class="error-message">Password must be at least 8 characters, contain a letter and a number.</div>

        <label for="password_confirmation">Confirm New Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <div id="passwordMatchHelp" class="error-message">Passwords do not match.</div>
        
        <!-- Hidden token field -->
        <input type="hidden" name="token" id="token" value="<?php echo htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES); ?>">

        <button type="submit">Reset Password</button>
    </form>
    <div id="serverMessage" class="error-message"></div>
    <div id="successMessage" class="success-message"></div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const passwordHelp = document.getElementById('passwordHelp');
    const passwordMatchHelp = document.getElementById('passwordMatchHelp');
    const serverMessage = document.getElementById('serverMessage');
    const successMessage = document.getElementById('successMessage');

    function validatePasswordStrength(pw) {
        const lengthCheck = pw.length >= 8;
        const letterCheck = /[a-z]/i.test(pw);
        const numberCheck = /\d/.test(pw);
        return lengthCheck && letterCheck && numberCheck;
    }

    // Validate on input
    passwordInput.addEventListener('input', () => {
        const pw = passwordInput.value;
        if (!validatePasswordStrength(pw)) {
            passwordHelp.style.display = 'block';
        } else {
            passwordHelp.style.display = 'none';
        }

        // Also re-check match if user is typing in the main password
        const confirmPw = passwordConfirmationInput.value;
        if (confirmPw && pw !== confirmPw) {
            passwordMatchHelp.style.display = 'block';
        } else {
            passwordMatchHelp.style.display = 'none';
        }
    });

    // Check password match on confirmation input
    passwordConfirmationInput.addEventListener('input', () => {
        const pw = passwordInput.value;
        const confirmPw = passwordConfirmationInput.value;
        if (pw !== confirmPw) {
            passwordMatchHelp.style.display = 'block';
        } else {
            passwordMatchHelp.style.display = 'none';
        }
    });

    document.getElementById('resetPasswordForm').addEventListener('submit', (e) => {
        e.preventDefault();
        // Clear server messages
        serverMessage.style.display = 'none';
        successMessage.style.display = 'none';

        const pw = passwordInput.value;
        const confirmPw = passwordConfirmationInput.value;

        // Final check before submission
        if (!validatePasswordStrength(pw)) {
            passwordHelp.style.display = 'block';
            return;
        }
        if (pw !== confirmPw) {
            passwordMatchHelp.style.display = 'block';
            return;
        }

        // If client validation passes, submit to server via fetch
        const formData = new FormData(e.target);

        fetch('process-reset-password.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if(!response.ok) {
                throw new Error('Network error: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                successMessage.textContent = data.message;
                successMessage.style.display = 'block';
                // Redirect after a few seconds
                setTimeout(() => {
                    window.location.href = '../login.php';
                }, 5000);
            } else {
                serverMessage.textContent = data.message;
                serverMessage.style.display = 'block';
            }
        })
        .catch(error => {
            serverMessage.textContent = 'An error occurred: ' + error.message;
            serverMessage.style.display = 'block';
        });
    });
</script>

</body>
</html>
