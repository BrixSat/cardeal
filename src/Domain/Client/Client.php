<?php

declare(strict_types=1);

namespace App\Domain\Client;


use DateTime;
use JsonSerializable;

class Client implements JsonSerializable
{
    private string     $groomName;
    private string     $groomSurname;
    private string     $brideName;
    private string     $brideSurname;
    private DateTime   $groomBirthdate;
    private DateTime   $brideBirthdate;
    private string     $groomEmail;
    private string     $brideEmail;
    private string     $groomPhone;
    private string     $bridePhone;
    private string     $groomAddress;
    private string     $brideAddress;
    private int        $typeOfEvent;
    private int        $civilOrChurch;
    private DateTime   $eventDate;
    private DateTime   $closedDate;
    private String     $alternativeDates;
    private DateTime   $tastingDate;
    private string     $nif;
    private string     $signalAmmount;
    private bool       $lights;
    private bool       $rooms;
    private bool       $menu;
    private bool       $fireworks;
    private string     $fireType;
    private string     $observations;
    private ?\DateTime $createdAt;
    private ?\DateTime $updatedAt;

    public function __construct(
                      readonly ?int       $id,
                      string     $groomName,
                      string     $brideName,
                      DateTime   $groomBirthdate,
                      DateTime   $brideBirthdate,
                      string     $groomEmail,
                      string     $brideEmail,
                      string     $groomPhone,
                      string     $bridePhone,
                      string     $groomAddress,
                      string     $brideAddress,
                      int        $typeOfEvent,
                      int        $civilOrChurch,
                      DateTime   $eventDate,
                      string     $alternativeDates,
                      DateTime   $closedDate,
                      DateTime   $tastingDate,
                      string     $nif,
                      string     $signalAmmount,
                      bool       $lights,
                      bool       $rooms,
                      bool       $menu,
                      bool       $fireworks,
                      string     $fireType,
                      string     $observations,
                      DateTime   $createdAt,
                      DateTime   $updatedAt)

    {
        $this->setGroomName($groomName);
        $this->setBrideName($brideName);
        $this->setGroomBirthdate($groomBirthdate);
        $this->setBrideBirthdate($brideBirthdate);
        $this->setGroomEmail($groomEmail);
        $this->setBrideEmail($brideEmail);
        $this->setGroomPhone($groomPhone);
        $this->setBridePhone($bridePhone);
        $this->setGroomAddress($groomAddress);
        $this->setBrideAddress($brideAddress);
        $this->setTypeOfEvent($typeOfEvent);
        $this->setCivilOrChurch($civilOrChurch);
        $this->setEventDate($eventDate);
        $this->setAlternativeDates($alternativeDates);
        $this->setClosedDate($closedDate);
        $this->setTastingDate($tastingDate);
        $this->setNif($nif);
        $this->setSignalAmmount($signalAmmount);
        $this->setLights($lights);
        $this->setRooms($rooms);
        $this->setMenu($menu);
        $this->setFireworks($fireworks);
        $this->setFireType($fireType);
        $this->setObservations($observations);
        $this->setUpdatedAt($createdAt);
        $this->setCreatedAt($updatedAt);
    }

    public function getGroomName(): string
    {
        return $this->groomName;
    }
    public function getBrideName(): string
    {
        return $this->brideName;
    }
    public function getGroomBirthdate(): DateTime
    {
        return $this->groomBirthdate;
    }
    public function getBrideBirthdate(): DateTime
    {
        return $this->brideBirthdate;
    }
    public function getGroomEmail(): string
    {
        return $this->groomEmail;
    }
    public function getBrideEmail(): string
    {
        return $this->brideEmail;
    }
    public function getGroomPhone(): string
    {
        return $this->groomPhone;
    }
    public function getBridePhone(): string
    {
        return $this->bridePhone;
    }
    public function getGroomAddress(): string
    {
        return $this->groomAddress;
    }
    public function getBrideAddress(): string
    {
        return $this->brideAddress;
    }
    public function getTypeOfEvent(): int
    {
        return $this->typeOfEvent;
    }
    public function getCivilOrChurch(): int
    {
        return $this->civilOrChurch;
    }

    public function getEventDate(): DateTime
    {
        return $this->eventDate;
    }
    public function getClosedDate(): DateTime
    {
        return $this->closedDate;
    }
    public function getAlternativeDates(): String
    {
        return $this->alternativeDates;
    }
    public function getTastingDate(): DateTime
    {
        return $this->tastingDate;
    }
    public function getNif(): string
    {
        return $this->nif;
    }
    public function getSignalAmmount(): string
    {
        return $this->signalAmmount;
    }
    public function getLights(): bool
    {
        return $this->lights;
    }
    public function getRooms(): bool
    {
        return $this->rooms;
    }
    public function getMenu(): bool
    {
        return $this->menu;
    }
    public function getFireworks(): bool
    {
        return $this->fireworks;
    }
    public function getFireType(): string
    {
        return $this->fireType;
    }
    public function getSignalAmmount(): string
    {
        return $this->signalAmmount;
    }
    public function getObservations(): string
    {
        return $this->observations;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    private function validateName(string $name, string $fieldName): void
    {
        $length = strlen($name);
        if ($length < 5 || $length > 255) {
            throw new \InvalidArgumentException("$fieldName must be between 5 and 255 characters.");
        }
    }

    private function validateDate(DateTime $date, string $fieldName): void
    {
        if ($date === false || !$date instanceof DateTime) {
            throw new \InvalidArgumentException("$fieldName must be a valid DateTime.");
        }
    }
    private function validateEmail(string $email, string $fieldName): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("$fieldName must be a valid email address.");
        }
    }

    private function validatePhone(string $phone, string $fieldName): void
    {
        // Basic validation for demonstration, adjust as needed
        if (!preg_match('/^[0-9]{8,15}$/', $phone)) {
            throw new \InvalidArgumentException("$fieldName must be a valid phone number.");
        }
    }

    private function validateNif(string $nif, string $fieldName): void
    {
        // Basic validation for demonstration, adjust as needed
        if (!preg_match('/^[0-9]{9}$/', $nif)) {
            throw new \InvalidArgumentException("$fieldName must be a valid fiscal number (NIF).");
        }
    }

    // Setters with validations

    public function setGroomName(string $groomName): void
    {
        $this->validateName($groomName, 'groomName');
        $this->groomName = $groomName;
    }

    public function setGroomSurname(string $groomSurname): void
    {
        $this->validateName($groomSurname, 'groomSurname');
        $this->groomSurname = $groomSurname;
    }

    public function setBrideName(string $brideName): void
    {
        $this->validateName($brideName, 'brideName');
        $this->brideName = $brideName;
    }

    public function setBrideSurname(string $brideSurname): void
    {
        $this->validateName($brideSurname, 'brideSurname');
        $this->brideSurname = $brideSurname;
    }

    public function setGroomBirthdate(DateTime $groomBirthdate): void
    {
        $this->validateDate($groomBirthdate, 'groomBirthdate');
        $this->groomBirthdate = $groomBirthdate;
    }

    public function setBrideBirthdate(DateTime $brideBirthdate): void
    {
        $this->validateDate($brideBirthdate, 'brideBirthdate');
        $this->brideBirthdate = $brideBirthdate;
    }

    public function setGroomEmail(string $groomEmail): void
    {
        $this->validateEmail($groomEmail, 'groomEmail');
        $this->groomEmail = $groomEmail;
    }

    public function setBrideEmail(string $brideEmail): void
    {
        $this->validateEmail($brideEmail, 'brideEmail');
        $this->brideEmail = $brideEmail;
    }

    public function setGroomPhone(string $groomPhone): void
    {
        $this->validatePhone($groomPhone, 'groomPhone');
        $this->groomPhone = $groomPhone;
    }

    public function setBridePhone(string $bridePhone): void
    {
        $this->validatePhone($bridePhone, 'bridePhone');
        $this->bridePhone = $bridePhone;
    }

    public function setGroomAddress(string $groomAddress): void
    {
        // Validation logic for groomAddress, if needed
        $this->groomAddress = $groomAddress;
    }

    public function setBrideAddress(string $brideAddress): void
    {
        // Validation logic for brideAddress, if needed
        $this->brideAddress = $brideAddress;
    }

    public function setTypeOfEvent(int $typeOfEvent): void
    {
        // Validation logic for typeOfEvent, if needed
        $this->typeOfEvent = $typeOfEvent;
    }

    public function setCivilOrChurch(int $civilOrChurch): void
    {
        // Validation logic for civilOrChurch, if needed
        $this->civilOrChurch = $civilOrChurch;
    }


    public function setEventDate(DateTime $eventDate): void
    {
        $this->validateDate($eventDate, 'eventDate');
        $this->eventDate = $eventDate;
    }

    public function setAlternativeDates(String $alternativeDates): void
    {
        $this->alternativeDates = $alternativeDates;
    }


    public function setClosedDate(DateTime $closedDate): void
    {
        $this->validateDate($closedDate, 'closedDate');
        $this->closedDate = $closedDate;
    }

    public function setTastingDate(DateTime $tastingDate): void
    {
        $this->validateDate($tastingDate, 'tastingDate');
        $this->tastingDate = $tastingDate;
    }

    public function setNif(string $nif): void
    {
        $this->validateNif($nif, 'nif');
        $this->nif = $nif;
    }

    public function setSignalAmmount(string $signalAmmount): void
    {
        // Validation logic for signalAmmount, if needed
        $this->signalAmmount = $signalAmmount;
    }

    public function setLights(bool $lights): void
    {
        // Validation logic for lights, if needed
        $this->lights = $lights;
    }

    public function setRooms(bool $rooms): void
    {
        // Validation logic for rooms, if needed
        $this->rooms = $rooms;
    }

    public function setMenu(bool $menu): void
    {
        // Validation logic for menu, if needed
        $this->menu = $menu;
    }

    public function setFireworks(bool $fireworks): void
    {
        // Validation logic for fire, if needed
        $this->fireworks = $fireworks;
    }

    public function setFireType(string $fireType): void
    {
        // Validation logic for fireType, if needed
        $this->fireType = $fireType;
    }

    public function setObservations(string $observations): void
    {
        // Validation logic for observations, if needed
        $this->observations = $observations;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        // Validation logic for createdAt, if needed
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        // Validation logic for updatedAt, if needed
        $this->updatedAt = $updatedAt;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'groomName' => $this->groomName,
            'groomSurname' => $this->groomSurname,
            'brideName' => $this->brideName,
            'brideSurname' => $this->brideSurname,
            'groomBirthdate' => $this->groomBirthdate->format(\DateTime::ATOM),
            'brideBirthdate' => $this->brideBirthdate->format(\DateTime::ATOM),
            'groomEmail' => $this->groomEmail,
            'brideEmail' => $this->brideEmail,
            'groomPhone' => $this->groomPhone,
            'bridePhone' => $this->bridePhone,
            'groomAddress' => $this->groomAddress,
            'brideAddress' => $this->brideAddress,
            'typeOfEvent' => $this->typeOfEvent,
            'civilOrChurch' => $this->civilOrChurch,
            'eventYear' => $this->eventYear->format(\DateTime::ATOM),
            'eventDate' => $this->eventDate->format(\DateTime::ATOM),
            'closedDate' => $this->closedDate->format(\DateTime::ATOM),
            'tastingDate' => $this->tastingDate->format(\DateTime::ATOM),
            'nif' => $this->nif,
            'signalAmmount' => $this->signalAmmount,
            'lights' => $this->lights,
            'rooms' => $this->rooms,
            'menu' => $this->menu,
            'fire' => $this->fire,
            'fireType' => $this->fireType,
            'observations' => $this->observations,
            'createdAt' => $this->createdAt->format(\DateTime::ATOM),
            'updatedAt' => $this->updatedAt->format(\DateTime::ATOM),
        ];
    }
}
