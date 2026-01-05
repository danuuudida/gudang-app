<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Manage Users</h2>
    </x-slot>

    <div class="p-6">
        @foreach ($users as $user)
            <div class="flex justify-between border-b py-2">
                <div>
                    {{ $user->name }} ({{ $user->username }})
                </div>
                <a class="text-indigo-600" href="{{ route('users.edit', $user) }}">
                    Edit
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>
