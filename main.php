<?php
require_once __DIR__ . '/DBConnect.php';
require_once __DIR__ . '/ContactManager.php';
require_once __DIR__ . '/Command.php';

// Une seule connexion, créée au démarrage et partagée par toutes les commandes.
$command = new Command(new ContactManager(new DBConnect()));

while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === false) {
        break;
    }

    $saisie = trim($line);

    if ($saisie === 'help') {
        $command->help();
    } elseif ($saisie === 'list') {
        $command->list();
    } elseif (preg_match('/^detail\s+(\d+)$/', $saisie, $matches)) {
        $command->detail((int) $matches[1]);
    } elseif (preg_match('/^create\s+([^,]+),([^,]+),([^,]+)$/', $saisie, $matches)) {
        $command->create(trim($matches[1]), trim($matches[2]), trim($matches[3]));
    } elseif (preg_match('/^modify\s+(\d+),([^,]+),([^,]+),([^,]+)$/', $saisie, $matches)) {
        $command->modify((int) $matches[1], trim($matches[2]), trim($matches[3]), trim($matches[4]));
    } elseif (preg_match('/^delete\s+(\d+)$/', $saisie, $matches)) {
        $command->delete((int) $matches[1]);
    } else {
        echo "Commande inconnue : $saisie\n";
    }
}
