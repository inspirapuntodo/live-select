<div
        wire:ignore
        x-data="select{{$name}}({ initialData: {{json_encode($options)}}, emptyOptionsMessage: 'Sin resultados para esta búsqueda.', name: '{{$name}}', placeholder: 'Seleccionar opción' })"
        x-init="init()"
        @click.away="closeListbox()"
        @keydown.escape="closeListbox()"
        class="relative mt-2"
>
        <span class="inline-block w-full rounded-md shadow-sm">
                <button
                        type="button"
                        x-ref="button"
                        @click="toggleListboxVisibility()"
                        :aria-expanded="open"
                        aria-haspopup="listbox"
                        class="relative cursor-pointer z-0 w-full p-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 {!!$disabled ? 'cursor-not-allowed" disabled' : 'cursor-default"'!!}
                >
                    <span
                            x-show="! open"
                            x-text="value in options ? options[value] : {{$nullable ? ('\''.__('general.none').'\'') : 'placeholder'}}"
                            :class="{ 'text-gray-500': !(value in options || {{$nullable ? 'true' : 'false'}}) }"
                            class="block truncate"
                    ></span>

                    <input
                            x-ref="search"
                            x-show="open"
                            x-model="search"
                            @keydown.enter.stop.prevent="selectOption()"
                            @keydown.arrow-up.prevent="focusPreviousOption()"
                            @keydown.arrow-down.prevent="focusNextOption()"
                            type="search"
                            class="w-full h-full form-control focus:outline-none"
                    />

                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </button>
        </span>

    <div
            x-show="open"
            x-cloak
            class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg"
    >
        <ul
                x-ref="listbox"
                @keydown.enter.stop.prevent="selectOption()"
                @keydown.arrow-up.prevent="focusPreviousOption()"
                @keydown.arrow-down.prevent="focusNextOption()"
                role="listbox"
                :aria-activedescendant="focusedOptionIndex ? name + 'Option' + focusedOptionIndex : null"
                tabindex="-1"
                class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5"
        >
            @if ($nullable)
            <li :id="name + 'Option' + focusedOptionIndex" @click="selectOption()" @mouseenter="focusedOptionIndex = -1" @mouseleave="focusedOptionIndex = null"
                    role="option" :aria-selected="focusedOptionIndex === -1" class="relative cursor-pointer py-2 pl-3 text-gray-900 cursor-default select-none pr-9"
                    :class="{ 'text-white bg-indigo-600': focusedOptionIndex === -1, 'text-gray-900': focusedOptionIndex !== -1 }" x-ref="nullableOption">
                <span x-text="'{{__('general.none')}}'" class="block font-normal truncate" 
                    :class="{ 'font-semibold': focusedOptionIndex === -1, 'font-normal': focusedOptionIndex !== -1 }">
                </span>
                <span x-show="value === null" class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                        :class="{ 'text-white': focusedOptionIndex === -1, 'text-indigo-600': focusedOptionIndex !== -1 }">
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
            </li>
            @endif
  
            <template x-for="(key, index) in Object.keys(options)" :key="index">
                <li
                        :id="name + 'Option' + focusedOptionIndex"
                        @click="selectOption()"
                        @mouseenter="focusedOptionIndex = index"
                        @mouseleave="focusedOptionIndex = null"
                        role="option"
                        x-show="!loading"
                        :aria-selected="focusedOptionIndex === index"
                        :class="{ 'text-white bg-indigo-600': index === focusedOptionIndex, 'text-gray-900': index !== focusedOptionIndex }"
                        class="relative cursor-pointer py-2 pl-3 text-gray-900 cursor-default select-none pr-9"
                >
                        <span x-text="Object.values(options)[index]"
                                :class="{ 'font-semibold': index === focusedOptionIndex, 'font-normal': index !== focusedOptionIndex }"
                                class="block font-normal truncate"
                        ></span>

                    <span
                            x-show="key === value"
                            :class="{ 'text-white': index === focusedOptionIndex, 'text-indigo-600': index !== focusedOptionIndex }"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                    >
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"/>
                            </svg>
                        </span>
                </li>
            </template>

            <div
                    x-show="loading"
                    x-text="loadingMessage"
                    class="px-3 py-2 text-gray-900 cursor-default select-none"></div>
            <div
                    x-show="!loading && !Object.keys(options).length"
                    x-text="emptyOptionsMessage"
                    class="px-3 py-2 text-gray-900 cursor-default select-none"></div>
        </ul>
    </div>
</div>

<script>
    window.select{{$name}} = function(config) {
        return {
            initialData: config.initialData,
            emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',
            loadingMessage: config.loadingMessage ?? 'Loading...',
            focusedOptionIndex: null,
            name: config.name,
            open: false,
            loading: false,
            options: {},
            placeholder: config.placeholder ?? 'Select an option',
            search: '',
            value: null,
            closeListbox: function () {
                this.open = false
                this.focusedOptionIndex = null
                this.search = ''
            },
            focusNextOption: function () {
                if (this.focusedObjectIndex === null) return this.focusedObjectIndex = Object.keys(this.options).length - 1
                if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return
                this.focusedOptionIndex++
                this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                    block: "center",
                })
            },

            focusPreviousOption: function () {
                if (this.focusedObjectIndex === null) return this.focusedObjectIndex = 0
                if (this.focusedOptionIndex <= 0) return
                this.focusedOptionIndex--
                this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                    block: "center",
                })
            },

            init: function () {
                this.options = this.initialData
                this.value = this.$wire.{{$model}}

                if (!(this.value in this.options)) {
                    this.value = null
                }

                this.$watch('search', ( async (value) => {
                    if (!this.open || !value) {
                        this.options = this.initialData
                        return
                    }

                    if(this.$wire.searchable) {
                        this.loading = true
                        const optionsResult = (await this.$wire.options(value))
                        this.options = {}

                        for(var key in optionsResult) {
                            this.options[key] = optionsResult[key]
                        }

                        this.loading = false
                        return
                    }

                    this.options = Object.keys(this.initialData)
                        .filter((key) => this.initialData[key].toLowerCase().includes(value.toLowerCase()))
                        .reduce((options, key) => {
                            options[key] = this.initialData[key]
                            return options
                        }, {})
                }))
            },

            selectOption: function () {
                if (!this.open) return this.toggleListboxVisibility()
                this.value = Object.keys(this.options)[this.focusedOptionIndex]
                this.$wire.emit('{{$model}}Updated', [ this.value, this.name ])
                this.initialData[this.value] = this.options[this.value]
                this.closeListbox()
            },

            toggleListboxVisibility: function () {

                this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value)

                if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

                this.open = true

                this.$nextTick(() => {
                    this.$refs.search.focus()
                    if (this.focusedOptionIndex === -1 && this.$refs.nullableOption != null) {
                        this.$refs.nullableOption.scrollIntoView({
                            block: "nearest"
                        })
                    } else {
                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "nearest"
                        })
                    }
                })
            },
        }
    }
</script>