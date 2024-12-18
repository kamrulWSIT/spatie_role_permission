<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">

                <div class="flex flex-col p-2 bg-slate-100">
                    <div>User Name: {{ $user->name }}</div>
                    <div>User Email: {{ $user->email }}</div>
                </div>

                <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">Roles</h2>
                    <div class="flex space-x-2 mt-4 p-2">
                        @if ($roles)
                            @foreach ($roles as $role)
                                <span class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">{{ $role}}</span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">Permissions</h2>
                    <div class="flex space-x-2 mt-4 p-2">
                        @if ($permissions)
                            @foreach ($permissions as $permission)
                                <span class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">{{ $permission->name }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
