<?php

namespace Inspirapuntodo\LiveSelect;

use Livewire\Component;

class LiveSelect extends Component {
    public $name;
    public $placeholder;

    public $model;
    public $optionsValues;

    public $searchable;
    public $searchTerm;

    var $disabled;
    var $nullable;

    public $noResultsMessage;

    public function mount(
        $name,
        $model = null,
        $disabled = false,
        $nullable = false,
        $placeholder = 'Select an option',
        $searchable = false,
        $noResultsMessage = 'No options found',
        $extras = []
    ) {
        $this->name = $name;
        $this->placeholder = $placeholder;

        $this->model = $model;

        $this->searchable = $searchable;

        $this->noResultsMessage = $noResultsMessage;
    }

    public function render() {
        $options = $this->options($this->searchTerm);

        $this->optionsValues = $options;

        return view('live-select::default')
        ->with([
            'options' => $options,
            'selectedOption' => $selectedOption ?? null,
            #'shouldShow' => $shouldShow,
            #'styles' => $styles,
        ]);
    }

    //
    public function selectedOption($value) {
        return null;
    }
}