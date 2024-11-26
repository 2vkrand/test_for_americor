<?php

namespace App\Clients\Application\Request;

class CreateClientRequest
{
    /**
     * @var string|mixed
     */
    public string $firstName;
    /**
     * @var string|mixed
     */
    public string $lastName;
    /**
     * @var int|mixed
     */
    public int $age;
    /**
     * @var string|mixed
     */
    public string $city;
    /**
     * @var string|mixed
     */
    public string $state;
    /**
     * @var string|mixed
     */
    public string $zip;
    /**
     * @var int|mixed
     */
    public int $ficoScore;
    /**
     * @var float|mixed
     */
    public float $income;
    /**
     * @var string|mixed
     */
    public string $ssn;
    /**
     * @var string|mixed
     */
    public string $email;
    /**
     * @var string|mixed
     */
    public string $phoneNumber;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (
            !isset(
                $data['firstName'],
                $data['lastName'],
                $data['age'],
                $data['city'],
                $data['state'],
                $data['zip'],
                $data['ficoScore'],
                $data['income'],
                $data['ssn'],
                $data['email'],
                $data['phoneNumber']
            )
        ) {
            throw new \InvalidArgumentException('Invalid input data');
        }

        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->age = $data['age'];
        $this->city = $data['city'];
        $this->state = $data['state'];
        $this->zip = $data['zip'];
        $this->ficoScore = $data['ficoScore'];
        $this->income = $data['income'];
        $this->ssn = $data['ssn'];
        $this->email = $data['email'];
        $this->phoneNumber = $data['phoneNumber'];
    }
}
