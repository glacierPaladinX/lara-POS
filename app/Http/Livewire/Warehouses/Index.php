<?php

namespace App\Http\Livewire\Warehouses;

use Livewire\Component;
use App\Http\Livewire\WithSorting;
use Illuminate\Support\Facades\Gate;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, WithSorting, WithFileUploads, LivewireAlert;

    public $warehouse;

    public int $perPage;

    public $listeners = ['refreshIndex','confirmDelete', 'delete', 'showModal', 'editModal'];

    public $showModal;

    public $createModal;

    public $editModal;

    public array $orderable;

    public string $search = '';

    public array $selected = [];

    public array $paginationOptions;

    public $refreshIndex;

    protected $queryString = [
        'search' => [
            'except' => '',
        ],
        'sortBy' => [
            'except' => 'id',
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function refreshIndex()
    {
        $this->resetPage();
    }

    public array $rules = [
        'warehouse.name' => ['string', 'required'],
        'warehouse.phone' => ['string', 'nullable'],
    ];

    public function mount()
    {
        $this->sortBy            = 'id';
        $this->sortDirection     = 'desc';
        $this->perPage           = 100;
        $this->paginationOptions = config('project.pagination.options');        
        $this->orderable = (new Warehouse())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('warehouse_access'), 403);

        $query = Warehouse::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $warehouses = $query->paginate($this->perPage);

        return view('livewire.warehouses.index', compact('warehouses'));
    }

    public function showModal(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_show'), 403);

        $this->warehouse = $warehouse;

        $this->showModal = true;
    }
    
    public function editModal(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->warehouse = $warehouse;

        $this->editModal = true;
    }

    public function update()
    {
        abort_if(Gate::denies('warehouse_edit'), 403);

        $this->validate();

        $this->warehouse->save();

        $this->editModal = false;

        $this->alert('success', 'Warehouse updated successfully');
    }


    public function delete(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_delete'), 403);

        $warehouse->delete();

        $this->alert('success', 'Warehouse successfully deleted.');
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('warehouse_delete'), 403);

        Warehouse::whereIn('id', $this->selected)->delete();

        $this->alert('success', 'Warehouses successfully deleted.');
    }

}
