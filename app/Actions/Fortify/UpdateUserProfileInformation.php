<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'address' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'post_code' => ['nullable', 'string', 'max:20'],
            'category' => ['nullable', Rule::in(\App\Enums\CategoryEnum::options())],
            'record_label' => ['nullable', 'string', 'max:255'],
            'is_independent_artist' => ['nullable', 'boolean'],
            'producer_name' => ['nullable', 'string', 'max:255'],
            'manager_name' => ['nullable', 'string', 'max:255'],
            'ar_name' => ['nullable', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'address' => $input['address'],
                'country' => $input['country'],
                'post_code' => $input['post_code'],
                'category' => $input['category'],
                'record_label' => $input['record_label'],
                'is_independent_artist' => $input['is_independent_artist'],
                'producer_name' => $input['producer_name'],
                'manager_name' => $input['manager_name'],
                'ar_name' => $input['ar_name'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'address' => $input['address'],
            'country' => $input['country'],
            'post_code' => $input['post_code'],
            'category' => $input['category'],
            'record_label' => $input['record_label'],
            'is_independent_artist' => $input['is_independent_artist'],
            'producer_name' => $input['producer_name'],
            'manager_name' => $input['manager_name'],
            'ar_name' => $input['ar_name'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
