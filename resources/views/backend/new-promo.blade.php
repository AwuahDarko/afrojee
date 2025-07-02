@extends('backend.layouts.app')

@section('title')
    New Promo
@endsection

@section('content')


    <div class="container my-auto">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom p-4">

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show text-light" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-light">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <p>Create New Promo</p>
                        <form role="form" class="text-start" method="POST" action="{{ route('admin.promos.store') }}">
                            @csrf

                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" name="name" required
                                    placeholder="Name of promo">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <p class="m-0">Start date and time</p>
                            <div class="input-group input-group-outline my-3">
                                <div>
                                    <input class="form-control" name="startdate" type="date" />
                                    @error('startdate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div style="width: 10px;"></div>
                                <div>
                                    <input class="form-control timepicker" name="starttime" type="text" />
                                    @error('starttime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <p class="m-0">End date and time</p>
                            <div class="input-group input-group-outline my-3">
                                <div>
                                    <input class="form-control" name="enddate" type="date" />
                                    @error('enddate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div style="width: 10px;"></div>
                                <div>
                                    <input class="form-control timepicker" name="endtime" type="text" />
                                    @error('endtime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <input type="number" class="form-control" name="discount" required placeholder="Discount">
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select name="discount_type" class="form-control">
                                    <option value="0">Select discount type</option>
                                    <option value="percent">Percentage</option>
                                    <option value="fixed">Fixed amount</option>
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="wrapper" id="multiselect">
                                <!-- visible “input” area -->
                                <div class="select-box" tabindex="0">
                                    <span class="placeholder">Select…</span>
                                </div>

                                <!-- drop‑down menu -->
                                <div class="menu">
                                    <input class="search" type="text" placeholder="Search…">
                                    <ul>
                                        @foreach ($products as $product )
                                        <li data-value="{{$product->id}}"> {{$product->name}} </li>
                                        @endforeach
                                        
                                    </ul>
                                </div>

                                <!-- value to submit with a form -->
                                <input type="hidden" name="products" required>
                            </div>


                            <div class="text-center mb-4">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        // $('#eventTimePicker').timepicker({ 'step': 15 });
        // $('#eventTimePicker2').timepicker({ 'step': 15 });



        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 1,
            minTime: '0',
            maxTime: '23',
            defaultTime: 'now',
            startTime: '00:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });



        const wrapper = document.getElementById('multiselect');
        const box = wrapper.querySelector('.select-box');
        const menu = wrapper.querySelector('.menu');
        const search = menu.querySelector('.search');
        const items = Array.from(menu.querySelectorAll('li'));
        const hidden = wrapper.querySelector('input[type="hidden"]');
        let selected = [];
        let selectedValue = [];

        function renderTags() {
            box.innerHTML = '';
            if (!selected.length) {
                box.innerHTML = '<span class="placeholder">Select…</span>';
                hidden.value = '';
                return;
            }
            selected.forEach(text => {
                const tag = document.createElement('span');
                tag.className = 'tag';
                tag.textContent = text;
                const remove = document.createElement('span');
                remove.className = 'remove';
                remove.textContent = '×';
                remove.onclick = e => {
                    e.stopPropagation();
                    selected = selected.filter(t => t !== text);
                    renderTags();
                    updateList();
                };
                tag.appendChild(remove);
                box.appendChild(tag);
            });
            hidden.value = selectedValue.join(',');
        }

        function updateList() {
            items.forEach(li =>{
                li.classList.toggle('selected', selected.includes(li.textContent))
                // li.classList.toggle('selected', selected.includes(li.getAttribute('data-value')))
            });
        }

        /* toggle panel */
        box.onclick = () => menu.classList.toggle('show');

        /* pick / un‑pick an option */
        items.forEach(li => li.onclick = () => {
            const val = li.getAttribute('data-value')

            const {
                textContent: text
            } = li;

            selected = selected.includes(text) ?
                selected.filter(t => t !== text) :
                [...selected, text];

            selectedValue = selectedValue.includes(val) ?
                selectedValue.filter(t => t !== val) :
                [...selectedValue, val];

            renderTags();
            updateList();
        });

        /* quick client‑side search */
        search.onkeyup = () => {
            const term = search.value.toLowerCase();
            items.forEach(li =>
                li.classList.toggle('hidden',
                    !li.textContent.toLowerCase().includes(term)));
        };

        /* click outside → close */
        document.addEventListener('click', e => {
            if (!wrapper.contains(e.target)) menu.classList.remove('show');
        });

        renderTags();
    </script>
@endsection
