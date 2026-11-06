<?php
require_once __DIR__ . '/Contact.php';

class ContactManager
{
    private PDO $pdo;

    public function __construct(DBConnect $db)
    {
        $this->pdo = $db->getPDO();
    }

    // Retourne tous les contacts sous forme de tableau d'objets Contact.
    public function findAll(): array
    {
        $query = $this->pdo->query('SELECT id, name, email, phone_number FROM contact ORDER BY id');

        $contacts = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $contacts[] = $this->hydrate($row);
        }

        return $contacts;
    }

    // Retourne un seul contact, ou null si l'id n'existe pas.
    public function findById(int $id): ?Contact
    {
        $query = $this->pdo->prepare('SELECT id, name, email, phone_number FROM contact WHERE id = :id');
        $query->execute(['id' => $id]);

        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }

        return $this->hydrate($row);
    }

    // Ajoute un contact en base et lui donne l'id généré par MySQL.
    public function create(Contact $contact): void
    {
        $query = $this->pdo->prepare('INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)');
        $query->execute([
            'name' => $contact->getName(),
            'email' => $contact->getEmail(),
            'phone_number' => $contact->getPhoneNumber(),
        ]);

        $contact->setId((int) $this->pdo->lastInsertId());
    }

    // Supprime le contact. Retourne true si une ligne a été supprimée.
    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare('DELETE FROM contact WHERE id = :id');
        $query->execute(['id' => $id]);

        return $query->rowCount() > 0;
    }

    // Met à jour les informations d'un contact existant (son id doit être défini).
    public function update(Contact $contact): void
    {
        $query = $this->pdo->prepare('UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id');
        $query->execute([
            'name' => $contact->getName(),
            'email' => $contact->getEmail(),
            'phone_number' => $contact->getPhoneNumber(),
            'id' => $contact->getId(),
        ]);
    }

    // Transforme une ligne de la base en objet Contact.
    private function hydrate(array $row): Contact
    {
        $contact = new Contact();
        $contact->setId((int) $row['id']);
        $contact->setName($row['name']);
        $contact->setEmail($row['email']);
        $contact->setPhoneNumber($row['phone_number']);

        return $contact;
    }
}
