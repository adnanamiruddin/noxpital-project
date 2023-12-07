@extends('dashboard.template')

@section('header')
    Tambah Rekam Medis
@endsection

@section('content')
    <style>
        .suggestions-container {
            position: absolute;
            max-height: 150px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            background-color: #fff;
            z-index: 1000;
        }

        .suggestions-container::-webkit-scrollbar {
            width: 6px;
        }

        .suggestions-container::-webkit-scrollbar-thumb {
            background-color: transparent;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>

    <form method="POST" action="{{ route('medical-records') }}">
        @csrf
        <div class="mb-6 flex justify-between items-center gap-3">
            <div class="w-9/12">
                <label for="email_patient" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Email Pasien
                </label>
                <input type="email" id="email_patient" name="email_patient"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="pasien@gmail.com ..." required>
            </div>

            <div class="w-3/12">
                <label for="created_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                <input type="date" id="created_at" name="created_at"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
            </div>
        </div>

        <div class="mb-6">
            <label for="action" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Tindakan / Aksi
            </label>
            <textarea id="action" name="action" rows="5"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Parasetamol merupakan obat..." required></textarea>
        </div>

        <div id="medicine-list"></div>

        <button type="button" onclick="addMedicineForm()"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 me-2">
            Tambah Obat
        </button>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Simpan
        </button>
    </form>

    <script>
        let medicines = @json($medicines);

        const showMedicineSuggestions = (inputElement) => {
            const inputText = inputElement.value.toLowerCase();
            const suggestionsContainer = inputElement.nextElementSibling;

            while (suggestionsContainer.firstChild) {
                suggestionsContainer.removeChild(suggestionsContainer.firstChild);
            }

            const matchingMedicines = medicines.filter(medicine =>
                medicine.name.toLowerCase().includes(inputText)
            );

            matchingMedicines.forEach(matchingMedicine => {
                const suggestionItem = document.createElement('div');
                suggestionItem.textContent = matchingMedicine.name;
                suggestionItem.classList.add('suggestion-item');
                suggestionItem.addEventListener('click', () => {
                    inputElement.value = matchingMedicine.name;
                    suggestionsContainer.innerHTML = '';
                });
                suggestionsContainer.appendChild(suggestionItem);

                const stockInfo = document.createElement('span');
                stockInfo.textContent = ` (Stok: ${matchingMedicine.stock})`;
                stockInfo.classList.add('text-gray-500', 'text-sm');
                suggestionItem.appendChild(stockInfo);
            });
            document.addEventListener('click', handleDocumentClick);
        }

        const handleDocumentClick = (event) => {
            const suggestionsContainers = document.querySelectorAll('.suggestions-container');
            suggestionsContainers.forEach(container => {
                if (!container.contains(event.target)) {
                    container.innerHTML = '';
                }
            });
            document.removeEventListener('click', handleDocumentClick);
        }

        let formIndex = 0;

        const addMedicineForm = () => {
            const medicineForms = document.getElementById('medicine-list');

            const newForm = document.createElement('div');
            newForm.classList.add('medicine-form', 'mb-6', 'flex', 'justify-between', 'items-center', 'gap-3');

            const nameInput = createInput('text', `medicines[${formIndex}][name]`, `Nama Obat ke-${formIndex + 1}`,
                'Paracetamol...',
                'w-9/12', 'medicine-name');
            const quantityInput = createInput('number', `medicines[${formIndex}][amount]`,
                `Jumlah Obat ke-${formIndex + 1}`, '1', 'w-3/12', 'medicine-quantity');

            const removeButton = document.createElement('button');
            removeButton.innerText = 'X';
            removeButton.classList.add('mt-5', 'text-white', 'bg-red-700', 'hover:bg-red-900', 'focus:ring-4',
                'focus:outline-none',
                'focus:ring-red-300', 'font-medium', 'rounded-lg', 'text-sm', 'px-4', 'py-2', 'text-center',
                'dark:bg-red-400', 'dark:hover:bg-red-500', 'dark:focus:ring-red-500');
            removeButton.onclick = () => {
                formIndex--;
                newForm.remove();
            };

            newForm.appendChild(nameInput);
            newForm.appendChild(quantityInput);
            newForm.appendChild(removeButton);

            medicineForms.appendChild(newForm);
            formIndex++;
        }

        const createInput = (type, name, label, placeholder, width, inputId) => {
            const inputContainer = document.createElement('div');
            inputContainer.classList.add(width);

            const labelElement = document.createElement('label');
            labelElement.setAttribute('for', name);
            labelElement.classList.add('block', 'mb-2', 'text-sm', 'font-medium', 'text-gray-900', 'dark:text-white');
            labelElement.innerText = label;

            const inputElement = document.createElement('input');
            inputElement.setAttribute('type', type);
            inputElement.setAttribute('name', name);
            inputElement.setAttribute('placeholder', placeholder);
            inputElement.setAttribute('required', 'required');
            inputElement.setAttribute('oninput', `showMedicineSuggestions(this)`);
            inputElement.setAttribute('id', inputId);
            inputElement.setAttribute('autocomplete', 'off');
            inputElement.classList.add('shadow-sm', 'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900',
                'text-sm',
                'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5',
                'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white',
                'dark:focus:ring-blue-500', 'dark:focus:border-blue-500', 'dark:shadow-sm-light');

            const suggestionsContainer = document.createElement('div');
            suggestionsContainer.classList.add('suggestions-container');

            inputContainer.appendChild(labelElement);
            inputContainer.appendChild(inputElement);
            inputContainer.appendChild(suggestionsContainer);
            return inputContainer;
        }
    </script>
@endsection
