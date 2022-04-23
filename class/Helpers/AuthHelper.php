<?php

AuthHelper::launchSession();

class AuthHelper
{
    /**
     * Launches the session if it's not already started.
     * @return void
     */
    public static function launchSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    /**
     * Returns true if the user is already connected, false otherwise.
     * @return bool
     */
    public static function isConnected(): bool
    {
        return isset($_SESSION['clientID']);
    }
    
    /**
     * Redirects the user.
     * @param string $link The new location.
     */
    public static function redirect(string $link): void
    {
        header("Location: $link");
        die();
    }

    /**
     * Redirects the user if he is not connected.
     * @param string $redirection The redirection path.
     */
    public static function mustBeConnected(string $redirection): void
    {
        if (!self::isConnected()) self::redirect($redirection);
    }

    /**
     * Redirects the user if he is connected.
     * @param string $redirection The redirection path.
     */
    public static function mustBeNotConnected(string $redirection): void
    {
        if (self::isConnected()) self::redirect($redirection);
    }

    /**
     * Checks whether a php file has been opened with Ajax or not.
     * @return bool
     */
    public static function isAjax(): bool
    {
        return !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Exits if a php file has been opened without ajax.
     */
    public static function needsAjax(): void
    {
        if (!self::isAjax()) die("Unauthorised access");
    }
}