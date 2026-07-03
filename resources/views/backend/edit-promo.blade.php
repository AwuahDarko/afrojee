@extends('backend.layouts.app')

@section('title', 'Edit Promo')

@section('content')
@php
    $startAt = \Carbon\Carbon::parse($promo->start_at);
    $endAt = \Carbon\Carbon::parse($promo->end_at);
    $isActive = (int) $promo->status === 1;
    $now = \Carbon\Carbon::now();
    $isLive = $isActive && $now->between($startAt, $endAt);
@endphp

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3 afrojee-spaceout afrojee-row">
                        <div>
                            <h6 class="text-white text-capitalize mb-0">Edit Promo</h6>
                            <p class="text-white text-sm opacity-8 mb-0">{{ $promo->name }}</p>
                        </div>
                        <a href="{{ route('admin.promos') }}" class="text-white text-sm pe-1">
                            <i class="fas fa-arrow-left me-1"></i> Back to all promos
                        </a>
                    </div>
                </div>

                <div class="card-body px-4 pt-4">
                    <div class="row g-4">
                        {{-- Instructions --}}
                        <div class="col-lg-4">
                            <div class="promo-guide p-3 h-100">
                                <h6 class="mb-2">How promos work</h6>
                                <p class="text-sm text-muted mb-3">
                                    A promo reduces the price of selected products for customers during a date range. Saving here updates the promo — it does not turn it on or off.
                                </p>
                                <ol class="text-sm text-muted mb-3">
                                    <li><strong>Name</strong> — Internal label (shown in admin only).</li>
                                    <li><strong>Schedule</strong> — Start must be before end. Times use 24-hour format (e.g. 09:00, 18:30).</li>
                                    <li><strong>Discount</strong> — Choose <em>Percentage</em> (e.g. 15 = 15% off) or <em>Fixed amount</em> (e.g. 5 = {{ app_currency() }} 5 off the product price).</li>
                                    <li><strong>Products</strong> — Click the box, search, and select every product this promo should apply to. At least one is required.</li>
                                    <li><strong>Activate</strong> — After saving, go to <a href="{{ route('admin.promos') }}">All Promos</a> and click <strong>Activate</strong>. Inactive promos never apply on the storefront.</li>
                                </ol>
                                <p class="text-sm text-muted mb-0">
                                    <strong>To create a new promo:</strong> use <a href="{{ route('admin.promos.create') }}">Add New</a> on the promos list, fill the same fields, save, then activate it.
                                </p>
                            </div>
                        </div>

                        {{-- Form --}}
                        <div class="col-lg-8">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                                @if ($isLive)
                                    <span class="badge bg-gradient-success">Live now</span>
                                @elseif ($isActive)
                                    <span class="badge bg-gradient-info">Active — outside schedule</span>
                                @else
                                    <span class="badge bg-gradient-secondary">Inactive</span>
                                @endif
                                <span class="text-xs text-muted">
                                    @if (!$isActive)
                                        Customers will not see this discount until you activate it from the promos list.
                                    @elseif ($now->lt($startAt))
                                        Scheduled — starts {{ $startAt->format('M j, Y H:i') }}.
                                    @elseif ($now->gt($endAt))
                                        Expired — ended {{ $endAt->format('M j, Y H:i') }}.
                                    @else
                                        Running until {{ $endAt->format('M j, Y H:i') }}.
                                    @endif
                                </span>
                            </div>

                            <form method="POST" action="{{ route('admin.promos.edit') }}" class="promo-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $promo->id }}">

                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-3">Basic details</h6>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Promo name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" required value="{{ old('name', $promo->name) }}"
                                        placeholder="e.g. Summer sale 15%">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">For your reference in the admin panel.</div>
                                </div>

                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-3">Schedule</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Start date <span class="text-danger">*</span></label>
                                        <input class="form-control @error('startdate') is-invalid @enderror" name="startdate"
                                            type="date" value="{{ old('startdate', $startAt->format('Y-m-d')) }}" required>
                                        @error('startdate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Start time <span class="text-danger">*</span></label>
                                        <input class="form-control timepicker @error('starttime') is-invalid @enderror"
                                            name="starttime" type="text" required
                                            value="{{ old('starttime', $startAt->format('H:i')) }}"
                                            placeholder="HH:mm" autocomplete="off">
                                        @error('starttime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">End date <span class="text-danger">*</span></label>
                                        <input class="form-control @error('enddate') is-invalid @enderror" name="enddate"
                                            type="date" value="{{ old('enddate', $endAt->format('Y-m-d')) }}" required>
                                        @error('enddate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">End time <span class="text-danger">*</span></label>
                                        <input class="form-control timepicker2 @error('endtime') is-invalid @enderror"
                                            name="endtime" type="text" required
                                            value="{{ old('endtime', $endAt->format('H:i')) }}"
                                            placeholder="HH:mm" autocomplete="off">
                                        @error('endtime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-3">Discount</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="discount" class="form-label">Amount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                            id="discount" name="discount" required min="0" step="0.01"
                                            value="{{ old('discount', $promo->discount) }}" placeholder="e.g. 15 or 5.00">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="discount_type" class="form-label">Type <span class="text-danger">*</span></label>
                                        <select name="discount_type" id="discount_type"
                                            class="form-control @error('discount_type') is-invalid @enderror" required>
                                            <option value="" disabled {{ old('discount_type', $promo->discount_type) ? '' : 'selected' }}>
                                                Choose discount type
                                            </option>
                                            <option value="percent" @selected(old('discount_type', $promo->discount_type) === 'percent')>
                                                Percentage (% off)
                                            </option>
                                            <option value="fixed" @selected(old('discount_type', $promo->discount_type) === 'fixed')>
                                                Fixed amount ({{ app_currency() }} off)
                                            </option>
                                        </select>
                                        @error('discount_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-3">Products</h6>
                                <div class="mb-4">
                                    <label class="form-label">Included products <span class="text-danger">*</span></label>
                                    <div class="wrapper promo-multiselect" id="multiselect">
                                        <div class="select-box" tabindex="0" role="combobox" aria-expanded="false" aria-haspopup="listbox">
                                            <span class="placeholder">Click to select products…</span>
                                        </div>
                                        <div class="menu" role="listbox">
                                            <input class="search" type="text" placeholder="Search products…" aria-label="Search products">
                                            <ul>
                                                @foreach ($products as $product)
                                                    <li class="{{ in_array($product->id, $productIdArr) ? 'selected' : '' }}"
                                                        data-value="{{ $product->id }}">{{ $product->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <input type="hidden" name="products" required>
                                    </div>
                                    @error('products')
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Only active products are listed. Click a selected item again to remove it, or use × on the tag.</div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 pt-2">
                                    <button type="submit" class="btn bg-gradient-dark mb-0">
                                        <i class="fas fa-save me-1"></i> Save changes
                                    </button>
                                    <a href="{{ route('admin.promos') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
                                    @if ($isActive)
                                        <a href="{{ route('admin.promos.deactivate', ['id' => $promo->id]) }}"
                                            class="btn btn-outline-danger mb-0 ms-lg-auto">Deactivate</a>
                                    @else
                                        <a href="{{ route('admin.promos.activate', ['id' => $promo->id]) }}"
                                            class="btn btn-outline-success mb-0 ms-lg-auto">Activate promo</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body px-4 py-3">
                    <h6 class="mb-2">Current summary</h6>
                    <ul class="mb-0 small text-muted">
                        <li><strong>{{ count($productIdArr) }}</strong> product(s) linked to this promo.</li>
                        <li>Discount: <strong>{{ $promo->discount }}</strong>
                            {{ $promo->discount_type === 'percent' ? '%' : app_currency() }} off each selected product.</li>
                        <li>Valid from <strong>{{ $startAt->format('M j, Y H:i') }}</strong> to <strong>{{ $endAt->format('M j, Y H:i') }}</strong>.</li>
                        <li>Status: <strong>{{ $isActive ? 'Active' : 'Inactive' }}</strong>
                            @if ($isLive) — visible to customers now.@endif
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        minTime: '00:00',
        maxTime: '23:59',
        defaultTime: '{{ $startAt->format('H:i') }}',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('.timepicker2').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        minTime: '00:00',
        maxTime: '23:59',
        defaultTime: '{{ $endAt->format('H:i') }}',
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
    let selected = JSON.parse('{!! json_encode($productNames) !!}');
    let selectedValue = [{{ $productIds }}];

    function trimLabel(text) {
        return text.trim();
    }

    function renderTags() {
        box.innerHTML = '';
        if (!selected.length) {
            box.innerHTML = '<span class="placeholder">Click to select products…</span>';
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
            remove.setAttribute('aria-label', 'Remove ' + text);
            remove.onclick = e => {
                e.stopPropagation();
                const idx = selected.indexOf(text);
                if (idx > -1) {
                    selectedValue.splice(idx, 1);
                    selected.splice(idx, 1);
                }
                renderTags();
                updateList();
            };
            tag.appendChild(remove);
            box.appendChild(tag);
        });
        hidden.value = selectedValue.join(',');
    }

    function updateList() {
        items.forEach(li => {
            const label = trimLabel(li.textContent);
            li.classList.toggle('selected', selected.includes(label));
        });
    }

    box.onclick = () => {
        const open = menu.classList.toggle('show');
        box.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) search.focus();
    };

    items.forEach(li => li.onclick = () => {
        const val = li.getAttribute('data-value');
        const text = trimLabel(li.textContent);
        const idx = selected.indexOf(text);

        if (idx > -1) {
            selected.splice(idx, 1);
            selectedValue.splice(idx, 1);
        } else {
            selected.push(text);
            selectedValue.push(val);
        }

        renderTags();
        updateList();
    });

    search.onkeyup = e => {
        e.stopPropagation();
        const term = search.value.toLowerCase();
        items.forEach(li =>
            li.classList.toggle('hidden', !trimLabel(li.textContent).toLowerCase().includes(term)));
    };

    document.addEventListener('click', e => {
        if (!wrapper.contains(e.target)) {
            menu.classList.remove('show');
            box.setAttribute('aria-expanded', 'false');
        }
    });

    renderTags();
    updateList();
</script>
@endsection
