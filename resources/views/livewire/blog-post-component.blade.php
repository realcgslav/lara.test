<div>
    <!-- Form for Adding/Editing Blog Post -->
    <form wire:submit.prevent="save">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" wire:model="title">
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" wire:model="content"></textarea>
        </div>
        <div>
            <label for="image">Featured Image:</label>
            <input type="file" id="image" wire:model="featuredImage">
        </div>
        <button type="submit">Save Post</button>
    </form>

    <!-- Display Blog Posts -->
    <div>
        @foreach ($blogPosts as $post)
            <div>
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->content }}</p>
                @if($post->featuredImage)
                    <img src="{{ asset('storage/'.$post->featuredImage) }}" alt="Featured Image">
                @endif
                <button wire:click="edit({{ $post->id }})">Edit</button>
                <button wire:click="delete({{ $post->id }})">Delete</button>
            </div>
        @endforeach
    </div>
</div>
