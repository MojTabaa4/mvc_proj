<?php


namespace App\Models\Entities;

use PDO;

class User extends \Core\Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $password_confirmation;

    private array $errors = [];
//    public static function getAll()
//    {
//        $db = static::getDb();
//        $statement = $db->query('select id, name from users');
//        return $statement->fetchAll(PDO::FETCH_ASSOC);
//    }

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save(): bool
    {
        $this->validate();
        if (empty($this->errors)) {
            $hash_password = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'insert into users (name, email, password)
                values (:name, :email, :password)';

            $db = static::getDb();
            $statement = $db->prepare($sql);

            $statement->bindValue(':name', $this->name, PDO::PARAM_STR);
            $statement->bindValue(':email', $this->email, PDO::PARAM_STR);
            $statement->bindValue(':password', $hash_password, PDO::PARAM_STR);

            return $statement->execute();
        }
        return false;
    }

    public function saveEdit(): bool
    {
        $this->validateEdit();
        if (empty($this->errors)) {
            $sql = 'update users set name=:name, email=:email where id=:id';

            $db = static::getDb();
            $statement = $db->prepare($sql);

            $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
            $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $statement->bindValue(':id', $this->id, PDO::PARAM_STR);

            return $statement->execute();
        }
        return false;
    }

    public function validate(): void
    {
        if ($this->name == '') {
            $this->errors[] = 'name is required';
        }

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'invalid email address';
        }

        if ($this->emailExists($this->email)) {
            $this->errors[] = 'this email already exists';
        }

        if ($this->password != $this->password_confirmation) {
            $this->errors[] = 'confirmation password is incorrect';
        }

        if (strlen($this->password) < 6) {
            $this->errors[] = 'password must be at least 6 characters';
        }

        if (!preg_match('/.*[a-z]+.*/i', $this->password)) {
            $this->errors[] = 'password must contain at least one letter';
        }

        if (!preg_match('/.*[\d]+.*/i', $this->password)) {
            $this->errors[] = 'password must contain at least one number';
        }
    }

    public function validateEdit(): void
    {
        if ($_POST['name'] == '') {
            $this->errors[] = 'name is required';
        }

        if ($_POST['email'] == '') {
            $this->errors[] = 'email is required';
        } else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'invalid email address';
        }

        if ($_POST['name'] == $this->name && $_POST['email'] == $this->email) {
            $this->errors[] = 'please enter new name or new email';
        }

        if ($this->emailExists($_POST['email'], $this->id)) {
            $this->errors[] = 'this email already exists';
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function emailExists($email, $ignore_id = null): bool
    {
        $user = static::findByEmail($email);

        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }

        return false;
    }

    public static function findByEmail($email)
    {
        $sql = 'select * from users where email = :email';

        $db = static::getDb();
        $statement = $db->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);

        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);

        $statement->execute();

        return $statement->fetch();
    }

    public static function findByID($id)
    {
        $sql = 'select * from users where id = :id';

        $db = static::getDb();
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);

        $statement->execute();

        return $statement->fetch();
    }

    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    // Q: are we have to move getters and setter to DTO (data transfer object) directory

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPasswordConfirmation(): string
    {
        return $this->password_confirmation;
    }
}