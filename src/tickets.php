<?php
$TICKETS_FILE = __DIR__ . '/../storage/tickets.json';

function load_tickets() {
    global $TICKETS_FILE;
    if (!file_exists($TICKETS_FILE)) return [];
    return json_decode(file_get_contents($TICKETS_FILE), true) ?? [];
}

function save_tickets($tickets) {
    global $TICKETS_FILE;
    file_put_contents($TICKETS_FILE, json_encode($tickets, JSON_PRETTY_PRINT));
}

function get_ticket_stats() {
    $tickets = load_tickets();
    return [
        'total' => count($tickets),
        'open' => count(array_filter($tickets, fn($t)=>$t['status']==='open')),
        'resolved' => count(array_filter($tickets, fn($t)=>$t['status']==='closed')),
    ];
}

function handle_tickets() {
    $tickets = load_tickets();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $title = trim($_POST['title'] ?? '');
            $status = $_POST['status'] ?? 'open';
            $desc = trim($_POST['description'] ?? '');
            if (!$title) $error = "Title is required";
            elseif (strlen($title) > 120) $error = "Title too long (max 120)";
            elseif (!in_array($status, ['open','in_progress','closed'])) $error = "Invalid status";
            elseif ($desc && strlen($desc) > 2000) $error = "Description too long (max 2000)";
            else {
                $tickets[] = [
                    'id' => uniqid(),
                    'title' => $title,
                    'status' => $status,
                    'description' => $desc,
                    'createdAt' => date('c'),
                    'updatedAt' => date('c'),
                ];
                save_tickets($tickets);
                $_SESSION['flash'] = "Ticket created";
                redirect('/tickets');
            }
            view('tickets.twig', compact('tickets', 'error'));
        } elseif ($action === 'delete') {
            $id = $_POST['id'] ?? '';
            $tickets = array_values(array_filter($tickets, fn($t)=>$t['id']!==$id));
            save_tickets($tickets);
            $_SESSION['flash'] = "Ticket deleted";
            redirect('/tickets');
        } elseif ($action === 'update') {
            $id = $_POST['id'] ?? '';
            foreach ($tickets as &$t) {
                if ($t['id']===$id) {
                    $t['title'] = trim($_POST['title']);
                    $t['status'] = $_POST['status'];
                    $t['description'] = trim($_POST['description']);
                    $t['updatedAt'] = date('c');
                }
            }
            save_tickets($tickets);
            $_SESSION['flash'] = "Ticket updated";
            redirect('/tickets');
        }
    } else {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        view('tickets.twig', compact('tickets', 'flash'));
    }
}
