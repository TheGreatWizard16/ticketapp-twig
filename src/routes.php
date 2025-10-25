<?php
session_start();  // ✅ Always start session before anything else

require_once __DIR__ . '/bootstrap.php'; // <-- this is where $twig is created
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/tickets.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ✅ Make session available globally inside all Twig templates
$twig->addGlobal('session', $_SESSION);

switch ($path) {
    case '/':
        view('landing.twig');
        break;

    case '/auth/login':
        handle_login();
        break;

    case '/auth/signup':
        handle_signup();
        break;

    case '/dashboard':
        require_auth();
        $stats = get_ticket_stats();
        view('dashboard.twig', $stats);
        break;

    case '/tickets':
        require_auth();
        handle_tickets();
        break;

    case '/auth/logout':
        // ✅ Proper logout handling
        unset($_SESSION['ticketapp_session']);
        session_destroy();
        redirect('/');
        break;

    default:
        http_response_code(404);
        view('notfound.twig');
        break;
}
