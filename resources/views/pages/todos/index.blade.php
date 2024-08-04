<?php

use App\Models\Todo;
use function Livewire\Volt\{state, rules, computed};

state(['name' => '']);
rules(['name' => 'required']);

$todos = computed(function() {
    return Todo::orderBy('completed')->get();
});

$save = function() {
    $validated = $this->validate();
    Todo::create($validated);
    $this->reset();
    session()->flash('status', 'New todo saved.');
};

$complete = function(Todo $todo) {
    $todo->update(['completed' => true]);
    session()->flash('status', 'Todo completed.');
};

$delete = function(Todo $todo) {
    $todo->delete();
    session()->flash('status', 'Todo deleted.');
}
?>
<x-layouts.app>
	@volt
	<main>
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
		<table class="table">
			<thead>
			<tr>
				<th scope="col">
					#
				</th>
				<th scope="col">
					Name
				</th>
				<th scope="col">
					Action
				</th>
			</tr>
			</thead>
			<tbody>
			@foreach($this->todos as $todo)
				<tr @if($todo->completed) class="table-primary" @endif>
					<th scope="row">
						{{ $loop->index + 1 }}
					</th>
					<td>
						{{ $todo->name }}
					</td>
					<td>
						<button wire:click="delete({{ $todo->id }})" class="btn btn-sm btn-danger float-end">
							Delete
						</button>
						@if(!$todo->completed)
							<button wire:click="complete({{ $todo->id }})" class="btn btn-sm btn-success float-end">
								Completed
							</button>
						@endif
					</td>
				</tr>
			@endforeach
            </tbody>
        </table>
    </main>
    @endvolt
</x-layouts.app>
