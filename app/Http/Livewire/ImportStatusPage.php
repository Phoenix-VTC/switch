<?php

namespace App\Http\Livewire;

use App\Models\StartedImport;
use Livewire\Component;

class ImportStatusPage extends Component
{
    public StartedImport $import;

    public function mount($uuid): void
    {
        $this->import = StartedImport::where('uuid', $uuid)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.import-status-page');
    }
}
