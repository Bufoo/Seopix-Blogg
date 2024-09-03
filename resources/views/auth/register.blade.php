<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Ad Soyad')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Image Upload -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Görsel')" />
            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" required />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <!-- Position -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Pozisyon')" />
            <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')"
                required autofocus autocomplete="position" />
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>

        <!-- About -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Hakkında')" />
            <x-text-input id="about" class="block mt-1 w-full" type="text" name="about" :value="old('about')" required
                autofocus autocomplete="about" />
            <x-input-error :messages="$errors->get('about')" class="mt-2" />
        </div>

        <!-- Linkedin -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Linkedin')" />
            <x-text-input id="linkedin_url" class="block mt-1 w-full" type="text" name="linkedin_url" :value="old('linkedin_url')"
                required autofocus autocomplete="linkedin_url" />
            <x-input-error :messages="$errors->get('linkedin_url')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="name" :value="__('Instagram')" />
            <x-text-input id="instagram_url" class="block mt-1 w-full" type="text" name="instagram_url" :value="old('instagram_url')"
                autofocus autocomplete="instagram_url" />
            <x-input-error :messages="$errors->get('instagram_url')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="name" :value="__('Twitter')" />
            <x-text-input id="twitter_url" class="block mt-1 w-full" type="text" name="twitter_url" :value="old('twitter_url')"
                autofocus autocomplete="twitter_url" />
            <x-input-error :messages="$errors->get('twitter_url')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Şifre')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Tekrar Şifre')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Kayıt') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>