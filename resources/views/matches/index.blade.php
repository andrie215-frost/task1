@extends('layouts.app')

@section('title', 'Matching - SkillMatch')

@section('content')


{{-- =========================================================
     HEADER
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h1 class="h3 mb-2">
        {{ $user->role === 'company'
            ? 'Find Skilled People'
            : 'Find Jobs' }}
    </h1>

    <p class="text-secondary mb-1">

        @if ($user->role === 'company')

            Enter the type of worker you are currently
            looking for. Required skills are optional.

        @else

            Tell SkillMatch what type of opportunity
            you are currently looking for.

        @endif

    </p>

    <div class="small text-secondary">
        Position, location, and job type options are managed
        by the administrator.
    </div>

</div>



{{-- =========================================================
     MATCHING FORM
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4">

    <form
        method="POST"
        action="{{ route('matches.find') }}"
    >
        @csrf



        {{-- =====================================================
             POSITION / ROLE
             ===================================================== --}}
        <div class="mb-4 position-autocomplete">

            <label
                for="position"
                class="form-label fw-semibold"
            >
                {{ $user->role === 'company'
                    ? 'Position / Role Needed'
                    : 'Desired Position / Role' }}
            </label>


            <div class="position-autocomplete-wrapper">

                <input
                    id="position"
                    name="position"
                    type="text"
                    class="form-control
                           @error('position')
                               is-invalid
                           @enderror"
                    value="{{ old('position') }}"
                    placeholder="Start typing a position..."
                    autocomplete="off"
                    required
                >


                <div
                    id="positionSuggestions"
                    class="position-suggestions"
                ></div>

            </div>


            @error('position')

                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>

            @enderror

        </div>



        {{-- =====================================================
             LOCATION + JOB TYPE
             ===================================================== --}}
        <div class="row g-3 mb-4">


            {{-- LOCATION --}}
            <div class="col-12 col-md-6">

                <label
                    for="location"
                    class="form-label fw-semibold"
                >
                    {{ $user->role === 'company'
                        ? 'Preferred Worker Location'
                        : 'Preferred Location' }}
                </label>


                <div class="position-autocomplete-wrapper">

                    <input
                        id="location"
                        name="location"
                        type="text"
                        class="form-control
                               @error('location')
                                   is-invalid
                               @enderror"
                        value="{{ old('location') }}"
                        placeholder="Start typing a location..."
                        autocomplete="off"
                        required
                    >


                    <div
                        id="locationSuggestions"
                        class="position-suggestions"
                    ></div>

                </div>


                @error('location')

                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- JOB TYPE --}}
            <div class="col-12 col-md-6">

                <label
                    for="job_type"
                    class="form-label fw-semibold"
                >
                    Job Type
                </label>


                <select
                    id="job_type"
                    name="job_type"
                    class="form-select
                           @error('job_type')
                               is-invalid
                           @enderror"
                    required
                >

                    <option value="">
                        Select job type
                    </option>


                    @foreach ($jobTypeOptions as $jobType)

                        <option
                            value="{{ $jobType }}"
                            @selected(
                                old('job_type') === $jobType
                            )
                        >
                            {{ $jobType }}
                        </option>

                    @endforeach

                </select>


                @error('job_type')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror


                @if ($jobTypeOptions->isEmpty())

                    <div class="form-text text-danger">
                        No active job types are currently available.
                    </div>

                @endif

            </div>

        </div>



        {{-- =====================================================
             EXPERIENCE
             ===================================================== --}}
        <div class="mb-4">

            <label
                for="experience"
                class="form-label fw-semibold"
            >
                {{ $user->role === 'company'
                    ? 'Minimum Experience Required'
                    : 'Your Years of Experience' }}
            </label>


            <div class="input-group">

                <input
                    id="experience"
                    name="experience"
                    type="number"
                    min="0"
                    max="60"
                    class="form-control
                           @error('experience')
                               is-invalid
                           @enderror"
                    value="{{ old('experience', 0) }}"
                    required
                >

                <span class="input-group-text">
                    Years
                </span>


                @error('experience')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-text">

                @if ($user->role === 'company')

                    Enter 0 if the position does not require
                    previous work experience.

                @else

                    Enter your years of experience.
                    Use 0 for entry-level opportunities.

                @endif

            </div>

        </div>



        {{-- =====================================================
             SKILLS
             ===================================================== --}}
        <div class="mb-4">

            @include('partials.skill-picker', [

                'pickerId' => 'matchingSkills',

                'pickerSkills' => $skills,

                'selectedIds' => old(
                    'skill_ids',
                    []
                ),

                'pickerTitle' =>
                    $user->role === 'company'
                        ? 'Required Skills'
                        : 'Skills You Want to Use',

                'pickerHelp' =>
                    $user->role === 'company'
                        ? 'Optional. Search and select skills you want the worker to have.'
                        : 'Optional. Search and select skills you want to use in a job.',

            ])


            @error('skill_ids')

                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>

            @enderror


            @error('skill_ids.*')

                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>

            @enderror

        </div>



        {{-- =====================================================
             SUBMIT
             ===================================================== --}}
        <div class="border-top pt-4">

            <button
                type="submit"
                class="btn btn-primary"
            >

                {{ $user->role === 'company'
                    ? 'Find Skilled People'
                    : 'Find Jobs' }}

            </button>

        </div>

    </form>

</div>



{{-- =========================================================
     POSITION + LOCATION AUTOCOMPLETE
     ========================================================= --}}
<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
         * Data supplied by MatchController.
         */
        const positions =
            @json($positionSuggestions->values());

        const locations =
            @json($locationSuggestions->values());


        /*
         * Reusable autocomplete.
         */
        function setupAutocomplete(
            inputId,
            suggestionsId,
            items,
            emptyMessage
        ) {

            const input =
                document.getElementById(inputId);

            const suggestionsBox =
                document.getElementById(
                    suggestionsId
                );


            if (!input || !suggestionsBox) {
                return;
            }


            function hideSuggestions() {

                suggestionsBox.innerHTML = '';

                suggestionsBox.classList.remove(
                    'show'
                );
            }


            function showSuggestions(
                searchValue
            ) {

                const search =
                    searchValue
                        .trim()
                        .toLowerCase();


                if (search === '') {

                    hideSuggestions();

                    return;
                }


                /*
                 * Contains matching.
                 *
                 * "sof"
                 * -> Manager Software
                 *
                 * "tab"
                 * -> Tabunok Hilongos Leyte
                 */
                const matches =
                    items

                        .filter(
                            function (item) {

                                return item
                                    .toLowerCase()
                                    .includes(search);

                            }
                        )

                        .slice(0, 8);


                suggestionsBox.innerHTML = '';


                if (matches.length === 0) {

                    const empty =
                        document.createElement(
                            'div'
                        );


                    empty.className =
                        'position-suggestion-empty';


                    empty.textContent =
                        emptyMessage;


                    suggestionsBox.appendChild(
                        empty
                    );


                    suggestionsBox.classList.add(
                        'show'
                    );


                    return;
                }


                matches.forEach(
                    function (item) {

                        const option =
                            document.createElement(
                                'button'
                            );


                        option.type =
                            'button';


                        option.className =
                            'position-suggestion-item';


                        option.textContent =
                            item;


                        option.addEventListener(
                            'click',
                            function () {

                                input.value =
                                    item;


                                hideSuggestions();


                                input.focus();

                            }
                        );


                        suggestionsBox.appendChild(
                            option
                        );

                    }
                );


                suggestionsBox.classList.add(
                    'show'
                );
            }


            /*
             * Search while typing.
             */
            input.addEventListener(
                'input',
                function () {

                    showSuggestions(
                        input.value
                    );

                }
            );


            /*
             * Show suggestions again
             * when returning to the field.
             */
            input.addEventListener(
                'focus',
                function () {

                    if (
                        input.value
                            .trim() !== ''
                    ) {

                        showSuggestions(
                            input.value
                        );

                    }

                }
            );


            /*
             * Close when clicking outside.
             */
            document.addEventListener(
                'click',
                function (event) {

                    if (
                        !input.contains(
                            event.target
                        )
                        &&
                        !suggestionsBox.contains(
                            event.target
                        )
                    ) {

                        hideSuggestions();

                    }

                }
            );

        }


        /*
         * Position autocomplete.
         */
        setupAutocomplete(
            'position',
            'positionSuggestions',
            positions,
            'No matching positions found'
        );


        /*
         * Location autocomplete.
         */
        setupAutocomplete(
            'location',
            'locationSuggestions',
            locations,
            'No matching locations found'
        );

    }
);

</script>

@endsection