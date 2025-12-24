<?php

if (!function_exists('normalize_email')) {

    /**
     * Normalize email to prevent Gmail alias abuse
     *
     * Example:
     * sandeeppal8471+1@gmail.com → sandeeppal8471@gmail.com
     * sandeep.pal@gmail.com     → sandeeppal8471@gmail.com
     */
    function normalize_email(string $email): string
    {
        $email = strtolower(trim($email));

        if (str_contains($email, '@gmail.com')) {
            [$local, $domain] = explode('@', $email);

            // remove +alias
            $local = explode('+', $local)[0];

            // remove dots
            $local = str_replace('.', '', $local);

            return $local . '@' . $domain;
        }

        return $email;
    }
}
