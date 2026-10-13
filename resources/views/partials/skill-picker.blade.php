@php

    $pickerId = $pickerId ?? 'skillPicker';

    $pickerSkills = $pickerSkills ?? $skills;

    $inputName = $inputName ?? 'skill_ids';

    $selectedIds = collect(
        $selectedIds ?? []
    )
        ->map(fn ($id) => (int) $id)
        ->all();

    $pickerTitle = $pickerTitle ?? 'Skills';

    $pickerHelp = $pickerHelp
        ?? 'Search and select the skills that apply.';

    $categories = $pickerSkills
        ->pluck('category')
        ->filter()
        ->unique()
        ->sort()
        ->values();

@endphp


@once

    <style>

        .sm2-picker {
            border: 1px solid #d9e2ef;
            border-radius: 14px;
            background: #fff;
            overflow: hidden;
        }

        .sm2-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 18px 14px;
            border-bottom: 1px solid #edf1f6;
        }

        .sm2-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #172033;
            margin-bottom: 3px;
        }

        .sm2-help {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .sm2-count {
            flex-shrink: 0;
            padding: 5px 10px;
            border: 1px solid #dbe4f0;
            border-radius: 999px;
            background: #f8fafc;
            color: #53657d;
            font-size: 0.75rem;
            font-weight: 600;
        }


        /* SELECTED SKILLS */

        .sm2-selected-section {
            padding: 14px 18px;
            border-bottom: 1px solid #edf1f6;
            background: #fbfcfe;
        }

        .sm2-selected-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .sm2-selected-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #59697e;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .sm2-clear-selected {
            border: 0;
            background: transparent;
            padding: 0;
            font-size: 0.78rem;
            color: #6c757d;
        }

        .sm2-clear-selected:hover {
            color: #dc3545;
        }

        .sm2-selected-list {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .sm2-selected-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #a9c7ff;
            border-radius: 999px;
            background: #eef5ff;
            color: #1759c2;
            padding: 5px 9px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .sm2-selected-remove {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 17px;
            height: 17px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: inherit;
            padding: 0;
            line-height: 1;
        }

        .sm2-selected-remove:hover {
            background: rgba(13, 110, 253, 0.12);
        }

        .sm2-selected-empty {
            font-size: 0.82rem;
            color: #8995a5;
        }


        /* SEARCH AND CATEGORY */

        .sm2-controls {
            padding: 14px 18px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px;
            gap: 10px;
            border-bottom: 1px solid #edf1f6;
        }

        .sm2-search-wrap {
            position: relative;
        }

        .sm2-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #8995a5;
            pointer-events: none;
        }

        .sm2-search-input {
            width: 100%;
            height: 40px;
            border: 1px solid #ced8e5;
            border-radius: 8px;
            background: #fff;
            padding: 8px 38px 8px 38px;
            font-size: 0.86rem;
            outline: none;
        }

        .sm2-search-input:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }

        .sm2-search-clear {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #7d8998;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .sm2-search-clear:hover {
            background: #f1f4f8;
            color: #212529;
        }

        .sm2-category-select {
            height: 40px;
            border-radius: 8px;
            font-size: 0.86rem;
        }


        /* SKILL LIST */

        .sm2-list-wrapper {
    position: relative;
    height: 306px;
    padding: 8px;
}

.sm2-list {
    height: 100%;
    overflow-y: auto;
    padding: 2px;
}

        .sm2-skill-row {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            padding: 10px 11px;
            border-radius: 8px;
            cursor: pointer;
            transition:
                background-color 0.15s ease,
                border-color 0.15s ease;
        }

        .sm2-skill-row:hover {
            background: #f6f9fd;
        }

        .sm2-skill-row.is-selected {
            background: #f0f6ff;
        }

        .sm2-skill-checkbox {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            margin: 0;
        }

        .sm2-skill-info {
            min-width: 0;
            flex: 1;
        }

        .sm2-skill-name {
            font-size: 0.86rem;
            font-weight: 600;
            color: #26364a;
        }

        .sm2-skill-category {
            margin-top: 1px;
            font-size: 0.72rem;
            color: #8a96a5;
        }

        .sm2-empty {
    position: absolute;
    inset: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 28px 15px;
    color: #7f8c9d;
    font-size: 0.85rem;
    background: #fff;
    border-radius: 8px;
}

.sm2-search-input::-webkit-search-cancel-button {
    -webkit-appearance: none;
    appearance: none;
}


        @media (max-width: 767.98px) {

            .sm2-header {
                padding: 15px;
            }

            .sm2-selected-section {
                padding: 13px 15px;
            }

            .sm2-controls {
                grid-template-columns: 1fr;
                padding: 13px 15px;
            }

            .sm2-list-wrapper {
    height: 276px;
}

        }

    </style>

@endonce


<div
    id="{{ $pickerId }}"
    class="sm2-picker"
>

    {{-- HEADER --}}
    <div class="sm2-header">

        <div>

            <div class="sm2-title">
                {{ $pickerTitle }}
            </div>

            <div class="sm2-help">
                {{ $pickerHelp }}
            </div>

        </div>


        <span
            class="sm2-count"
            data-skill-count
        >
            {{ count($selectedIds) }} selected
        </span>

    </div>


    {{-- SELECTED SKILLS --}}
    <div class="sm2-selected-section">

        <div class="sm2-selected-heading">

            <span class="sm2-selected-label">
                Selected Skills
            </span>

            <button
                type="button"
                class="sm2-clear-selected"
                data-clear-selected
            >
                Clear selected
            </button>

        </div>


        <div
            class="sm2-selected-list"
            data-selected-list
        >
        </div>


        <div
            class="sm2-selected-empty"
            data-selected-empty
        >
            No skills selected yet.
        </div>

    </div>


    {{-- SEARCH + CATEGORY --}}
    <div class="sm2-controls">

        <div class="sm2-search-wrap">

            <span class="sm2-search-icon">

                <svg
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    ></circle>

                    <path
                        d="m20 20-3.5-3.5"
                    ></path>
                </svg>

            </span>


            <input
                type="search"
                class="sm2-search-input"
                placeholder="Search skills..."
                autocomplete="off"
                data-skill-search
            >


            <button
                type="button"
                class="sm2-search-clear"
                aria-label="Clear search"
                data-search-clear
            >
                ×
            </button>

        </div>


        <select
            class="form-select sm2-category-select"
            data-category-select
        >

            <option value="all">
                All Categories
            </option>


            @foreach ($categories as $category)

                <option
                    value="{{ strtolower($category) }}"
                >
                    {{ $category }}
                </option>

            @endforeach

        </select>

    </div>


    {{-- SKILL LIST --}}
    <div class="sm2-list-wrapper">

        <div
            class="sm2-list"
            data-skill-list
        >

            @foreach ($pickerSkills as $skill)

                <label
                    class="sm2-skill-row"
                    data-skill-item
                    data-skill-id="{{ $skill->id }}"
                    data-skill-name="{{ strtolower($skill->name) }}"
                    data-skill-label="{{ $skill->name }}"
                    data-skill-category="{{ strtolower(
                        $skill->category ?? 'other'
                    ) }}"
                    for="{{ $pickerId }}-skill-{{ $skill->id }}"
                >

                    <input
                        id="{{ $pickerId }}-skill-{{ $skill->id }}"
                        name="{{ $inputName }}[]"
                        type="checkbox"
                        value="{{ $skill->id }}"
                        class="form-check-input sm2-skill-checkbox"
                        data-skill-checkbox
                        @checked(
                            in_array(
                                (int) $skill->id,
                                $selectedIds,
                                true
                            )
                        )
                    >


                    <span class="sm2-skill-info">

                        <span class="sm2-skill-name">
                            {{ $skill->name }}
                        </span>


                        <span class="sm2-skill-category d-block">
                            {{ $skill->category ?: 'Other' }}
                        </span>

                    </span>

                </label>

            @endforeach

        </div>


        <div
            class="sm2-empty d-none"
            data-skill-empty
        >
            No skills match your search.
        </div>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const picker =
            document.getElementById(
                @json($pickerId)
            );

        if (!picker) {
            return;
        }


        const searchInput =
            picker.querySelector(
                '[data-skill-search]'
            );

        const searchClear =
            picker.querySelector(
                '[data-search-clear]'
            );

        const categorySelect =
            picker.querySelector(
                '[data-category-select]'
            );

        const countBadge =
            picker.querySelector(
                '[data-skill-count]'
            );

        const selectedList =
            picker.querySelector(
                '[data-selected-list]'
            );

        const selectedEmpty =
            picker.querySelector(
                '[data-selected-empty]'
            );

        const clearSelected =
            picker.querySelector(
                '[data-clear-selected]'
            );

        const emptyMessage =
            picker.querySelector(
                '[data-skill-empty]'
            );

        const skillItems =
            Array.from(
                picker.querySelectorAll(
                    '[data-skill-item]'
                )
            );

        const checkboxes =
            Array.from(
                picker.querySelectorAll(
                    '[data-skill-checkbox]'
                )
            );


        function getSelectedCheckboxes() {

            return checkboxes.filter(
                function (checkbox) {
                    return checkbox.checked;
                }
            );

        }


        function updateRows() {

            skillItems.forEach(
                function (item) {

                    const checkbox =
                        item.querySelector(
                            '[data-skill-checkbox]'
                        );

                    item.classList.toggle(
                        'is-selected',
                        checkbox.checked
                    );

                }
            );

        }


        function updateSelectedSkills() {

            const selected =
                getSelectedCheckboxes();


            countBadge.textContent =
                selected.length + ' selected';


            selectedList.innerHTML = '';


            selectedEmpty.classList.toggle(
                'd-none',
                selected.length > 0
            );


            clearSelected.style.display =
                selected.length > 0
                    ? ''
                    : 'none';


            selected.forEach(
                function (checkbox) {

                    const item =
                        checkbox.closest(
                            '[data-skill-item]'
                        );

                    const chip =
                        document.createElement(
                            'span'
                        );

                    chip.className =
                        'sm2-selected-chip';


                    const name =
                        document.createElement(
                            'span'
                        );

                    name.textContent =
                        item.dataset.skillLabel;


                    const remove =
                        document.createElement(
                            'button'
                        );

                    remove.type = 'button';

                    remove.className =
                        'sm2-selected-remove';

                    remove.innerHTML = '&times;';

                    remove.setAttribute(
                        'aria-label',
                        'Remove '
                        + item.dataset.skillLabel
                    );


                    remove.addEventListener(
                        'click',
                        function () {

                            checkbox.checked = false;

                            refreshPicker();

                        }
                    );


                    chip.appendChild(name);
                    chip.appendChild(remove);

                    selectedList.appendChild(chip);

                }
            );


            updateRows();

        }


        function filterSkills() {

            const search =
                searchInput.value
                    .trim()
                    .toLowerCase();

            const category =
                categorySelect.value;

            let visibleCount = 0;


            skillItems.forEach(
                function (item) {

                    const name =
                        item.dataset.skillName || '';

                    const itemCategory =
                        item.dataset.skillCategory
                        || 'other';


                    const matchesSearch =
                        search === ''
                        ||
                        name.includes(search)
                        ||
                        itemCategory.includes(search);


                    const matchesCategory =
                        category === 'all'
                        ||
                        itemCategory === category;


                    const shouldShow =
                        matchesSearch
                        &&
                        matchesCategory;


                    item.classList.toggle(
                        'd-none',
                        !shouldShow
                    );


                    if (shouldShow) {
                        visibleCount++;
                    }

                }
            );


            emptyMessage.classList.toggle(
                'd-none',
                visibleCount > 0
            );


            searchClear.style.display =
                search !== ''
                    ? 'flex'
                    : 'none';

        }


        function refreshPicker() {

            updateSelectedSkills();

            filterSkills();

        }


        checkboxes.forEach(
            function (checkbox) {

                checkbox.addEventListener(
                    'change',
                    refreshPicker
                );

            }
        );


        searchInput.addEventListener(
            'input',
            filterSkills
        );


        searchInput.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Enter') {
                    event.preventDefault();
                }

            }
        );


        searchClear.addEventListener(
            'click',
            function () {

                searchInput.value = '';

                filterSkills();

                searchInput.focus();

            }
        );


        categorySelect.addEventListener(
            'change',
            filterSkills
        );


        clearSelected.addEventListener(
            'click',
            function () {

                checkboxes.forEach(
                    function (checkbox) {
                        checkbox.checked = false;
                    }
                );

                refreshPicker();

            }
        );


        refreshPicker();

    }
);
</script>