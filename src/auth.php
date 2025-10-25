<?php
function require_auth() {
    if (empty($_SESSION['ticketapp_session'])) {
        $_SESSION['flash'] = "Your session has expired — please log in again.";
        redirect('/auth/login');
    }
}

function handle_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $pw = trim($_POST['password'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Enter a valid email";
        } elseif (strlen($pw) < 6) {
            $error = "Password must be at least 6 characters";
        } else {
            $_SESSION['ticketapp_session'] = [
                'token' => bin2hex(random_bytes(16)),
                'userEmail' => $email
            ];
            redirect('/dashboard');
        }
        view('login.twig', compact('error', 'email'));
    } else {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        view('login.twig', compact('flash'));
    }
}

function handle_signup() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $pw = trim($_POST['password'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Enter a valid email";
        } elseif (strlen($pw) < 6) {
            $error = "Password must be at least 6 characters";
        } else {
            $_SESSION['ticketapp_session'] = [
                'token' => bin2hex(random_bytes(16)),
                'userEmail' => $email
            ];
            redirect('/dashboard');
        }
        view('signup.twig', compact('error', 'email'));
    } else {
        view('signup.twig');
    }
}
