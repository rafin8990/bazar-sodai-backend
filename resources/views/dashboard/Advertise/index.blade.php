@extends('dashboard.app')

@section('title', 'Advertise Management')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="advertiseHandler()">
    <h1 class="text-2xl font-bold mb-6 text-gray-200">Advertise Management</h1>

    @include('Alert.alert')

    <!-- Create Button -->
    <button @click="openCreateModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6 hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl flex items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Create Advertise</span>
    </button>

    <!-- Modal -->
    <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50" x-cloak @click.self="closeModal">
        <div class="bg-slate-800 p-6 rounded-xl w-full max-w-xl shadow-2xl relative border border-slate-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-200" x-text="form.id ? 'Update Advertise' : 'Create Advertise'"></h2>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-200 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form :action="form.id ? `/dashboard/advertise/${form.id}` : '{{ route('advertise.store') }}'" method="POST" enctype="multipart/form-data">
                @csrf
                <template x-if="form.id">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-2 text-gray-300">Title</label>
                        <input type="text" name="title" x-model="form.title" class="w-full bg-slate-700 border border-slate-600 text-gray-200 p-2 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block font-medium mb-2 text-gray-300">Button Text</label>
                        <input type="text" name="btn_text" x-model="form.btn_text" class="w-full bg-slate-700 border border-slate-600 text-gray-200 p-2 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block font-medium mb-2 text-gray-300">Button Link</label>
                        <input type="url" name="btn_link" x-model="form.btn_link" class="w-full bg-slate-700 border border-slate-600 text-gray-200 p-2 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block font-medium mb-2 text-gray-300">Status</label>
                        <select name="status" x-model="form.status" class="w-full bg-slate-700 border border-slate-600 text-gray-200 p-2 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block font-medium mb-2 text-gray-300">Description</label>
                    <textarea name="description" rows="3" x-model="form.description" class="w-full bg-slate-700 border border-slate-600 text-gray-200 p-2 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>

                <div class="mt-4">
                    <label class="block font-medium mb-2 text-gray-300">Image</label>
                    <input type="file" name="image" class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer mt-1">
                    <template x-if="form.image">
                        <div class="mt-2">
                            <img :src="'/uploads/advertise/' + form.image" alt="Ad Image" class="w-32 rounded shadow border border-slate-600">
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="closeModal" class="bg-slate-700 hover:bg-slate-600 text-gray-200 px-4 py-2 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-lg">
                        <span x-text="form.id ? 'Update' : 'Create'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Advertisement Table -->
    <div class="bg-slate-800 shadow-xl rounded-lg p-6 border border-slate-700">
        <h2 class="text-lg font-semibold mb-4 text-gray-200">All Advertisements</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead>
                    <tr class="bg-slate-700/50 text-left">
                        <th class="px-4 py-3 text-gray-300 font-semibold">#</th>
                        <th class="px-4 py-3 text-gray-300 font-semibold">Title</th>
                        <th class="px-4 py-3 text-gray-300 font-semibold">Image</th>
                        <th class="px-4 py-3 text-gray-300 font-semibold">Status</th>
                        <th class="px-4 py-3 text-gray-300 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisements as $index => $advertise)
                        <tr class="border-t border-slate-700 hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $advertise->title }}</td>
                            <td class="px-4 py-3">
                                @if($advertise->image)
                                    <img src="{{ asset( $advertise->image) }}" alt="Image" class="w-20 rounded border border-slate-600">
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $advertise->status === 'active' ? 'bg-green-900/30 text-green-400 border border-green-700/50' : 'bg-red-900/30 text-red-400 border border-red-700/50' }}">
                                    {{ ucfirst($advertise->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <button @click="editAdvertise({{ json_encode($advertise) }})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm transition-colors flex items-center gap-1">
                                    <i class="fas fa-edit text-xs"></i>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('advertise.destroy', $advertise->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm transition-colors flex items-center gap-1">
                                        <i class="fas fa-trash text-xs"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">No advertisements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
