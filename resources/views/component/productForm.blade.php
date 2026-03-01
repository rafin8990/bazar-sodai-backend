<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-2 text-gray-300">Name</label>
        <input type="text" name="name" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" x-model="formData.name" required>
    </div>
    <div>
        <label class="block text-sm font-medium mb-2 text-gray-300">Price</label>
        <input type="number" name="price" step="0.01" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" x-model="formData.price" required>
    </div>
    <div>
        <label class="block text-sm font-medium mb-2 text-gray-300">Original Price</label>
        <input type="number" name="original_price" step="0.01" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" x-model="formData.original_price">
    </div>
    <div>
        <label class="block text-sm font-medium mb-2 text-gray-300">Weight</label>
        <input type="text" name="weight" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" x-model="formData.weight">
    </div>
    <div>
        <label class="block text-sm font-medium mb-2 text-gray-300">Category</label>
        <select name="category_id" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" x-model="formData.category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-medium mb-2 text-gray-300">Description</label>
        <textarea name="description" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" x-model="formData.description"></textarea>
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-medium mb-2 text-gray-300">Nutritional Info</label>
        <textarea name="nutritional_info" class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="2" x-model="formData.nutritional_info"></textarea>
    </div>
    <div>
        <label class="block text-sm font-medium mb-2 text-gray-300">Image</label>
        <input type="file" name="image" class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer">
        <template x-if="formData.image">
            <img :src="`/${formData.image}`" alt="Product Image" class="mt-2 h-20 w-20 object-cover rounded-lg border border-slate-600" />
        </template>
    </div>

    <!-- Boolean Toggles -->
    <div class="space-y-2">
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" name="in_stock" class="h-4 w-4 text-blue-600 bg-slate-700 border-slate-600 rounded focus:ring-blue-500" :checked="formData.in_stock" @change="formData.in_stock = $event.target.checked">
            <span class="text-sm font-medium text-gray-300">In Stock</span>
        </label>
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" name="is_top_selling" class="h-4 w-4 text-blue-600 bg-slate-700 border-slate-600 rounded focus:ring-blue-500" :checked="formData.is_top_selling" @change="formData.is_top_selling = $event.target.checked">
            <span class="text-sm font-medium text-gray-300">Top Selling</span>
        </label>
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" name="is_new_arrival" class="h-4 w-4 text-blue-600 bg-slate-700 border-slate-600 rounded focus:ring-blue-500" :checked="formData.is_new_arrival" @change="formData.is_new_arrival = $event.target.checked">
            <span class="text-sm font-medium text-gray-300">New Arrival</span>
        </label>
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" name="is_featured" class="h-4 w-4 text-blue-600 bg-slate-700 border-slate-600 rounded focus:ring-blue-500" :checked="formData.is_featured" @change="formData.is_featured = $event.target.checked">
            <span class="text-sm font-medium text-gray-300">Featured</span>
        </label>
    </div>
</div>

<div class="text-right mt-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-lg transition-colors">Save</button>
</div>
