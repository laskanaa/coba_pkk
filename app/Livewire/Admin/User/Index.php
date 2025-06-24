<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $email, $password, $password_confirmation, $userId;
    public $showModal = false;
    public $isEditMode = false;
    public $passwordStrengthText = '';
    public $passwordStrengthClass = '';
    public $passwordStrengthScore = 0;

    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($this->userId ? $this->userId : 'NULL'),
        ];

        if ($this->isEditMode) {
            $rules['password'] = 'nullable|min:8|confirmed';
        } else {
            $rules['password'] = 'required|min:8|confirmed';
        }

        // Add custom password strength validation
        $rules['password'] .= '|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/';

        return $rules;
    }

    protected $messages = [
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    public function render()
    {
        $users = User::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })->latest()->paginate(10);

        return view('livewire.admin.user.index', compact('users'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Clear password field for security

        $this->isEditMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->userId) {
            User::find($this->userId)->update($data);
            session()->flash('message', 'User updated successfully.');
        } else {
            User::create($data);
            session()->flash('message', 'User created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->dispatch('show-user-modal');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('hide-user-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->userId = '';
        $this->passwordStrengthText = '';
        $this->passwordStrengthClass = '';
        $this->passwordStrengthScore = 0;
    }

    public function updatedPassword($value)
    {
        $score = 0;
        if (strlen($value) >= 8) {
            $score += 25;
        }
        if (preg_match('/[a-z]/', $value)) {
            $score += 25;
        }
        if (preg_match('/[A-Z]/', $value)) {
            $score += 25;
        }
        if (preg_match('/[0-9]/', $value)) {
            $score += 25;
        }
        if (preg_match('/[@$!%*#?&]/', $value)) {
            $score += 25;
        }

        if ($score > 100) $score = 100;

        if ($score >= 100) {
            $this->passwordStrengthText = 'Strong';
            $this->passwordStrengthClass = 'text-success';
            $this->passwordStrengthScore = 100;
        } elseif ($score >= 75) {
            $this->passwordStrengthText = 'Medium';
            $this->passwordStrengthClass = 'text-warning';
            $this->passwordStrengthScore = 75;
        } elseif ($score >= 50) {
            $this->passwordStrengthText = 'Weak';
            $this->passwordStrengthClass = 'text-danger';
            $this->passwordStrengthScore = 50;
        } else {
            $this->passwordStrengthText = 'Very Weak';
            $this->passwordStrengthClass = 'text-danger';
            $this->passwordStrengthScore = 0;
        }
    }
}
