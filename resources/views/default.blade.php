<div
        wire:ignore
        x-data="liveSelect({ 'name': '{{$name}}', 'model': '{{$model}}', initialData: {{json_encode($options)}}, emptyOptionsMessage: '{{$emptyOptionMessage}}', placeholder: '{{$placeholder}}', 'loadingMessage': '{{$loadingMessage}}', 'value': @if($value) '{{$value}}' @else null @endif })"
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
                <span x-text="'{{$noneMessage}}'" class="block font-normal truncate" 
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