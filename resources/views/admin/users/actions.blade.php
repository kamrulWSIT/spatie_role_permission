<div class="flex justify-end">
    <div class="flex space-x-2">

        <a href="{{ route('admin.users.show', $user->id) }}"
        class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Roles</a>
        <form
            class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md"
            method="POST"
            action="{{ route('admin.users.destroy', $user->id) }}"
            onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>

    </div>
</div>
