<?php

declare(strict_types=1);

namespace App\Domain\Client;

use App\Infrastructure\DomainException\InvalidArgumentException;
use DateTime;
use DateTimeInterface;
use JsonSerializable;

class Client implements JsonSerializable
{
    private string     $groomName;
    private string     $brideName;
    private DateTime   $groomBirthDate;
    private DateTime   $brideBirthDate;
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
    private string     $signalAmount;
    private int       $lights;
    private int       $rooms;
    private int       $menu;
    private int       $fireworks;
    private string     $fireType;
    private string     $observations;


    public static function formToClient (array $form, int $id = -1): self
    {
        if (isset($form[ 'lights' ]))       $lights = 1;    else $lights = 0;
        if (isset($form[ 'rooms' ]))        $rooms = 1;     else $rooms = 0;
        if (isset($form[ 'menu' ]))         $menu = 1;      else $menu = 0;
        if (isset($form[ 'fireworks' ]))    $fireworks = 1; else $fireworks = 0;

        return new Client(
            id              : $id,
            groomName       : $form[ 'groomName' ],
            brideName       : $form[ 'brideName' ],
            groomBirthDate  : DateTime::createFromFormat('d/m/Y', $form[ 'groomBirthDate' ]),
            brideBirthDate  : DateTime::createFromFormat('d/m/Y', $form[ 'brideBirthDate' ]),
            groomEmail      : $form[ 'groomEmail' ],
            brideEmail      : $form[ 'brideEmail' ],
            groomPhone      : $form[ 'groomPhone' ],
            bridePhone      : $form[ 'bridePhone' ],
            groomAddress    : $form[ 'groomAddress' ],
            brideAddress    : $form[ 'brideAddress' ],
            typeOfEvent     : (int)$form[ 'typeOfEvent' ],
            civilOrChurch   : (int)$form[ 'civilOrChurch' ],
            eventDate       : DateTime::createFromFormat('d/m/Y', $form[ 'eventDate' ]),
            alternativeDates: $form[ 'alternativeDates' ] ?? '',
            closedDate      : DateTime::createFromFormat('d/m/Y', $form[ 'closedDate' ]),
            tastingDate     : DateTime::createFromFormat('d/m/Y', $form[ 'tastingDate' ]),
            nif             : $form[ 'nif' ],
            signalAmount    : $form[ 'signalAmmount' ],
            lights          : $lights,
            rooms           : $rooms,
            menu            : $menu,
            fireworks       : $fireworks,
            fireType        : $form[ 'fireType' ] ?? '',
            observations    : $form[ 'observations' ]
        );
    }

    public function __construct (
        public readonly ?int      $id,
        string                    $groomName,
        string                    $brideName,
        DateTime                  $groomBirthDate,
        DateTime                  $brideBirthDate,
        string                    $groomEmail,
        string                    $brideEmail,
        string                    $groomPhone,
        string                    $bridePhone,
        string                    $groomAddress,
        string                    $brideAddress,
        int                       $typeOfEvent,
        int                       $civilOrChurch,
        DateTime                  $eventDate,
        string                    $alternativeDates,
        DateTime                  $closedDate,
        DateTime                  $tastingDate,
        string                    $nif,
        string                    $signalAmount,
        int                       $lights,
        int                       $rooms,
        int                       $menu,
        int                       $fireworks,
        string                    $fireType,
        string                    $observations,
        public readonly ?Datetime $createdAt = new DateTime('now'),
        public readonly ?Datetime $updatedAt = new DateTime('now')
    )
    {
        $this->setGroomName($groomName);
        $this->setBrideName($brideName);
        $this->setGroomBirthDate($groomBirthDate);
        $this->setBrideBirthDate($brideBirthDate);
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
        $this->setSignalAmount($signalAmount);
        $this->setLights($lights);
        $this->setRooms($rooms);
        $this->setMenu($menu);
        $this->setFireworks($fireworks);
        $this->setFireType($fireType);
        $this->setObservations($observations);
    }

    public function getGroomName(): string
    {
        return $this->groomName;
    }
    public function getBrideName(): string
    {
        return $this->brideName;
    }
    public function getGroomBirthDate(): DateTime
    {
        return $this->groomBirthDate;
    }
    public function getBrideBirthDate(): DateTime
    {
        return $this->brideBirthDate;
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
    public function getLights(): int
    {
        return $this->lights;
    }
    public function getRooms(): int
    {
        return $this->rooms;
    }
    public function getMenu(): int
    {
        return $this->menu;
    }
    public function getFireworks(): int
    {
        return $this->fireworks;
    }
    public function getFireType(): string
    {
        return $this->fireType;
    }
    public function getSignalAmount(): string
    {
        return $this->signalAmount;
    }
    public function getObservations(): string
    {
        return $this->observations;
    }

    /**
     * @param string $name
     * @param string $fieldName
     *
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateName(string $name, string $fieldName): void
    {
        $length = strlen($name);
        if ($length < 3 || $length > 255) {
            throw new InvalidArgumentException($fieldName, "$fieldName must be between 5 and 255 characters.");
        }
    }

    /**
     * @param string $email
     * @param string $fieldName
     *
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateEmail(string $email, string $fieldName): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException($fieldName,"$fieldName must be a valid email address.");
        }
    }

    private function validatePhone(string $phone, string $fieldName): void
    {
        // Basic validation for demonstration, adjust as needed
        if (!preg_match('/^[0-9]{8,15}$/', $phone)) {
            throw new \InvalidArgumentException("$fieldName must be a valid phone number.");
        }
    }

    private function validateNif(string $nif): void
    {
        if (empty($nif))
        {
            return ;
        }
        // Basic validation for demonstration, adjust as needed
        if (!preg_match('/^[0-9]{9}$/', $nif)) {
            throw new \InvalidArgumentException("nif must be a valid fiscal number (NIF).");
        }
    }

    // Setters with validations

    /**
     * @param string $groomName
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function setGroomName(string $groomName): void
    {
        $this->validateName($groomName, 'groomName');
        $this->groomName = $groomName;
    }

    /**
     * @param string $brideName
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function setBrideName(string $brideName): void
    {
        $this->validateName($brideName, 'brideName');
        $this->brideName = $brideName;
    }

    /**
     * @param DateTime $groomBirthDate
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function setGroomBirthDate(DateTime $groomBirthDate): void
    {
        if ($groomBirthDate > new DateTime('now')) {
            throw new InvalidArgumentException('groomBirthDate', "'groomBirthDate' must be a valid DateTime.");
        }
        $this->groomBirthDate = $groomBirthDate;
    }

    /**
     * @param DateTime $brideBirthDate
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function setBrideBirthDate(DateTime $brideBirthDate): void
    {
        if ($brideBirthDate > new DateTime('now')) {
            throw new InvalidArgumentException('brideBirthDate', "'brideBirthDate' must be a valid DateTime.");
        }
        $this->brideBirthDate = $brideBirthDate;
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
        $this->eventDate = $eventDate;
    }

    public function setAlternativeDates(String $alternativeDates): void
    {
        $this->alternativeDates = $alternativeDates;
    }


    public function setClosedDate(DateTime $closedDate): void
    {
        $this->closedDate = $closedDate;
    }

    public function setTastingDate(DateTime $tastingDate): void
    {
        $this->tastingDate = $tastingDate;
    }

    public function setNif(string $nif): void
    {
        $this->validateNif($nif);
        $this->nif = $nif;
    }

    public function setSignalAmount(string $signalAmount): void
    {
        // Validation logic for signalAmount, if needed
        $this->signalAmount = $signalAmount;
    }

    public function setLights(int $lights): void
    {
        // Validation logic for lights, if needed
        $this->lights = $lights;
    }

    public function setRooms(int $rooms): void
    {
        // Validation logic for rooms, if needed
        $this->rooms = $rooms;
    }

    public function setMenu(int $menu): void
    {
        // Validation logic for menu, if needed
        $this->menu = $menu;
    }

    public function setFireworks(int $fireworks): void
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

    public function jsonSerialize(): array
    {
        return [
            'id'             => $this->id,
            'groomName'      => $this->groomName,
            'brideName'      => $this->brideName,
            'groomBirthDate' => $this->groomBirthDate->format(DateTimeInterface::ATOM),
            'brideBirthDate' => $this->brideBirthDate->format(DateTimeInterface::ATOM),
            'groomEmail'     => $this->groomEmail,
            'brideEmail'     => $this->brideEmail,
            'groomPhone'     => $this->groomPhone,
            'bridePhone'     => $this->bridePhone,
            'groomAddress'   => $this->groomAddress,
            'brideAddress'   => $this->brideAddress,
            'typeOfEvent'    => $this->typeOfEvent,
            'civilOrChurch'  => $this->civilOrChurch,
            'eventYear'      => $this->eventDate->format('Y'),
            'eventDate'      => $this->eventDate->format(DateTimeInterface::ATOM),
            'closedDate'     => $this->closedDate->format(DateTimeInterface::ATOM),
            'tastingDate'    => $this->tastingDate->format(DateTimeInterface::ATOM),
            'nif'            => $this->nif,
            'signalAmount'   => $this->signalAmount,
            'lights'         => $this->lights,
            'rooms'          => $this->rooms,
            'menu'           => $this->menu,
            'fireworks'      => $this->fireworks,
            'fireType'       => $this->fireType,
            'observations'   => $this->observations,
            'createdAt'      => $this->createdAt->format(DateTimeInterface::ATOM),
            'updatedAt'      => $this->updatedAt->format(DateTimeInterface::ATOM),
        ];
    }
}
