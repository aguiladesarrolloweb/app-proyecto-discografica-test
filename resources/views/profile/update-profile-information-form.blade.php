<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <span class="text-[#FF0A93] font-bold">{{ __('Profile Information') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-white">{{ __('Update your account\'s profile information and email address.') }}</span>
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" class="text-white" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full size-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2 text-white" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2 text-white" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" class="text-white" />
            <x-input id="name" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" class="text-white" />
            <x-input id="email" type="email" class="mt-1 block w-full text-white" 
                wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-white">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="text-white underline text-sm hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-white">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif

        <!-- Address -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="address" value="{{ __('Address') }}" class="text-white" />
            <x-input id="address" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.address" autocomplete="address" />
            <x-input-error for="address" class="mt-2" />
        </div>

        <!-- Country -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="country" value="{{ __('Country') }}" class="text-white" />
            <x-input id="country" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.country" autocomplete="country" />
            <x-input-error for="country" class="mt-2" />
        </div>

        <!-- Post Code -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="post_code" value="{{ __('Post Code') }}" class="text-white" />
            <x-input id="post_code" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.post_code" autocomplete="post_code" />
            <x-input-error for="post_code" class="mt-2" />
        </div>

        <!-- Category -->
        <div class="col-span-6 sm:col-span-4">
            <label for="category" class="text-white">{{ __('Category') }}</label>
            <select name="category" id="category" class="mt-1 block w-full bg-gray-800 text-white" 
                wire:model="state.category">
                <option value="">{{ __('Select a category') }}</option>
                @foreach (\App\Enums\CategoryEnum::options() as $option)
                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                @endforeach
            </select>
            <x-input-error for="category" class="mt-2" />
        </div>

        <!-- Record Label -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="record_label" value="{{ __('Record Label') }}" class="text-white" />
            <x-input id="record_label" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.record_label" autocomplete="record_label" />
            <x-input-error for="record_label" class="mt-2" />
        </div>

        <!-- Is Independent Artist -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="is_independent_artist" value="{{ __('Is Independent Artist') }}" class="text-white" />
            <x-input 
                id="is_independent_artist" 
                type="checkbox" 
                class="mt-1 block text-white" 
                wire:model="state.is_independent_artist"
                :checked="$this->user->is_independent_artist === 1"
            />
            <x-input-error for="is_independent_artist" class="mt-2" />
        </div>

        <!-- Producer Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="producer_name" value="{{ __('Producer Name') }}" class="text-white" />
            <x-input id="producer_name" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.producer_name" autocomplete="producer_name" />
            <x-input-error for="producer_name" class="mt-2" />
        </div>

        <!-- Manager Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="manager_name" value="{{ __('Manager Name') }}" class="text-white" />
            <x-input id="manager_name" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.manager_name" autocomplete="manager_name" />
            <x-input-error for="manager_name" class="mt-2" />
        </div>

        <!-- AR Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="ar_name" value="{{ __('AR Name') }}" class="text-white" />
            <x-input id="ar_name" type="text" class="mt-1 block w-full text-white" 
                wire:model="state.ar_name" autocomplete="ar_name" />
            <x-input-error for="ar_name" class="mt-2" />
        </div>



        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-white" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo" class="text-white">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
