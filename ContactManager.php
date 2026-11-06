<?php

require_once __DIR__ . '/Contact.php';

class ContactManager
{
    private PDO $pdo;

    public function __construct(DBConnect $db)
    {
        $this->pdo = $db->getPDO();
    }

    /** @return Contact[] */
    public function findAll(): array
    {
        $query = $this->pdo->query('SELECT id, name, email, phone_number FROM contact ORDER BY id');
        $contacts = [];

        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $contact = new Contact();
            $contact->setId((int) $row['id']);
            $contact->setName($row['name']);
            $contact->setEmail($row['email']);
            $contact->setPhoneNumber($row['phone_number']);
            $contacts[] = $contact;
        }

        return $contacts;
    }
}
