<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use Livewire\WithFileUploads;

class BlogPostComponent extends Component
{
    use WithFileUploads;

    public $blogPosts, $title, $content, $featuredImage, $postId;
    public $isModalOpen = false;

    public function render()
    {
        $this->blogPosts = BlogPost::all();
        return view('livewire.blog-post-component');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModal();
    }

    private function resetCreateForm()
    {
        $this->title = '';
        $this->content = '';
        $this->featuredImage = null;
        $this->postId = null;
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'featuredImage' => 'nullable|image|max:2048', // 2MB Max
        ]);

        BlogPost::updateOrCreate(['id' => $this->postId], [
            'title' => $this->title,
            'content' => $this->content,
            'featured_image' => $this->featuredImage ? $this->featuredImage->store('images', 'public') : null,
        ]);

        $this->closeModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->postId = $id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->featuredImage = $post->featured_image;

        $this->openModal();
    }

    public function delete($id)
    {
        BlogPost::find($id)->delete();
    }
}
