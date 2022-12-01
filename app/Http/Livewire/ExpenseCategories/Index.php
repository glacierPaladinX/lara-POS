<?php

namespace App\Http\Livewire\ExpenseCategories;

use App\Http\Livewire\WithSorting;
use App\Models\ExpenseCategory;
use App\Support\HasAdvancedFilter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;
    use LivewireAlert;
    use HasAdvancedFilter;

    public $expenseCategory;

    public int $perPage;

    public $listeners = ['confirmDelete', 'delete', 'refreshIndex', 'showModal', 'editModal'];

    public int $selectPage;

    public $showModal;

    public $refreshIndex;

    public $editModal;

    public array $orderable;

    public string $search = '';

    public array $selected = [];

    public array $paginationOptions;

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

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function resetSelected(): void
    {
        $this->selected = [];
    }

    public function refreshIndex(): void
    {
        $this->resetPage();
    }

    public array $rules = [
        'expenseCategory.name' => 'required',
        'expenseCategory.description' => '',
    ];

    public function mount(): void
    {
        $this->selectPage = false;
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
        $this->perPage = 100;
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new ExpenseCategory)->orderable;
    }

    public function render(): View|Factory
    {
        abort_if(Gate::denies('expense_category_access'), 403);

        $query = ExpenseCategory::advancedFilter([
            's' => $this->search ?: null,
            'order_column' => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $expenseCategories = $query->paginate($this->perPage);

        return view('livewire.expense-categories.index', compact('expenseCategories'));
    }

    public function showModal(ExpenseCategory $expenseCategory): void
    {
        abort_if(Gate::denies('expense_category_show'), 403);

        $this->expenseCategory = ExpenseCategory::find($expenseCategory->id);

        $this->showModal = true;
    }

    public function editModal(ExpenseCategory $expenseCategory): void
    {
        abort_if(Gate::denies('expense_category_edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->expenseCategory = ExpenseCategory::find($expenseCategory->id);

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->expenseCategory->save();

        $this->alert('success', __('Expense Category Updated Successfully.'));

        $this->emit('refreshIndex');

        $this->editModal = false;
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('expense_category_delete'), 403);

        ExpenseCategory::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(ExpenseCategory $expenseCategory): void
    {
        abort_if(Gate::denies('expense_category_delete'), 403);

        $expenseCategory->delete();

        $this->alert('success', __('Expense Category Deleted Successfully.'));
    }
}
