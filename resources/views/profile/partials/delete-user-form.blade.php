<section class="space-y-6">
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </div>

    <button
        class="btn btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="fas fa-trash-alt mr-2"></i>{{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ __('Are you sure you want to delete your account?') }}
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="form-group mt-4">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control"
                        placeholder="{{ __('Password') }}"
                    />
                </div>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    <i class="fas fa-times mr-2"></i>{{ __('Cancel') }}
                </button>

                <button type="submit" class="btn btn-danger ml-3">
                    <i class="fas fa-trash-alt mr-2"></i>{{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
