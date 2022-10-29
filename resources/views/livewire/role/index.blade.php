<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-md-0 my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @can('role_delete')
                <button
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled"
                    {{ $this->selectedCount ? '' : 'disabled' }}>
                            <i class="fas fa-trash"></i>
                </button>
            @endcan
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
            <input type="text" wire:model.debounce.300ms="search"
                class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                placeholder="{{ __('Search') }}" />
        </div>
    </div>
    <div wire:loading.delay>
        Loading...
    </div>

    <div>
        <x-table>
            <x-slot name="thead">
                <x-table.th>#</x-table.th>
                <x-table.th sortable wire:click="sortBy('title')" :direction="$sorts['title'] ?? null">
                    {{ __('Title') }}
                    @include('components.table.sort', ['field' => 'title'])
                </x-table.th>
                <x-table.th>
                    {{ __('Permissions') }}
                </x-table.th>
                <x-table.th>
                    {{ __('Actions') }}
                </x-table.th>
            </x-slot>
            <x-table.tbody>
                @forelse($roles as $role)
                    <x-table.tr>
                        <x-table.td>
                            <input type="checkbox" value="{{ $role->id }}" wire:model="selected">
                        </x-table.td>
                        <x-table.td>
                            {{ $role->name }}
                        </x-table.td>
                        <x-table.td class="flex flex-wrap space-x-2 space-y-2">
                            @foreach($role->permissions as $permission)
                                <x-badge primary>{{ $permission->name }}</x-badge>
                            @endforeach
                        </x-table.td>
                        <x-table.td>
                            <div class="inline-flex">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <x-button primary wire:click="editModal({{ $role->id }})" wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i>
                                </x-button>
                                <x-button danger type="button" wire:click="confirm('delete', {{ $role->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-trash"></i>
                                </x-button>

                            </div>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10" class="text-center">
                            {{ __('No entries found.') }}
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-table.tbody>
        </x-table>
    </div>

    <div class="p-4">
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $roles->links() }}
        </div>
    </div>

    
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Role') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="update">
                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input type="text" class="form-control" id="title" wire:model="role.title">
                    @error('role.title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <x-select-list
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        required id="permissions" name="permissions" wire:model="permissions" :options="$this->listsForFields['permissions']"
                        multiple />
                </div>
                <div class="w-full flex justify-end">
                    <x-button primary  type="submit" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-button>

                    <x-button secondary class="ml-2" wire:click="$set('editModal', false)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-button>

                </div>
            </form>

        </x-slot>
    </x-modal>

    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('create') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input type="text" class="form-control" id="title" wire:model="role.title">
                    @error('role.title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <x-select-list
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        required id="permissions" name="permissions" wire:model="permissions" :options="$this->listsForFields['permissions']"
                        multiple />
                </div>
                <div class="w-full flex justify-end">
                    <x-button primary  type="submit" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-button>

                    <x-button secondary class="ml-2" wire:click="$set('createModal', false)"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-button>

                </div>
            </form>
        </x-slot>
    </x-modal>
</div>



@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('deleteModal', roleId => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('delete', roleId)
                    }
                })
            })
        })
    </script>
@endpush

