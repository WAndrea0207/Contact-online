<?php
require_once __DIR__ . '/ContactManager.php';
require_once __DIR__ . '/Contact.php';

// Contient la logique de chaque commande.
class Command
{
    private ContactManager $contactManager;

    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }

    // Affiche l'aide : la liste des commandes disponibles.
    public function help(): void
    {
        echo "help : affiche cette aide\n";
        echo "list : liste les contacts\n";
        echo "detail [id] : affiche un contact\n";
        echo "create [name], [email], [phone number] : crée un contact\n";
        echo "modify [id], [name], [email], [phone number] : modifie un contact\n";
        echo "delete [id] : supprime un contact\n";
    }

    // Affiche tous les contacts.
    public function list(): void
    {
        echo "Liste des contacts :\n";
        echo "id, name, email, phone number\n";
        foreach ($this->contactManager->findAll() as $contact) {
            echo $contact, "\n";
        }
    }

    // Affiche un seul contact à partir de son id.
    public function detail(int $id): void
    {
        $contact = $this->contactManager->findById($id);

        if ($contact === null) {
            echo "Aucun contact avec l'id $id\n";
            return;
        }

        echo $contact, "\n";
    }

    // Crée un contact et affiche son nouvel id.
    public function create(string $name, string $email, string $phoneNumber): void
    {
        $contact = new Contact();
        $contact->setName($name);
        $contact->setEmail($email);
        $contact->setPhoneNumber($phoneNumber);

        $this->contactManager->create($contact);

        echo "Contact créé avec l'id {$contact->getId()}\n";
    }

    // Modifie un contact existant.
    public function modify(int $id, string $name, string $email, string $phoneNumber): void
    {
        $contact = $this->contactManager->findById($id);

        if ($contact === null) {
            echo "Aucun contact avec l'id $id\n";
            return;
        }

        $contact->setName($name);
        $contact->setEmail($email);
        $contact->setPhoneNumber($phoneNumber);

        $this->contactManager->update($contact);

        echo "Contact $id modifié\n";
    }

    // Supprime un contact à partir de son id.
    public function delete(int $id): void
    {
        if ($this->contactManager->delete($id)) {
            echo "Contact $id supprimé\n";
        } else {
            echo "Aucun contact avec l'id $id\n";
        }
    }
}
