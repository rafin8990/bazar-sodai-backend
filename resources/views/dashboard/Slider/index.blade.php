@extends('dashboard.app')

@section('title', 'Slider Management')

@section('content')
    <div x-data="sliderComponent()" x-init="init()" class="container mx-auto px-4 py-8">
        @include('Alert.alert')

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Slider Management</h1>
            <button @click="openCreateModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Add New Slider
            </button>
        </div>

        <!-- Sliders Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Subtitle</th>
                        <th class="px-4 py-3 text-left">Button</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-show="sliders.length">
                    <template x-for="slider in sliders" :key="slider.id">
                        <tr>
                            <td class="px-4 py-2">
                                <img :src="'/' + slider.image" class="w-20 h-12 object-cover rounded" alt="Slider Image">
                            </td>
                            <td class="px-4 py-2" x-text="slider.title || '-'"></td>
                            <td class="px-4 py-2" x-text="slider.subtitle || '-'"></td>
                            <td class="px-4 py-2" x-text="slider.button_text || '-'"></td>
                            <td class="px-4 py-2">
                                <span x-text="slider.status ? 'Active' : 'Inactive'"
                                    :class="slider.status ? 'text-green-600' : 'text-red-600'"></span>
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <button @click="openEditModal(slider)"
                                    class="bg-yellow-400 px-2 py-1 rounded text-white">Edit</button>
                                <button @click="deleteSlider(slider.id)"
                                    class="bg-red-500 px-2 py-1 rounded text-white">Delete</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <p x-show="!sliders.length" class="p-4 text-gray-600 text-center">No sliders found.</p>
        </div>

        <!-- Modal -->
        <div class="fixed inset-0 backdrop-blur-sm bg-opacity-40 flex items-center justify-center z-50" x-show="isModalOpen"
            x-transition>
            <div class="bg-white w-full max-w-xl rounded-lg shadow p-6 relative">
                <h2 class="text-xl font-semibold mb-4" x-text="form.id ? 'Update Slider' : 'Create Slider'"></h2>

                <form @submit.prevent="submitForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Title</label>
                        <input type="text" x-model="form.title" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Subtitle</label>
                        <input type="text" x-model="form.subtitle" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Button Text</label>
                        <input type="text" x-model="form.button_text" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Button Link</label>
                        <input type="text" x-model="form.button_link" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Image</label>
                        <input type="file" @change="handleImageUpload($event)" class="w-full" />
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" x-model="form.status" class="mr-2" />
                            Active
                        </label>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded"
                            x-text="form.id ? 'Update' : 'Create'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function sliderComponent() {
            return {
                sliders: [],
                isModalOpen: false,
                form: {
                    id: null,
                    title: '',
                    subtitle: '',
                    button_text: '',
                    button_link: '',
                    status: true,
                    image: null
                },

                fetchSliders() {
                    fetch('/api/sliders')
                        .then(res => res.json())
                        .then(data => {
                            this.sliders = data.data || [];
                        });
                },

                openCreateModal() {
                    this.resetForm();
                    this.isModalOpen = true;
                },

                openEditModal(slider) {
                    this.form = { ...slider, image: null };
                    this.isModalOpen = true;
                },

                handleImageUpload(e) {
                    this.form.image = e.target.files[0];
                },

                submitForm() {
                    let formData = new FormData();
                    formData.append('title', this.form.title || '');
                    formData.append('subtitle', this.form.subtitle || '');
                    formData.append('button_text', this.form.button_text || '');
                    formData.append('button_link', this.form.button_link || '');
                    formData.append('status', this.form.status ? 1 : 0);
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }

                    const url = this.form.id ? `/api/sliders/update/${this.form.id}` : '/api/sliders/create';

                    fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert(data.message || 'Success');
                            this.fetchSliders();
                            this.closeModal();
                        })
                        .catch(() => alert('Something went wrong!'));
                },

                deleteSlider(id) {
                    if (!confirm('Are you sure you want to delete this slider?')) return;

                    fetch(`/api/sliders/delete/${id}`, {
                        method: 'POST'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert(data.message || 'Deleted');
                            this.fetchSliders();
                        })
                        .catch(() => alert('Delete failed!'));
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.resetForm();
                },

                resetForm() {
                    this.form = {
                        id: null,
                        title: '',
                        subtitle: '',
                        button_text: '',
                        button_link: '',
                        status: true,
                        image: null
                    };
                },

                init() {
                    this.fetchSliders();
                }
            }
        }
    </script>
@endsection