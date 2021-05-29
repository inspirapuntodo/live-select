<?php

namespace Inspirapuntodo\LiveSelect;

use Livewire\Component;

class LiveSelect extends Component {
    public $name;
    public $placeholder;

    public $value;
    public $optionsValues;

    public $searchable;
    public $searchTerm;

    var $disabled;
    var $nullable;

    public $noResultsMessage;

    public function mount(
        $name,
        $value = null,
        $disabled = false,
        $nullable = false,
        $placeholder = 'Select an option',
        $searchable = false,
        $noResultsMessage = 'No options found',
        $extras = []
    ) {
        $this->name = $name;
        $this->placeholder = $placeholder;

        $this->value = $value;

        $this->searchable = $searchable;
        $this->searchTerm = '';

        $this->noResultsMessage = $noResultsMessage;
    }

    public function render() {
        if ($this->searchable) {
            if ($this->isSearching()) {
                $options = $this->options($this->searchTerm);
            } else {
                $options = collect();
            }
        } else {
            $options = $this->options($this->searchTerm);
        }

        $this->optionsValues = $options->pluck('value')->toArray();

        if ($this->value != null) {
            $selectedOption = $this->selectedOption($this->value);
        }

        return view('live-select::default')
        ->with([
            'options' => $options,
            'selectedOption' => $selectedOption ?? null,
            #'shouldShow' => $shouldShow,
            #'styles' => $styles,
        ]);
    }

    //
    public function selectedOption($value)
    {
        return null;
    }
}