<?php

use App\Models\Todo;
use function Livewire\Volt\{state, rules};

state(['name' => '']);
rules(['name' => 'required']);


$save = function() {
    $validated = $this->validate();
    Todo::create($validated);
    $this->reset();
    session()->flash('status', 'New todo saved.');
}
?>
<x-layouts.app>
    @volt
    <div class="card">
        <div class="card-header">
            New Todo
        </div>
        <div class="card-body">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form wire:submit="save">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">
                        Todo
                    </label>
                    <input wire:model="name" type="text" class="form-control" id="exampleInputEmail1"
                           aria-describedby="emailHelp"/>
                    @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    @endvolt
</x-layouts.app>
