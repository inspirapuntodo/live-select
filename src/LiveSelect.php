<?php

namespace Inspirapuntodo\LiveSelect;

use Livewire\Component;

class LiveSelect extends Component {
    public $name;
    public $placeholder;
    public $value;
    public $loadingMessage;

    public $model;
    public $optionsValues;

    public $searchable;
    public $searchTerm;

    public $disabled;
    public $nullable;

    public $emptyOptionMessage;

    public function mount(
        $name,
        $value = null,
        $model = null,
        $disabled = false,
        $nullable = false,
        $placeholder = 'Select an option',
        $loadingMessage = 'Loading...',
        $emptyOptionMessage = 'No results match your search.',
        $searchable = false,
        $extras = []
    ) {
        $this->name = $name;

        $this->model = $model;

        $this->searchable = $searchable;

        $this->placeholder = $placeholder;
        $this->emptyOptionMessage = $emptyOptionMessage;
        $this->loadingMessage = $loadingMessage;

        $this->value = $value;
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