<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $menus;
    public $menu_id, $title, $url, $order = 0, $parent_id;
    public $isEditing = false;

    public function mount()
    {
        $this->getMenus();
    }

    public function getMenus()
    {
        $this->menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        Menu::updateOrCreate(
            ['id' => $this->menu_id],
            [
                'parent_id' => $this->parent_id,
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'url' => $this->url,
                'order' => $this->order
            ]
        );

        $this->resetForm();
        $this->getMenus();
    }

    public function edit(Menu $menu)
    {
        $this->menu_id = $menu->id;
        $this->title = $menu->title;
        $this->url = $menu->url;
        $this->order = $menu->order;
        $this->parent_id = $menu->parent_id;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        Menu::findOrFail($id)->delete();
        $this->resetForm();
        $this->getMenus();
    }

    public function resetForm()
    {
        $this->reset(['menu_id', 'title', 'url', 'order', 'parent_id', 'isEditing']);
    }

    public function render()
    {
        $menuOptions = Menu::whereNull('parent_id')->get();
        return view('livewire.admin.menu.index', compact('menuOptions'));
    }
}
