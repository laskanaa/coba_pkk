<div class="min-h-screen flex flex-col lg:flex-row bg-white">
    <!-- KIRI: Ilustrasi -->
    <div class="hidden lg:flex lg:w-1/2 items-center justify-center bg-[#a9cbb7] p-12">
        <div class="text-center max-w-sm">
            <img src="{{ asset('images/loginpkk.png') }}" alt="Lovebird" class="mx-auto w-56">
            <h3 class="text-xl font-semibold text-white mt-6">Maecenas mattis egestas</h3>
            <p class="text-white mt-2 text-sm leading-relaxed">
                Erdum et malesuada fames ac ante ipsum primis in faucibus suspendisse porta.
            </p>
        </div>
    </div>

    <!-- KANAN: Form Login dengan komponen Livewire + Flux -->
    <div class="flex flex-col justify-center items-center w-full lg:w-1/2 px-6 sm:px-10 py-12">
        <div class="w-full max-w-md space-y-6">
            <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form wire:submit="login" class="flex flex-col gap-6">
                <!-- Email -->
                <flux:input wire:model.defer="email" :label="__('Email address')" type="email" required autofocus
                    autocomplete="email" placeholder="email@example.com" />

                <!-- Password -->
                <div class="relative">
                    <flux:input wire:model.defer="password" :label="__('Password')" type="password" required
                        autocomplete="current-password" :placeholder="__('Password')" viewable />

                    @if (Route::has('password.request'))
                        <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </flux:link>
                    @endif
                </div>

                <!-- Remember Me -->
                <flux:checkbox wire:model.defer="remember" :label="__('Remember me')" />

                <!-- Submit -->
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">
                        {{ __('Log in') }}
                    </flux:button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 space-x-1 rtl:space-x-reverse">
                    {{ __('Don\'t have an account?') }}
                    <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
                </div>
            @endif
        </div>
    </div>
</div>
