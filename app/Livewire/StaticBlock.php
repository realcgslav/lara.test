<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\StaticBlock;
use Livewire\WithFileUploads;

class StaticBlock extends Component
{
    use WithFileUploads;

    public $staticBlocks, $content, $title, $image, $blockId;
    public $isModalOpen = false;

    public function render()
    {
        $this->staticBlocks = StaticBlock::all();
        return view('livewire.static-block');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModal();
    }

    private function resetCreateForm()
    {
        $this->content = '';
        $this->title = '';
        $this->image = null;
        $this->blockId = null;
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
            'title' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        StaticBlock::updateOrCreate(['id' => $this->blockId], [
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image ? $this->image->store('images', 'public') : null,
        ]);

        $this->closeModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $block = StaticBlock::findOrFail($id);
        $this->blockId = $id;
        $this->title = $block->title;
        $this->content = $block->content;
        $this->image = $block->image;

        $this->openModal();
    }

    public function delete($id)
    {
        StaticBlock::find($id)->delete();
    }
}
