<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\StaticBlock;
use Livewire\WithFileUploads;

class StaticBlock extends Component
{
    use WithFileUploads;

    public $staticBlocks, $content, $title, $image, $blockId;
    public $isModalOpen = 0;

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

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->title = '';
        $this->content = '';
        $this->image = '';
    }
    
    public function save()
    {
        $this->validate([
            'title' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $block = StaticBlock::updateOrCreate(['id' => $this->blockId], [
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
        session()->flash('message', 'Block Deleted Successfully.');
    }
}
