@extends('dashboard.app')

@section('title', 'Advertise Management')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="advertiseHandler()">
    <h1 class="text-2xl font-bold mb-6">Advertise Management</h1>

    @include('Alert.alert')

    <!-- Create Button -->
    <button @click="openCreateModal" class="bg-green-600 text-white px-4 py-2 rounded mb-6 hover:bg-green-700">
        + Create Advertise
    </button>

    <!-- Modal -->
    <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white p-6 rounded-lg w-full max-w-xl shadow-lg relative">
            <h2 class="text-xl font-semibold mb-4" x-text="form.id ? 'Update Advertise' : 'Create Advertise'"></h2>

            <form :action="form.id ? `/dashboard/advertise/${form.id}` : '{{ route('advertise.store') }}'" method="POST" enctype="multipart/form-data">
                @csrf
                <template x-if="form.id">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium">Title</label>
                        <input type="text" name="title" x-model="form.title" class="w-full border p-2 rounded mt-1">
                    </div>

                    <div>
                        <label class="block font-medium">Button Text</label>
                        <input type="text" name="btn_text" x-model="form.btn_text" class="w-full border p-2 rounded mt-1">
                    </div>

                    <div>
                        <label class="block font-medium">Button Link</label>
                        <input type="url" name="btn_link" x-model="form.btn_link" class="w-full border p-2 rounded mt-1">
                    </div>

                    <div>
                        <label class="block font-medium">Status</label>
                        <select name="status" x-model="form.status" class="w-full border p-2 rounded mt-1">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Description</label>
                    <textarea name="description" rows="3" x-model="form.description" class="w-full border p-2 rounded mt-1"></textarea>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Image</label>
                    <input type="file" name="image" class="w-full border p-2 rounded mt-1">
                    <template x-if="form.image">
                        <div class="mt-2">
                            <img :src="'/uploads/advertise/' + form.image" alt="Ad Image" class="w-32 rounded shadow">
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        <span x-text="form.id ? 'Update' : 'Create'"></span>
                    </button>
                    <button type="button" @click="closeModal" class="text-gray-500 hover:underline">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Advertisement Table -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">All Advertisements</h2>

        <table class="min-w-full table-auto text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advertisements as $index => $advertise)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $advertise->title }}</td>
                        <td class="px-4 py-2">
                            @if($advertise->image)
                                <img src="{{ asset( $advertise->image) }}" alt="Image" class="w-20 rounded">
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white text-xs {{ $advertise->status === 'active' ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ ucfirst($advertise->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <button @click="editAdvertise({{ $advertise }})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</button>

                            <form action="{{ route('advertise.destroy', $advertise->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">No advertisements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function advertiseHandler() {
    return {
        isOpen: false,
        form: {
            id: null,
            title: '',
            description: '',
            image: '',
            btn_text: '',
            btn_link: '',
            status: 'active'
        },
        openCreateModal() {
            this.resetForm();
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        },
        resetForm() {
            this.form = {
                id: null,
                title: '',
                description: '',
                image: '',
                btn_text: '',
                btn_link: '',
                status: 'active'
            };
        },
        editAdvertise(data) {
            this.form = {
                id: data.id,
                title: data.title,
                description: data.description,
                image: data.image,
                btn_text: data.btn_text,
                btn_link: data.btn_link,
                status: data.status
            };
            this.isOpen = true;
        }
    };
}
</script>
@endsection
