<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Bio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Form to edit bio -->
                    <form method="post" action="{{ route('profile.update-bio') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        <div>
                            <x-input-label for="bio" :value="__('Bio')" />
                            <textarea id="bio" name="bio" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100" required>{{ old('bio', $bio->bio ?? '') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>
                        
                        <!-- Dropdown for selecting Personality Type -->
                        <div>
                            <x-input-label for="personality_type" :value="__('Personality Type')" />
                            <select id="personality_type_id" name="personality_type_id" 
                                class="block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('Select a Personality Type') }}</option>
                                @foreach ($personalityTypes as $type)
                                    <option value="{{ $type->id }}" 
                                        {{ old('personality_type_id', $user->personalityType?->id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->type }}: {{ $type->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('personality_type')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Bio') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('status') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            // Log the selected value of the dropdown to the console
            const personalitySelect = document.getElementById('personality_type');
            if (personalitySelect) {
                personalitySelect.addEventListener('change', function() {
                    console.log('Selected Personality Type ID:', personalitySelect.value);
                });
            }
        });
    </script>
</x-app-layout>