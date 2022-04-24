<?php

class Client {
	protected $email;
	protected $clientID;
	protected $firstname;
	protected $lastname;
	protected $password;
	protected $registrationDate;
	protected $streamerMode;
	protected $darkMode;

	public function getEmail(): string {
			return $this->email;
	}

	public function getClientID(): string {
			return $this->clientID;
	}

	public function getFirstname(): string {
			return $this->firstname;
	}

	public function getLastname(): string {
			return $this->lastname;
	}

	public function getHashedPassword(): string {
			return $this->password;
	}

	public function getRegistrationDate(): DateTime {
			return new DateTime('@' . $this->registrationDate);
	}

	public function hasStreamerMode(): bool {
			return (bool)$this->streamerMode;
	}

	public function hasDarkMode(): bool {
			return (bool)$this->darkMode;
	}
}