<div>
    <h1>Slider Images</h1>

    <form wire:submit.prevent="save">
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" wire:model="image">
            @error('image')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" wire:model="title">
            @error('title')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" wire:model="description"></textarea>
            @error('description')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Save</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <td><img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}"
                            width="100">
                    </td>
                    <td>{{ $slider->title }}</td>
                    <td>{{ $slider->description }}</td>
                    <td>{{ $slider->order }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
