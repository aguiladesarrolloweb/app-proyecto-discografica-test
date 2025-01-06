<div 
    x-data="select2({ 
        options: {{ json_encode($options) }}, 
        placeholder: '{{ $placeholder }}' 
    })" 
    class="dropdown relative"
>
    <!-- Input de búsqueda -->
    <input
        type="text"
        x-model="search"
        @focus="openDropdown"
        @input="filterOptions"
        class="dropdown-input border border-gray-300 rounded px-4 py-2 w-full"
        :placeholder="placeholder"
    >

    <!-- Menú desplegable -->
    <ul
        x-show="isOpen"
        class="dropdown-menu absolute bg-white border border-gray-300 rounded mt-1 z-10 w-full"
        @mousedown.away="closeDropdown"
    >
        <!-- Opciones filtradas -->
        <template x-for="(option, index) in filteredOptions" :key="index">
            <li
                :class="{ 'bg-gray-200': selectedIndex === index }"
                class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-200"
                @click="selectOption(option)"
                @mouseover="selectedIndex = index"
            >
                <span x-text="option.label"></span>
            </li>
        </template>
        <!-- Mensaje cuando no hay resultados -->
        <li x-show="!filteredOptions.length" class="dropdown-item px-4 py-2 text-gray-500">
            No se encontraron resultados.
        </li>
    </ul>

    <!-- Campo oculto para enviar el valor seleccionado -->
    <input type="hidden" :value="selectedValue" name="{{ $name }}">
</div>

<script>
    function select2({ options, placeholder }) {
        return {
            isOpen: false,
            search: '',
            options: options ?? [],
            filteredOptions: [],
            selectedIndex: -1,
            selectedValue: null,
            placeholder: placeholder ?? 'Selecciona una opción',

            // Métodos principales
            init() {
                this.filteredOptions = this.options;
            },
            openDropdown() {
                this.isOpen = true;
            },
            closeDropdown() {
                this.isOpen = false;
            },
            filterOptions() {
                // Normaliza el texto eliminando acentos, diéresis y diferencias entre mayúsculas/minúsculas
                const normalize = (str) => str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                const search = normalize(this.search);

                this.filteredOptions = this.options.filter(option => 
                    normalize(option.label).includes(search)
                );
                this.selectedIndex = -1;
            },
            selectOption(option) {
                this.search = option.label;
                this.selectedValue = option.value;
                this.closeDropdown();
            },
        };
    }
</script>
