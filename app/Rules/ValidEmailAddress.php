<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmailAddress implements ValidationRule
{
    /**
     * List of blocked disposable / fake email domains.
     */
    private array $blockedDomains = [
        'yopmail.com', 'mailinator.com', 'tempmail.com', 'dispostable.com',
        '10minutemail.com', 'guerrillamail.com', 'trashmail.com', 'sharklasers.com',
        'fakeinbox.com', 'generator.email', 'getnada.com', 'throwawaymail.com',
        'temp-mail.org', 'maildrop.cc', '0815.ru', '10minutemail.net', 'tempmail.net'
    ];

    /**
     * Common domain typo suggestions/corrections.
     */
    private array $typoDomains = [
        'gmal.com'   => 'gmail.com',
        'gmaill.com' => 'gmail.com',
        'gamil.com'  => 'gmail.com',
        'gmial.com'  => 'gmail.com',
        'gmai.com'   => 'gmail.com',
        'yaho.com'   => 'yahoo.com',
        'yaho.co.id' => 'yahoo.co.id',
        'outlok.com' => 'outlook.com',
        'hotmial.com'=> 'hotmail.com',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || empty(trim($value))) {
            $fail('Alamat email wajib diisi.');
            return;
        }

        $email = trim(strtolower($value));

        // 1. Basic RFC email format check
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fail('Format alamat email tidak valid.');
            return;
        }

        // 2. Strict regex for domain structure & extension (e.g. name@domain.ext or name@sub.domain.ext)
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,12}$/';
        if (!preg_match($pattern, $email)) {
            $fail('Format alamat email tidak valid (harus menggunakan domain resmi seperti @gmail.com, @yahoo.com, @umi.ac.id, dll).');
            return;
        }

        // Extract domain part
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            $fail('Format alamat email tidak valid.');
            return;
        }

        $domain = $parts[1];

        // 3. Check for common domain typos
        if (array_key_exists($domain, $this->typoDomains)) {
            $suggest = $this->typoDomains[$domain];
            $fail("Domain email tidak valid. Apakah maksud Anda '@{$suggest}'?");
            return;
        }

        // 4. Block disposable / fake email domains
        if (in_array($domain, $this->blockedDomains)) {
            $fail('Gunakan alamat email resmi atau penyedia email terpercaya (misal: Gmail, Yahoo, Email Kampus/Institusi). Email sementara tidak diperbolehkan.');
            return;
        }

        // 5. Verify TLD length and valid characters (at least 2 letters, no numbers in TLD)
        $domainParts = explode('.', $domain);
        $tld = end($domainParts);
        if (strlen($tld) < 2 || !preg_match('/^[a-z]+$/', $tld)) {
            $fail('Ekstensi domain email tidak valid.');
            return;
        }
    }
}
