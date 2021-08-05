window.liveSelect = (config) => {
    return {
        initialData: config.initialData,
        emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',
        loadingMessage: config.loadingMessage ?? 'Loading...',
        focusedOptionIndex: null,
        name: config.name,
        model: config.model,
        open: false,
        loading: false,
        options: {},
        placeholder: config.placeholder ?? 'Select an option',
        search: '',
        value: config.value,
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
            this.$wire.emitUp(`${this.model}Updated`, this.value)
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