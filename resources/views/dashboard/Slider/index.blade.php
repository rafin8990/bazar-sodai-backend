@extends('dashboard.app')

@section('title', 'Slider Management')

@section('content')
    <div x-data="sliderComponent()" x-init="init()" class="container mx-auto px-4 py-8">
        @include('Alert.alert')

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-200">Slider Management</h1>
            <button @click="openCreateModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Add New Slider</span>
            </button>
        </div>

        <!-- Sliders Table -->
        <div class="overflow-x-auto bg-slate-800 rounded-lg shadow-xl border border-slate-700">
            <table class="min-w-full divide-y divide-slate-700 text-sm">
                <thead class="bg-slate-700/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Image</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Title</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Subtitle</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Button</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Status</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700" x-show="sliders.length">
                    <template x-for="slider in sliders" :key="slider.id">
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3">
                                <img :src="'/' + slider.image" class="w-20 h-12 object-cover rounded border border-slate-600" alt="Slider Image">
                            </td>
                            <td class="px-4 py-3 text-gray-300" x-text="slider.title || '-'"></td>
                            <td class="px-4 py-3 text-gray-300" x-text="slider.subtitle || '-'"></td>
                            <td class="px-4 py-3 text-gray-300" x-text="slider.button_text || '-'"></td>
                            <td class="px-4 py-3">
                                <span x-text="slider.status ? 'Active' : 'Inactive'"
                                    :class="slider.status ? 'px-2 py-1 rounded text-xs font-medium bg-green-900/30 text-green-400 border border-green-700/50' : 'px-2 py-1 rounded text-xs font-medium bg-red-900/30 text-red-400 border border-red-700/50'"></span>
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <button @click="openEditModal(slider)"
                                    class="bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded text-white text-sm transition-colors flex items-center gap-1">
                                    <i class="fas fa-edit text-xs"></i>
                                    <span>Edit</span>
                                </button>
                                <button @click="deleteSlider(slider.id)"
                                    class="bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-sm transition-colors flex items-center gap-1">
                                    <i class="fas fa-trash text-xs"></i>
                                    <span>Delete</span>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <p x-show="!sliders.length" class="p-8 text-gray-400 text-center">No sliders found.</p>
        </div>

        <!-- Modal -->
        <div class="fixed inset-0 backdrop-blur-sm bg-black/60 flex items-center justify-center z-50" x-show="isModalOpen"
            x-transition @click.self="closeModal">
            <div class="bg-slate-800 w-full max-w-xl rounded-xl shadow-2xl p-6 relative border border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-200" x-text="form.id ? 'Update Slider' : 'Create Slider'"></h2>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-200 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form @submit.prevent="submitForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-300">Title</label>
                        <input type="text" x-model="form.title" class="w-full bg-slate-700 border border-slate-600 text-gray-200 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-300">Subtitle</label>
                        <input type="text" x-model="form.subtitle" class="w-full bg-slate-700 border border-slate-600 text-gray-200 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-300">Button Text</label>
                        <input type="text" x-model="form.button_text" class="w-full bg-slate-700 border border-slate-600 text-gray-200 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-300">Button Link</label>
                        <input type="text" x-model="form.button_link" class="w-full bg-slate-700 border border-slate-600 text-gray-200 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-300">Image</label>
                        <input type="file" @change="handleImageUpload($event)" class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer" />
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="form.status" class="mr-2 w-4 h-4 text-blue-600 bg-slate-700 border-slate-600 rounded focus:ring-blue-500 focus:ring-2" />
                            <span class="text-gray-300">Active</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="closeModal" class="bg-slate-700 hover:bg-slate-600 text-gray-200 px-4 py-2 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-lg"
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