<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit User</h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <div>
                <x-input-label value="Name" />
                <x-text-input class="w-full" name="name" value="{{ old('name', $user->name) }}" />
            </div>

            <div class="mt-4">
                <x-input-label value="Username" />
                <x-text-input class="w-full" name="username" value="{{ old('username', $user->username) }}" />
            </div>

            <div class="mt-4">
                <x-input-label value="New Password (optional)" />
                <x-text-input type="password" class="w-full" name="password" />
            </div>

            <x-primary-button class="mt-6">Save</x-primary-button>
        </form>
    </div>
</x-app-layout>
