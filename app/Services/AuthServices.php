<?php

namespace App\Services;

use App\Events\UserSignedUp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthServices
{
    private const VERIFICATION_CODE_LENGTH = 6;

    private const VERIFICATION_CODE_EXPIRY_MINUTES = 15;

    public function signup(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->setVerificationCode($user);

        event(new UserSignedUp($user));

        return $user;
    }

    public function signin(array $data): User
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new \InvalidArgumentException('Invalid credentials');
        }

        // TODO: Check email verification status

        return $user;
    }

    private function generateVerificationCode(): string
    {
        return str_pad((string) random_int(0, 999999), self::VERIFICATION_CODE_LENGTH, '0', STR_PAD_LEFT);
    }

    public function verifyCode(User $user, string $code): bool
    {
        if (! hash_equals((string) $user->verification_code, $code)) {
            return false;
        }

        if ($user->verification_code_expires_at < now()) {
            return false;
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        return true;
    }

    public function resendVerificationCode(User $user): void
    {
        $this->setVerificationCode($user);
        event(new UserSignedUp($user));
    }

    private function setVerificationCode(User $user): void
    {
        $user->update([
            'verification_code' => $this->generateVerificationCode(),
            'verification_code_expires_at' => now()->addMinutes(self::VERIFICATION_CODE_EXPIRY_MINUTES),
        ]);
    }
}
