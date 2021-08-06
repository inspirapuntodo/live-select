<?php

namespace Inspirapuntodo\LiveSelect;

use Livewire\Component;

class LiveSelect extends Component {
    public $name;
    public $value;

    public $model;
    public $optionsValues;
    public $extras;

    public $searchable;
    public $searchTerm;

    public $disabled;
    public $nullable;

    public $emptyOptionMessage;
    public $loadingMessage;
    public $noneMessage;
    public $placeholder;

    public function mount(
        $name,
        $value = null,
        $model = null,
        $disabled = false,
        $nullable = false,
        $placeholder = 'Select an option',
        $loadingMessage = 'Loading...',
        $emptyOptionMessage = 'No results match your search.',
        $noneMessage = '',
        $searchable = false,
        $extras = []
    ) {
        $this->name = $name;

        $this->model = $model;

        $this->searchable = $searchable;

        $this->placeholder = $placeholder;
        $this->emptyOptionMessage = $emptyOptionMessage;
        $this->loadingMessage = $loadingMessage;
        $this->noneMessage = $noneMessage;

        $this->value = $value;

        $this->nullable = $nullable;
        $this->extras = $extras;
    }

    public function render() {
        $options = $this->options($this->searchTerm);

        $this->optionsValues = $options;

        return view('live-select::default')
        ->with([
            'options' => $options,
        ]);
    }
}