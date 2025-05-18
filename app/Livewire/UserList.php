<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    public $roles;
    public $search = ''; 

    public function mount(): void
    {
        $this->roles = Role::all();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        // $this->users = User::all();
        session()->flash('message', 'ユーザーを削除しました！');
    }

    public function toggleRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        // 既にその役割が付与されているかチェック
        if ($user->roles->contains($roleId)) {
            $user->roles()->detach($roleId);
        } else {
            $user->roles()->attach($roleId);
        }
    }

    public function render()
    {
        $query = User::query();
        
        if ($this->search) {
            $query->where('email', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
        }

        return view('livewire.user-list', [
            'users' => $query->paginate(10)
        ]);
    }
}
