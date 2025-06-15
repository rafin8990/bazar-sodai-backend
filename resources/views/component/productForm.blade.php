<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" x-model="formData.name" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Price</label>
        <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" x-model="formData.price" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Original Price</label>
        <input type="number" name="original_price" step="0.01" class="w-full border rounded px-3 py-2" x-model="formData.original_price">
    </div>
    <div>
        <label class="block text-sm font-medium">Weight</label>
        <input type="text" name="weight" class="w-full border rounded px-3 py-2" x-model="formData.weight">
    </div>
    <div>
        <label class="block text-sm font-medium">Category</label>
        <select name="category_id" class="w-full border rounded px-3 py-2" x-model="formData.category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" class="w-full border rounded px-3 py-2" rows="3" x-model="formData.description"></textarea>
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-medium">Nutritional Info</label>
        <textarea name="nutritional_info" class="w-full border rounded px-3 py-2" rows="2" x-model="formData.nutritional_info"></textarea>
    </div>
    <div>
        <label class="block text-sm font-medium">Image</label>
        <input type="file" name="image" class="w-full">
        <template x-if="formData.image">
            <img :src="`/${formData.image}`" alt="Product Image" class="mt-2 h-20 w-20 object-cover rounded border" />
        </template>
    </div>

    <!-- Boolean Toggles -->
    <div class="space-y-2">
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="in_stock" class="h-4 w-4" :checked="formData.in_stock" @change="formData.in_stock = $event.target.checked">
            <span class="text-sm font-medium">In Stock</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="is_top_selling" class="h-4 w-4" :checked="formData.is_top_selling" @change="formData.is_top_selling = $event.target.checked">
            <span class="text-sm font-medium">Top Selling</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="is_new_arrival" class="h-4 w-4" :checked="formData.is_new_arrival" @change="formData.is_new_arrival = $event.target.checked">
            <span class="text-sm font-medium">New Arrival</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="is_featured" class="h-4 w-4" :checked="formData.is_featured" @change="formData.is_featured = $event.target.checked">
            <span class="text-sm font-medium">Featured</span>
        </label>
    </div>
</div>

<div class="text-right mt-4">
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md shadow">Save</button>
</div>
