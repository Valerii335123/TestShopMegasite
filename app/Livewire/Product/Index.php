<?php

namespace App\Livewire\Product;

use App\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('app')]
class Index extends Component
{
    use WithPagination;

    public ?string $search = null;
    public ?string $sort = null;
    public int $perPage = 10;

    protected array $validProperties = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'min:2', 'max:255'],
            'sort' => ['nullable', 'string', Rule::in(['name', '-name', 'price', '-price', 'stock', '-stock'])],
        ];
    }

    public function mount()
    {
        $this->updateValidProperties();
    }

    public function updated()
    {
        $this->updateValidProperties();

        if (count($this->validProperties)) {
            $this->resetPage();
        }
    }

    public function render(ProductFilter $filter)
    {
        $products = Product::query()
            ->filter($filter->fromArray($this->validProperties))
            ->paginate($this->perPage);

        return view('livewire.product.index', [
            'products' => $products
        ]);
    }

    private function updateValidProperties(): void
    {
        $validated = $this->validate();

        foreach ($validated as $key => $value) {
            $this->validProperties[$key] = $value;
        }
    }
} 