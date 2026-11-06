<?php
require_once __DIR__ . '/DBConnect.php';
require_once __DIR__ . '/ContactManager.php';

while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === false) {
        break;
    }

    if (trim($line) === 'list') {
        $contactManager = new ContactManager(new DBConnect());
        echo "Liste des contacts :\n";
        echo "id, name, email, phone number\n";
        foreach ($contactManager->findAll() as $contact) {
            echo $contact, "\n";
        }
    }
}
